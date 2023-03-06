<?php

/**
 * @copyright Copyrights (C) 2021 - 2023 NoxFly All rights reserved.
 * @author NoxFly
 * @since 2021
 */

defined('_NOX') or die('401 Unauthorized');


require_once(PATH_GUARDS . 'API.guard.php');


class ApiPrivilegesGuard extends ApiGuard {
    /**
     * @param mixed $privileges
     */
    protected $privileges;

    /**
     * Eeach parameter is a privilege for the associated method.
     * The privilege must be an integer from :
     * - 0 : none
     * - 1 : anonymous
     * - 2 : user
     * - 4 : admin
     * @param int $pGET
     * @param int $pPOST
     * @param int $pPUT
     * @param int $pDELETE
     */
    function __construct($pGET, $pPOST=NULL, $pPUT=NULL, $pDELETE=NULL) {
        if($pPOST === NULL && $pPUT === NULL && $pDELETE === NULL) {
            $pPOST = $pGET;
            $pPUT = $pGET;
            $pDELETE = $pGET;
        }

        $this->privileges = [
            'GET' => $pGET,
            'POST' => $pPOST,
            'PUT' => $pPUT,
            'DELETE' => $pDELETE
        ];
    }

    /**
     * @param stdClass $req
     * @param ApiSite $res
     * @return bool Either the user has access to this endpoint or not
     */
    public function canActivate($req, $res) {
        $prvlg = $this->privileges[$req->method];

        if(!bitwiseAND($prvlg, UserType::ANONYMOUS)) {
            return parent::canActivate($req, $res)
                && bitwiseAND($prvlg, $req->user->privileges);
        }

        return bitwiseAND($prvlg, $req->user->privileges);
    }
}