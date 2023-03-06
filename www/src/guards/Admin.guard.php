<?php

/**
 * @copyright Copyrights (C) 2021 - 2023 NoxFly All rights reserved.
 * @author NoxFly
 * @since 2021
 */


/*

This guard is designed for the pages of registered users of type ADMIN.

*/

defined('_NOX') or die('401 Unauthorized');

require_once(PATH_ENGINE_TEMPLATES . 'Guard.php');

class AdminGuard extends Guard {
    /**
     * @param stdClass $req
     * @param WebSite $req
     */
    public function canActivate($req, $res) {
        return bitwiseAND($_SESSION['privileges'], UserType::ADMIN);
    }
}