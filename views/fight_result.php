<?php
    require_once('../views/header.php');
    require_once("../lib/round.php");
?>

<div class="fighterListContainer">
    <?php foreach ($rounds as $round): ?>
        <div class="panel panel-default">
            <p class="panel-heading">
                <?= $round->output(); ?>
            </p>
        </div>
    <?php endforeach ?>
</div>


