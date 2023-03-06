<?php

/**
 * @copyright Copyrights (C) 2021 - 2023 NoxFly All rights reserved.
 * @author NoxFly
 * @since 2021
 */


defined('_NOX') or die('401 Unauthorized');


require_once(PATH_ENGINE . './Site.php');
require_once(PATH_SERVICES . 'API.php');
require_once(PATH_SERVICES . 'Database.php');
require_once(PATH_SERVICES . 'Authentication.php');


class ApiSite extends Site {

    /** @var Database $database */
    protected $database;

    /** @var ApiService $api */
	protected $apiService;

    /** @var AuthenticationService $authService */
	protected $authService;

    // Add your services here...

    protected $httpStatus = 200;

    /** @var StdClass */
    public $req;
    /** @var StdClass */
    public $data;

    

    function __construct($config) {
        parent::__construct($config);

        // instantiate services
        $this->database = new Database($config['DATABASE']);
        $this->authService = new AuthenticationService($this->database);
        $this->apiService = new APIService();

        if(!$this->database->connect()) {
            // TODO : Uncomment in the case you use a database
            // die('Failed to connect to the Database.');
        }


        //
        $this->loadPage();
    }




    protected function onPageLoaded($loadResult) {
        if($loadResult !== 0) {
            $status = 401;

            if($this->authService->isAuthenticated()) {
                switch($loadResult) {
                    case 1:
                        $status = 404;
                        break;
                    case 2:
                        $status = 405;
                        break;
                }
            }

            $this->apiService->sendErrorResponse($this, $status);
        }
    }



    /* -------------------------- GETTERS -------------------------- */


    /**
     * @return Database
     */
    public function getDatabase() {
        return $this->database;
    }

    /**
     * @return AuthenticationService
     */
    public function auth() {
        return $this->authService;
    }

    /**
     * @return APIService
     */
    public function api() {
        return $this->apiService;
    }
}