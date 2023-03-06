<?php

/**
 * @copyright Copyrights (C) 2021 - 2023 NoxFly All rights reserved.
 * @author NoxFly
 * @since 2021
 */

defined('_NOX') or die('401 Unauthorized');


class AuthenticationService {

    protected $bLogged = false;

    /** @var Database $database */
    protected $database;

	protected $TOKEN_TTL = 86400 * 30 * 1000; // 1 day * 30 from seconds to ms
	protected $tokenSize = 26;

	protected $tokenPrefix = 'NFAPI-';
	protected $salt = 'NFAPI-';


    /**
     * @param Database $db
     */
    function __construct($db) {
        session_start();

        $this->database = $db;
    }


	/**
	 * @return string
	 */
	private function generateRandomToken() {
		return $this->tokenPrefix . generateRandomString($this->tokenSize);
	}


	/**
	 * @param array $query
	 * @return string
	 */
	public function getToken($query) {
		$headers = getallheaders();

		if(array_key_exists('X-Auth-Token', $headers)) {
			return $headers['X-Auth-Token'];
		}
		// Javascript AJAX transforms headers keys to lowercase
		// while some other methods do not.
		else if(array_key_exists('x-auth-token', $headers)) {
			return $headers['x-auth-token'];
		}
		else if(isset($query['api_key'])) {
			return $query['api_key'];
		}

		return NULL;
	}


	/**
	 * Returns either a token that has been created at createdAt
	 * has expired or not.
	 * @param int $createdAt
	 * @return bool
	 */
	private function tokenExpired($createdAt) {
		return !$createdAt || time() - $createdAt >= $this->TOKEN_TTL;
	}

	/**
	 * Changes the password for a given user.
	 * Ensure that the given accountId exists, or it will throw an error.
	 * @param int $accountId
	 * @param string $newPass
	 * @return string
	 */
	public function changePassword($accountId, $newPass=NULL) {
		if(!$newPass) {
			$newPass = generateRandomString(12, true);
		}

		$hash = password_hash($this->salt . $newPass, PASSWORD_DEFAULT);

		$this->database->query(
			'UPDATE `account`
			SET `password` = :pass WHERE `id` = :id',
			[
				'pass' => $hash,
				'id' => $accountId
			]
		);

		return $newPass;
	}

	/**
	 * @param int $accountId
	 * @param string $password
	 */
	public function verifyPasswordById($accountId, $password) {
		$realPass = $this->database->query(
			"SELECT password
			FROM account
			WHERE id = :accountId", [
				"accountId" => $accountId
			]
		)->fetchColumn();

		return $realPass && password_verify($this->salt . $password, $realPass);
	}

	/**
	 * Tries to login the user that has the given login / password.
	 * 
	 * If it succeed, then generate a token and returns it. Adds a row in the database.
	 * If the token already exists :
	 * - if it expired, recreate it
	 * - if not, then don't re-generate it, just send it, and don't add a row.
	 * 
	 * @param string $login
	 * @param string $password
	 */
	public function login($login, $password) {
        $account = $this->database->query(
            'SELECT id, password, token, UNIX_TIMESTAMP(C.created_at) as createdAt
            FROM account A
				LEFT JOIN connection C ON (C.id_account = A.id)
            WHERE mail = :mail',
            [
                'mail' => $login
            ]
        )->fetch();

        if(!$account || !password_verify($this->salt . $password, $account['password'])) {
            return NULL;
        }

        $user = $this->database->query(
			'SELECT *
			FROM account A
				LEFT JOIN USER U ON (U.id_acount = A.id)
			WHERE A.id = :accountId',
			[
            	':accountId' => $account['id']
        	]
		)->fetchObject();

        if($user === false) {
            return NULL;
        }

		//

		// token expired : logout on server side
		if($account['createdAt'] !== NULL && $account['createdAt']) {
			$this->logoutById($user->accountId);
			$account['createdAt'] = NULL;
			$account['token'] = NULL;
		}

		// no token yet : create one
		if($account['token'] === NULL) {
			$token = $this->generateRandomToken();

			$this->database->query(
				'INSERT INTO connection (id_account, token)
					VALUES (:id, :token)',
				[
					'id' => $user->accountId,
					'token' => $token
				]
			);
		}
		else {
			$token = $account['token'];
		}
		

		return [
			'token' => $token,
			'user' => $user
		];
	}

	/**
	 * Log out a user finding him by his id.
	 * 
	 * @param int $id
	 */
	public function logoutById($id) {
		$this->database->query(
			'DELETE FROM connection WHERE id_account = :id',
			[
				'id' => $id
			]
		);
	}

	/**
	 * Log out a user finding him by his token.
	 * 
	 * @param string $token
	 */
	public function logoutByToken($token) {
		$this->database->query(
			'DELETE FROM connection WHERE token = :token',
			[
				'token' => $token
			]
		);
	}

	/**
	 * Verify the token validity of the user who does the request.
	 * If valid: auth him for this request, and returns his basic informations.
	 * If no valid: delete his token, return NULL.
	 * 
	 * @param mixed $query
	 */
    public function refreshStatus($query) {
		$anoObj = (object)array(
			'privileges' => UserType::ANONYMOUS
		);

		$token = $this->getToken($query);

		if(!$token) {
			$this->bLogged = false;
			
			return $anoObj;
		}

		$isAuth = $this->database->query(
			'SELECT token, UNIX_TIMESTAMP(created_at) as createdAt, id_account as id
			FROM connection
			WHERE token = :token',
			[
				'token' => $token
			]
		)->fetch();

		if(!$isAuth) {
			$this->bLogged = false;
			
			return $anoObj;
		}

		// token expired
		if($this->tokenExpired($isAuth['createdAt'])) {
			$this->logoutByToken($token);
			$this->bLogged = false;
			
			return $anoObj;
		}

		$user = $this->database->query(
			'SELECT
				*
			FROM account A
				LEFT JOIN user U ON (U.id_account = A.id)
				-- and some generic infos you will need later...
			WHERE A.id = :accountId',
			[
				'accountId' => $isAuth['id']
			]
		)->fetchObject();

		// remove row from db : user no longer exists
		if(!$user) {
			$this->logoutByToken($token);
			$this->bLogged = false;

			return $anoObj;
		}

		$user->privileges = UserType::USER;

		$this->bLogged = true;

		return $user;
	}

	/**
	 * @param string $accountId
	 * @param array $query coming from Router
	 */
	public function checkTokenValidity($accountId, $query=NULL) {
		$token = $this->getToken($query);

		if(!$token) {
			return false;
		}

		$createdAt = $this->database->query(
			'SELECT UNIX_TIMESTAMP(created_at) as createdAt
			FROM connection
			WHERE id_account = :id
				AND token = :token',
			[
				'id' => $accountId,
				'token' => $token
			]
		)->fetchColumn();

		// token expired
		if($this->tokenExpired($createdAt)) {
			$this->database->query(
				'DELETE FROM connection
				WHERE id_account = :id',
				[
					'id' => $accountId
				]
			);

			return false;
		}

		return true;
	}

	/**
	 * @return bool
	 */
	public function isAuthenticated() {
        return $this->bLogged;
    }
}