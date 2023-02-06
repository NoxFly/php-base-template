<?php

/**
 * @copyright Copyrights (C) 2021 - 2023 NoxFly All rights reserved.
 * @author NoxFly
 * @since 2021
 */

defined('_NOX') or die('401 Unauthorized');


require_once(PATH_INC . SEP . 'Router.php');
require_once(PATH_INC . SEP . 'View.php');



class Site {

    /** @var Router $router */
    protected $router;

    /** @var View $router */
    protected $view;

    

    function __construct($config) {
        $this->router = new Router($config['ROUTES']);
        $this->view = new View($config['APP']);

        $page = '';

        if(!empty($_SERVER['QUERY_STRING'])) {
            $page = preg_replace('#[^a-z0-9\/\-]#', '', $_SERVER['QUERY_STRING']);
            
			// if url ends with / : redirects without it
			if(substr($page, -1) == '/') {
				header('location:' . $this->router->getBaseUrl() . rtrim($page, '/'));
			}
		}

        if(!$this->router->loadEndpoint($page, $this->view)) {
            $this->router->loadEndpoint('404', $this->view);
        }
    }

    /**
     * @return Router
     */
    public function getRouter() {
        return $this->router;
    }
}