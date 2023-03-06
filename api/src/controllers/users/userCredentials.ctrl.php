<?php

/**
 * @copyright Copyrights (C) 2021 - 2023 NoxFly All rights reserved.
 * @author NoxFly
 * @since 2021
 */

defined('_NOX') or die('401 Unauthorized');


require_once(PATH_TEMPLATES . 'ApiController.php');
require_once(PATH_GUARDS . 'Auth.guard.php');


/**
 * Controlleur 'ouvert' : possibilité de l'appeler sans token.
 * Porte d'entrée pour se connecter, ou vérifier si son token est toujours valable.
 */
class UserCredentialsController extends ApiController {
	function __construct() {
		$this->guard = new AuthGuard();
	}

	/**
     * Verify if the user's token is always ok.
	 * If the given token exists and has expired, it is removed from the database.
	 * 
	 * Returning codes :
     * - 200 OK
	 * 
     * @param stdClass $req
     * @param ApiSite $res
     */
	public function GET($req, $res) {
		$this->sendData($req, $res, 'verifyToken');
	}

	/**
     * Tries to connect the user who requested.
	 * 
	 * Returning codes :
     * - 200 OK
     * - 400 Missing fields
	 * - 401 Wrong identifiers
	 * - 500 Database Error
	 * 
     * @param stdClass $req
     * @param ApiSite $res
     */
    public function POST($req, $res) {
        $this->sendData($req, $res, 'login');
    }

	/**
	 * /!\ Dev Only
	 * Changes the password of the user who has the given email.
	 * No verification done. No security.
	 * 
	 * Returning codes :
	 * - 200 OK
	 * - 400 Missing fields
	 * - 403 Unknown mail
	 * - 500 Database Error
	 * 
	 * @param stdClass $req
	 * @param ApiSite $res
	 */
	public function PUT($req, $res) {
        $this->sendData($req, $res, 'forgotPassword');
    }

	/**
     * Disconnecte a user.
	 * With how is implemented the database, disconnect from all devices.
	 * 
	 * Returning codes :
     * - 200 OK
	 * - 401 Unauthorized
	 * 
     * @param stdClass $req
     * @param ApiSite $res
     */
	public function DELETE($req, $res) {
        $this->sendData($req, $res, 'logout');
	}


    /* -------------------------------------------------------- */


	protected function login($req, $res) {
		if(!isset($req->body['username']) || !isset($req->body['password'])) {
			throw new Exception('400');
		}

		$login = $req->body['username'];
		$password = $req->body['password'];

		//

		if(($this->data = $res->auth()->login($login, $password)) === NULL) {
			throw new Exception('401');
		}
	}

	protected function logout($req, $res) {
		$token = $res->auth()->getToken($req->query);

		if($token) {
			$res->auth()->logoutByToken($token);
		}
	}

	protected function verifyToken($req, $res) {
		$this->data = [
			'ok' => $res->auth()->checkTokenValidity($req->params['id'], $req->body)
		];
	}

	protected function forgotPassword($req, $res)
	{
		$mail = $req->body['mail']?? NULL;

		if(!$mail) {
			throw new Exception('400');
		}

		$accountId = $res->getDatabase()->query(
			'SELECT id FROM `account`
			WHERE `mail` = :mail',
			[
				'mail' => $mail
			]
		)->fetchColumn();

		if (!$accountId)
		{
			throw new Exception("403");
		}

		$this->data['password'] = $res->auth()->changePassword($accountId);
	}
}