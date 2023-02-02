<?php

/**
 * @copyright Copyrights (C) 2021 - 2023 NoxFly All rights reserved.
 * @author NoxFly
 * @since 2021
 */

defined('_NOX') or die('401 Unauthorized');

?>

<!DOCTYPE html>
<html lang="en">
    <?php $this->requireComponent("head.php"); ?>

    <body>
        <?php $this->requireComponent("nav.php"); ?>

        <main id="content">
            <?php echo $this->getContent(); ?>
        </main>

        <?php echo $this->includeJS('script'); ?>

        <?php $this->requireComponent("footer.php"); ?>
    </body>
</html>