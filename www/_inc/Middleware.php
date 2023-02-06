<?php

/**
 * @copyright Copyrights (C) 2021 - 2023 NoxFly All rights reserved.
 * @author NoxFly
 * @since 2021
 */


defined('_NOX') or die('401 Unauthorized');


interface Middleware {
    public function GET($req, $res);
    public function POST($req, $res);
    public function UPDATE($req, $res);
    public function DELETE($req, $res);
}