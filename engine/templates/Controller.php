<?php

/**
 * @copyright Copyrights (C) 2021 - 2023 NoxFly All rights reserved.
 * @author NoxFly
 * @since 2021
 */

defined('_NOX') or die('401 Unauthorized');


require_once('Guard.php');


abstract class Controller {
    public $guard;

    function __construct() {
        $this->guard = new Guard();
    }

    /**
     * @param stdClass $req
     * @param Site $res
     */
    public function GET($req, $res) {}
    /**
     * @param stdClass $req
     * @param Site $res
     */
    public function POST($req, $res) {}
    /**
     * @param stdClass $req
     * @param Site $res
     */
    public function PUT($req, $res) {}
    /**
     * @param stdClass $req
     * @param Site $res
     */
    public function DELETE($req, $res) {}
}