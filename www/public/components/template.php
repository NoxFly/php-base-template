<?php

/**
 * @copyright Copyrights (C) 2021 - 2023 Dorian Thivolle All rights reserved.
 * @author Dorian Thivolle
 * @since 2021
 */

defined('_NOX') or die('401 Unauthorized');

?>

<!DOCTYPE html>
<html lang="en">
    <?php $this->requireComponent("head.php"); ?>

    <body>
        <?php $this->requireComponent("nav.php"); ?>

        <?php echo $this->getContent(); ?>

        <?php echo $this->includeJS('script'); ?>

        <?php $this->requireComponent("footer.php"); ?>
    </body>
</html>