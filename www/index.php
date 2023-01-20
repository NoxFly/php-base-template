<?php

/**
 * @copyright Copyrights (C) 2021 - 2023 Dorian Thivolle All rights reserved.
 * @author Dorian Thivolle
 * @since 2021
 */

define("_NOX", true);

define("SEP", DIRECTORY_SEPARATOR);


// DEFINES
define("PATH_PUBLIC", realpath("./public"));
define("PATH_ASSET", PATH_PUBLIC . SEP . "asset");
define("PATH_VIEWS", PATH_PUBLIC . SEP . "views");
define("PATH_CONF", "./_conf");
define("PATH_INC", "./_inc");


$config = parse_ini_file(PATH_CONF . SEP . "config.ini");


require(PATH_INC . SEP . "Site.php");

$site = new Site($config);


$site->includeComponent($config['template_page']);