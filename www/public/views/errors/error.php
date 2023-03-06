<?php

/**
 * @copyright Copyrights (C) 2021 - 2023 NoxFly All rights reserved.
 * @author NoxFly
 * @since 2021
 */

defined('_NOX') or die('401 Unauthorized');

?>

<h1>Error <?=$this->data['statusCode']?></h1>

<p class="center"><?=$this->data['message']?></p>

<div id="error-btn">
	<button class="primary">
		<a href="<?=$this->url('/')?>">Go back home</a>
	</button>
</div>