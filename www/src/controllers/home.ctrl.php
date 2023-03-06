<?php

/**
 * @copyright Copyrights (C) 2021 - 2023 NoxFly All rights reserved.
 * @author NoxFly
 * @since 2021
 */

defined('_NOX') or die('401 Unauthorized');


require_once(PATH_ENGINE_TEMPLATES . 'Controller.php');

// uses the default engine guard : canActivate always returns true
class HomeController extends Controller {
    /**
     * @param stdClass $req
     * @param WebSite $req
     */
    public function GET($req, $res) {
        $res->render('home');
    }
}