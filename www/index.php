<?php

/**
 * @copyright Copyrights (C) 2021 - 2023 NoxFly All rights reserved.
 * @author NoxFly
 * @since 2021
 */



include_once('./_inc/definitions.php');

// pretty useless since we're including the definition just above
// but it's for security, if this include was removed in the future
defined('_NOX') or die('401 Unauthorized');





// website configuration
$config = parse_ini_file(PATH_CONF . SEP . "config.ini");

// enable error output if in development mode
if($config['ENV'] === 'dev') {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
}






// create website
require(PATH_INC . SEP . "Site.php");

$site = new Site($config);

$site->includeComponent($config['template_page']);