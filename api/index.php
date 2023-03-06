<?php

/**
 * @copyright Copyrights (C) 2021 - 2023 NoxFly All rights reserved.
 * @author NoxFly
 * @since 2021
 */


require_once('../engine/definitions.php');


// pretty useless since we're including the definition just above
// but it's for security, if this include was removed in the future
defined('_NOX') or die('401 Unauthorized');



$config = parse_ini_file(PATH_CONF . SEP . 'config.ini', true);


require_once(PATH_SRC . 'Site.php');


$site = new ApiSite($config);