<?php

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