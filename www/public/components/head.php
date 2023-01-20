<?php

/**
 * @copyright Copyrights (C) 2021 - 2023 Dorian Thivolle All rights reserved.
 * @author Dorian Thivolle
 * @since 2021
 */

defined('_NOX') or die('401 Unauthorized');

?>

<head>
    <meta charset="UTF-8">

    <base href="<?php echo $this->getBaseUrl(); ?>">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php
    
    $this->includeCSS("style");
    
    ?>
    
    <title><?php echo $this->getTitle(); ?></title>
</head>