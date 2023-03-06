<?php

/**
 * @copyright Copyrights (C) 2021 - 2023 NoxFly All rights reserved.
 * @author NoxFly
 * @since 2021
 */


defined('_NOX') or die('401 Unauthorized');


require_once(PATH_ENGINE . 'Site.php');
require_once(PATH_SERVICES . 'Api.php');



class WebSite extends Site {

    /** @var ApiService */
    protected $apiService;



    function __construct($config) {
        parent::__construct($config);


        // instantiate services
        $this->apiService = new ApiService($this->router->getBaseUri());

        //
        $this->loadPage();
    }




    protected function onPageLoaded($loadResult) {
        if($loadResult !== 0) {
            $this->router->loadEndpoint('404', $this);
        }
    }



    /* -------------------------- GETTERS -------------------------- */

    /**
     * @return ApiService
     */
    public function api() {
        return $this->apiService;
    }
}