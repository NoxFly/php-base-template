<?php

/**
 * @copyright Copyrights (C) 2021 - 2023 NoxFly All rights reserved.
 * @author NoxFly
 * @since 2021
 */



/*

This guard is designed for the following pages :
    - login
    - logout
    - register

*/

defined('_NOX') or die('401 Unauthorized');

require_once(PATH_ENGINE_TEMPLATES . 'Guard.php');

class AuthGuard extends Guard {
    /**
     * @param stdClass $req
     * @param ApiSite $res
     */
    public function canActivate($req, $res) {
        return !$res->auth()->isAuthenticated()
            xor (
                $req->method === 'GET' ||
                $req->method === 'DELETE'
            );
    }
}