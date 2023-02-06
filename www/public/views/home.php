<?php

/**
 * @copyright Copyrights (C) 2021 - 2023 NoxFly All rights reserved.
 * @author NoxFly
 * @since 2021
 */

defined('_NOX') or die('401 Unauthorized');

?>

<h1>Welcome home !</h1>

<ul>
    <li><a href="<?=$this->url('/not-a-valid-page')?>">Visit 404</a></li>
    <li><a href="<?=$this->url('/login')?>">Login</a></li>
</ul>