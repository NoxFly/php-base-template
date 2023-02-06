<?php

/**
 * @copyright Copyrights (C) 2021 - 2023 NoxFly All rights reserved.
 * @author NoxFly
 * @since 2021
 */

 
defined('_NOX') or die('401 Unauthorized');

require_once(PATH_INC . SEP . 'Middleware.php');


class LoginMiddleware implements Middleware {
    function __construct() {
        
    }

    public function GET($req, $res) {
        $res->render($req);
    }

    public function POST($req, $res) {

    }

    public function UPDATE($req, $res) {

    }

    public function DELETE($req, $res) {

    }
}