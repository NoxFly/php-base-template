<?php

/**
 * @copyright Copyrights (C) 2021 - 2023 NoxFly All rights reserved.
 * @author NoxFly
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

    /**
     * @var string $basePath
     * @var string $protocol
     * @var string $$baseDir
     * @var string $baseUrl
     * @var string $rootUrl
     */
    protected $basePath, $protocol, $baseDir, $baseUrl, $rootUrl;

    function __construct() {
        $this->basePath 	= PATH_PUBLIC;
		$this->protocol 	= (strpos($_SERVER['SERVER_PROTOCOL'], 'HTTPS') === 0)? 'https' : 'http';
		$this->baseDir 	    = str_replace(rtrim(str_replace('/', SEP, $_SERVER['DOCUMENT_ROOT']), SEP), '', $this->basePath);
		$this->rootUrl 	    = str_replace('\\', '/', str_replace(rtrim(str_replace('/', SEP, $_SERVER['DOCUMENT_ROOT']), SEP), '', PATH_ROOT));
		$this->baseUrl		= str_replace('\\', '/', $this->baseDir) . '/';
    }

    /**
     * @return string
     */
    function getRootUrl() {
        return $this->rootUrl;
    }

    /**
     * @return string
     */
    function getBaseUrl() {
        return $this->baseUrl;
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

    function getUrl($page) {
        return $this->protocol . '://' . $_SERVER['HTTP_HOST'] . $this->rootUrl . (($page[0] === '/')? '' : '/') . $page;
    }
}