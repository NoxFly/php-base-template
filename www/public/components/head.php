<?php

/**
 * @copyright Copyrights (C) 2021 - 2023 NoxFly All rights reserved.
 * @author NoxFly
 * @since 2021
 */

defined('_NOX') or die('401 Unauthorized');

?>

<head>
    <meta charset="UTF-8">

    <base href="<?php echo $this->getRouter()->getBaseUrl(); ?>">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php $this->includeCSS("style"); ?>
    
    <title><?php echo $this->getTitle(); ?></title>
</head>