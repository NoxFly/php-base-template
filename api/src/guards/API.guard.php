<?php

/**
 * @copyright Copyrights (C) 2021 - 2023 NoxFly All rights reserved.
 * @author NoxFly
 * @since 2021
 */


/*

This guard is designed for the pages of the API.

*/

defined('_NOX') or die('401 Unauthorized');

require_once(PATH_ENGINE_TEMPLATES . 'Guard.php');


class ApiGuard extends Guard {
    /**
     * @param stdClass $req
     * @param ApiSite $res
     */
    public function canActivate($req, $res) {
        return $res->auth()->isAuthenticated();
    }
}