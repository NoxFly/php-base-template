<?php

/**
 * @copyright Copyrights (C) 2021 - 2023 NoxFly All rights reserved.
 * @author NoxFly
 * @since 2021
 */

defined('_NOX') or die('401 Unauthorized');


class View {
    public $req = NULL;

    protected $content = '';
    protected $title = '';
    protected $template = '';

    function __construct($config) {
        $this->title = $config['website_title'];
        $this->template = $config['template_page'];
    }

    /**
     * @param string $page
     */
    public function render($req) {
        $this->req = $req;

        $this->createContent();
        
        if(preg_match('#<h1>(.*)</h1>#', $this->content, $aMatches) && !empty($aMatches[1])) {
			$this->title = $aMatches[1];
		}

        $this->includeComponent($this->template);
    }


    /**
     * @param string $url
     */
    protected function include($url) {
        if(file_exists($url)) {
            return include($url);
        }

        return '';
    }

    /**
     * @param string $url
     */
    protected function require($url) {
        if(file_exists($url)) {
            return require($url);
        }

        return '';
    }

    protected function createContent() {
		ob_start();
		$this->includePage($this->req->view);
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

    public function url($endUrl) {
        return $this->req->baseUri . $endUrl;
    }
}