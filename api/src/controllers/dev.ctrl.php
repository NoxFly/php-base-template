<?php

/**
 * @copyright Copyrights (C) 2021 - 2023 NoxFly All rights reserved.
 * @author NoxFly
 * @since 2021
 */

defined('_NOX') or die('401 Unauthorized');


require_once(PATH_TEMPLATES . 'ApiController.php');
require_once(PATH_ENGINE_TEMPLATES . 'Guard.php');


class DevController extends ApiController {
    function __construct() {
        $this->guard = new Guard();
    }

    /**
     * Shows the Router's tree.
     * 
     * @param stdClass $req
     * @param ApiSite $res
     */
    public function GET($req, $res) {
        if($req->env !== 'development') {
            $res->status(404)->send('');
        }

        $res->json($res->getRouter()->getRoutes());
    }
}