<?php

/**
 * @copyright Copyrights (C) 2021 - 2023 NoxFly All rights reserved.
 * @author NoxFly
 * @since 2021
 */

defined('_NOX') or die('401 Unauthorized');


class Database {
    protected $host = '';
    protected $port = 0;
    protected $database = '';
    protected $username = '';
    protected $password = '';

    protected $link = NULL;

    function __construct($config) {
        $this->host = $config['HOST'];
        $this->port = $config['PORT'];
        $this->database = $config['DATABASE'];
        $this->username = $config['USERNAME'];
        $this->password = $config['PASSWORD'];
    }


    public function connect() {
        if($this->link !== NULL) {
            echo 'Cannot connect to database : Already connected<br>';
            return true;
        }

		try {
            // PDO is used here but you can adapt.
            $this->link = new PDO("mysql:host=$this->host;port=$this->port;dbname=$this->database", $this->username, $this->password);

            $this->link->setAttribute(PDO::ATTR_STRINGIFY_FETCHES, false);
            $this->link->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

            return true;
		}
        catch(PDOException $e) {
            // TODO : Uncomment in the case you use a database
            //echo "[Database] Error : Failed to connect. " . $e->getMessage() . "<br>";
			return false;
		}
    }

    public function disconnect() {
        $this->link->close();
        $this->link = NULL;
    }

    /**
     * @return bool
     */
    public function isConnected() {
        return $this->link !== NULL;
    }

    /**
     * @param string $req
     * @param array<string, mixed> $data
     */
    public function query($req, $data=[]) {
        return NULL; // TODO : Remove this line if you use a database

        if(!$this->link) {
            return [];
        }

        try {
            $res = $this->link->prepare($req);

            $result = $res->execute($data);

            if($result === false) {
                $errMsg = $this->link->errorInfo();
                throw new Exception('Failed to query (errno ' . intval($this->link->errorCode()) . ') -> ' . join('; ', $errMsg));
            }
        }
        catch(PDOException $e) {
            throw new Exception('500,[Database] PDO Error : ' . $e->getMessage());
        }
        catch(Exception $e) {
            throw new Exception('500,[Database] Error : ' . $e->getMessage());
        }

        return $res;
    }

    public function beginTransaction() {
        $this->link->beginTransaction();
    }

    public function commit() {
        $this->link->commit();
    }

    public function rollBack() {
        $this->link->rollBack();
    }

    public function getLastInsertedId() {
        return $this->link->lastInsertId();
    }
}