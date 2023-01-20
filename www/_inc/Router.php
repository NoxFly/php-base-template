<?php

/**
 * @copyright Copyrights (C) 2021 - 2023 Dorian Thivolle All rights reserved.
 * @author Dorian Thivolle
 * @since 2021
 */

defined('_NOX') or die('401 Unauthorized');


class Router {
    // url => filepath from views/ folder (without extension)
    protected $routes = array(
        '/' => 'home',
        '/login' => 'subdir/another-page',
        '/404' => 'errors/404'
    );

    function __construct() {

    }

    /**
     * @param string $page
     */
    function getEndpoint($page) {
        $k = '/' . $page;

        if(array_key_exists($k, $this->routes)) {
            return $this->routes[$k];
        }

        return NULL;
    }
}