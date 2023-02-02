<?php

/**
 * @copyright Copyrights (C) 2021 - 2023 NoxFly All rights reserved.
 * @author NoxFly
 * @since 2021
 */

defined('_NOX') or die('401 Unauthorized');


require_once(PATH_INC . SEP . 'Router.php');



class Site {

    protected $title = "";
    protected $page = "";
    protected $pagePath = "";
    protected $content = "";

    /** @var Router $router */
    protected $router;

    

    function __construct($config) {
        $this->router = new Router();

        $this->title = $config['website_title'];
        $this->page = $config['home_page'];

        if(!empty($_SERVER['QUERY_STRING'])) {
            $this->page = preg_replace('#[^a-z0-9\/\-]#', '', $_SERVER['QUERY_STRING']);
            
			// if url ends with / : redirects without it
			if(substr($this->page, -1) == '/') {
				header('location:' . $this->router->getBaseUrl() . rtrim($this->page, '/'));
			}
		}

        $this->pagePath = $this->router->getEndpoint($this->page);

        $this->createContent();

        if(preg_match('#<h1>(.*)</h1>#', $this->content, $aMatches) && !empty($aMatches[1])) {
			$this->title = $aMatches[1];
		}
    }


    /**
     * @param string $url
     */
    protected function include($url) {
        if(file_exists($url)) {
            return include($url);
        }

        header('HTTP/1.0 404 Not Found');

        return $this->includePage($this->router->getEndpoint('404'));
    }

    /**
     * @param string $url
     */
    protected function require($url) {
        return require($url);
    }

    protected function createContent() {
		ob_start();
		$this->includePage($this->pagePath);
		$this->content = ob_get_clean();
    }






    /**
     * @param string $url
     */
    public function includePage($url) {
        return $this->include(PATH_VIEWS . SEP . $url . '.php');
    }

    /**
     * @param string $url
     */
    public function includeComponent($url) {
        return $this->require(PATH_PUBLIC . SEP . "components" . SEP . $url);
    }
    
    /**
     * @param string $url
     */
    public function requireComponent($url) {
        return require(PATH_PUBLIC . SEP . "components" . SEP . $url);
    }



    /**
     * @param string $url
     */
    public function includeCSS($filename) {
        echo "<link rel='stylesheet' type='text/css' href='" . (str_replace(PATH_PUBLIC . SEP, '', PATH_ASSET)) . "/css/" . $filename . ".css'>";
    }

    /**
     * @param string $url
     */
    public function includeJS($filename) {
        echo "<script src='js/" . $filename . ".js' type='module'></script>";
    }



    /**
     * @return string
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getContent() {
        return $this->content;
    }

    /**
     * @return Router
     */
    public function getRouter() {
        return $this->router;
    }
}