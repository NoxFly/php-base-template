<?php

/**
 * @copyright Copyrights (C) 2021 - 2023 NoxFly All rights reserved.
 * @author NoxFly
 * @since 2021
 */

defined('_NOX') or die('401 Unauthorized');



class Router {
    protected $mw;

    // url => filepath from views/ folder (without extension)
    protected $routes = array();

    /**
     * @var string $basePath
     * @var string $protocol
     * @var string $$baseDir
     * @var string $baseUrl
     * @var string $rootUrl
     * @var string $baseUri
     */
    protected $basePath, $protocol, $baseDir, $baseUrl, $rootUrl, $baseUri;

    function __construct($routes) {
        $this->basePath 	= PATH_PUBLIC;
		$this->protocol 	= (strpos($_SERVER['SERVER_PROTOCOL'], 'HTTPS') === 0)? 'https' : 'http';
		$this->baseDir 	    = str_replace(rtrim(str_replace('/', SEP, $_SERVER['DOCUMENT_ROOT']), SEP), '', $this->basePath);
		$this->rootUrl 	    = str_replace('\\', '/', str_replace(rtrim(str_replace('/', SEP, $_SERVER['DOCUMENT_ROOT']), SEP), '', PATH_ROOT));
		$this->baseUrl		= str_replace('\\', '/', $this->baseDir) . '/';
        $this->baseUri      = $this->protocol . '://' . $_SERVER['HTTP_HOST'] . $this->rootUrl;

        foreach($routes as $r) {
            $er = explode(',', $r);

            if(count($er) > 1) {
                $routeMethod = $er[0];
                $routeUrl = $er[1];
                $routeView = $er[2];
                $routeMW = $er[3]?? NULL;
                
                $routeMWpath = '';
                $routeMWclass = NULL;

                if($routeMW) {
                    $routeMWpath = PATH_INC . SEP . 'middlewares' . SEP . $routeMW . '.mw.php';

                    if(file_exists($routeMWpath)) {
                        $routeMWclassName = str_replace('-', '', $routeMW) . 'Middleware';
                        
                        include_once($routeMWpath);

                        if(class_exists($routeMWclassName)) {
                            $routeMWclass = new $routeMWclassName();
                        }
                    }
                }

                $this->addRoute($routeMethod, $routeUrl, $routeView, $routeMWclass);
            }
        }
    }

    protected function addRoute($method, $url, $viewFilepath, $middleware=NULL) {
        $this->routes[$method . $url] = (object)array(
            'method' => $method,
            'url' => $url,
            'view' => $viewFilepath,
            'middleware' => $middleware
        );
    }

    /**
     * @return string
     */
    public function getRootUrl() {
        return $this->rootUrl;
    }

    /**
     * @return string
     */
    public function getBaseUrl() {
        return $this->baseUrl;
    }

    /**
     * @param string $page
     * @param View $res
     */
    public function loadEndpoint($page, $res) {
        $req = (object)array(
            'method' => $_SERVER['REQUEST_METHOD'],
            'headers' => getallheaders(),
            'page' => $page,
            'view' => NULL,
            'body' => $_REQUEST,
            'baseUrl' => $this->baseUrl,
            'rootUrl' => $this->rootUrl,
            'baseUri' => $this->baseUri
        );

        $k = $req->method . '/' . $page;

        if(array_key_exists($k, $this->routes)) {
            $req->view = $this->routes[$k]->view;

            if($this->routes[$k]->middleware !== NULL) {
                $this->routes[$k]->middleware->{$req->method}($req, $res);
            }
            else {
                $res->render($req);
            }

            return true;
        }

        return false;
    }

    public function getUrl($page) {
        return $this->baseUri . $page;
    }
}