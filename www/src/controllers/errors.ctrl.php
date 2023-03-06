<?php

/**
 * @copyright Copyrights (C) 2021 - 2023 NoxFly All rights reserved.
 * @author NoxFly
 * @since 2021
 */

defined('_NOX') or die('401 Unauthorized');


require_once(PATH_ENGINE_TEMPLATES . 'Controller.php');


// uses the default engine guard : canActivate always returns true
class ErrorsController extends Controller {
    /**
     * @param stdClass $req
     * @param WebSite $req
     */
    public function GET($req, $res) {
        $status = $req->page;
        $message = 'An error occured.';

        switch($status) {
            case '404': $message = 'You\'ve lost yourself in the meanders of the web'; break;
        }

        $res->render('errors/error', [
            'statusCode' => $status,
            'message' => $message
        ]);
    }
}