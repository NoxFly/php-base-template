<?php

/**
 * @copyright Copyrights (C) 2021 - 2023 NoxFly All rights reserved.
 * @author NoxFly
 * @since 2021
 */

defined('_NOX') or die('401 Unauthorized');


require_once(PATH_TEMPLATES . 'ApiController.php');
require_once(PATH_GUARDS . 'ApiPrivileges.guard.php');


class UserListController extends ApiController {
    function __construct() {
        $this->guard = new ApiPrivilegesGuard(
            UserType::ALL // one parameter over 4 : applies for each methods for this controller
        );
    }

    /**
     * Returning codes :
     * - 200 OK
     * - 500 Database error
     * 
     * @param stdClass $req
     * @param ApiSite $res
     */
    public function GET($req, $res) {
        $this->sendData($req, $res, 'getList');
    }


    /* -------------------------------------------------------- */


    protected function getList($req, $res) {
        if($res->getDatabase()->isConnected()) {
            $this->data = $res->getDatabase()->query(
                'SELECT *
                FROM user U
                LEFT JOIN account A ON (U.id_account = A.id)'
            )->fetchAll(PDO::FETCH_OBJ);
        }

        else {
            $this->data = [
                [
                    'id' => 0,
                    'firstname' => 'John',
                    'lastname' => 'Son',
                    'mail' => 'john.son@gmail.com'
                ],
                [
                    'id' => 0,
                    'firstname' => 'Nox',
                    'lastname' => 'Fly',
                    'mail' => 'nox.fly@gmail.com'
                ]
            ];
        }
    }
}