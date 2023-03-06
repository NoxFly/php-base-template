<?php

/**
 * @copyright Copyrights (C) 2021 - 2023 NoxFly All rights reserved.
 * @author NoxFly
 * @since 2021
 */

defined('_NOX') or die('401 Unauthorized');


class Guard {
    function __construct() {

    }

    /**
     * @param stdClass $req
     * @param Site $res
     */
    public function canActivate($req, $res) {
        return true;
    }
}