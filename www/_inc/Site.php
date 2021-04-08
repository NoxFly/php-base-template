<?php

defined('_NOX') or die('401 Unauthorized');

class Site {

    protected $title = "";
    protected $page = "";
    protected $content = "";

    protected $BasePath, $protocol, $baseDir, $baseUrl;

    function __construct($config) {
        $this->title = $config['website_title'];
        $this->page = $config['home_page'];

        $this->basePath 	= PATH_PUBLIC;
		$this->protocol 	= (strpos($_SERVER['SERVER_PROTOCOL'], 'HTTPS') === 0)? 'https' : 'http';
		$this->baseDir 	    = str_replace(rtrim(str_replace('/', DIRECTORY_SEPARATOR, $_SERVER['DOCUMENT_ROOT']), DIRECTORY_SEPARATOR), '', $this->basePath);
		$this->baseUrl		= str_replace('\\', '/', $this->baseDir ) . '/';

        $this->createContent();
    }





    protected function include($url) {
        if(file_exists($url)) {
            return include($url);
        }

        header('HTTP/1.0 404 Not Found');
        return $this->includePage("errors/404.php");
    }

    protected function require($url) {
        return require($url);
    }

    protected function createContent() {
		ob_start();
		$this->includePage($this->page);
		$this->content = ob_get_clean();
    }







    public function includePage($url) {
        return $this->include(PATH_VIEWS . SEP . $url);
    }

    public function includeComponent($url) {
        return $this->require(PATH_PUBLIC . SEP . "components" . SEP . $url);
    }
    
    public function requireComponent($url) {
        return require(PATH_PUBLIC . SEP . "components" . SEP . $url);
    }




    public function includeCSS($filename) {
        echo "<link rel='stylesheet' type='text/css' href='" . (str_replace(PATH_PUBLIC . SEP, '', PATH_ASSET)) . "/css/" . $filename . ".css'>";
    }

    public function includeJS($filename) {
        echo "<script src='js/" . $filename . ".js'></script>";
    }




    public function getTitle() {
        return $this->title;
    }

    public function getContent() {
        return $this->content;
    }

    public function getBaseUrl() {
        return $this->baseUrl;
    }
}