<?php

/**
 * @copyright Copyrights (C) 2021 - 2023 NoxFly All rights reserved.
 * @author NoxFly
 * @since 2021
 */

define("_NOX", true);

define("SEP", DIRECTORY_SEPARATOR);


// PATHS DEFINES
define("PATH_ROOT", realpath('.'));
define("PATH_PUBLIC", PATH_ROOT . SEP . "public");
define("PATH_ASSET", PATH_PUBLIC . SEP . "asset");
define("PATH_VIEWS", PATH_PUBLIC . SEP . "views");
define("PATH_CONF", PATH_ROOT . SEP . "_conf");
define("PATH_INC", PATH_ROOT . SEP . "_inc");