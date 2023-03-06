<?php

/**
 * @copyright Copyrights (C) 2021 - 2023 NoxFly All rights reserved.
 * @author NoxFly
 * @since 2021
 */


defined('_NOX') or die('401 Unauthorized');


require_once(PATH_ENGINE . 'Site.php');



class DeveloperSite extends Site {

    protected $content = '';
    protected $appName = '';
    protected $title = '';
    protected $template = '';
    protected $view = '';

    protected $httpStatus = 200;

    /** @var StdClass */
    public $req;
    /** @var StdClass */
    public $data;

    

    function __construct($config) {
        parent::__construct($config);

        $this->loadPage();
    }




    protected function onPageLoaded($loadResult) {
        if($loadResult !== 0) {
            $this->router->loadEndpoint('404', $this);
        }
    }
}