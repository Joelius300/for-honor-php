<?php 
    require_once('../views/header.php'); 
    require_once('../lib/selectBar.php'); 

    require_once("../Fighter/fighter.php");
    require_once("../Fighter/assassin.php");
    require_once("../Fighter/tank.php");
    require_once("../Fighter/warrior.php");


    $strength = new selectBar('strength', 10, $Fighter->strength);
    $health = new selectBar('health', 10, $Fighter->health);

    $strength->selectedColor = '#770e23';
    $health->selectedColor = '#3661aa';
?>

<html>
    <head>
    </head>
    <body>
        <div class='fighter_box'>
            <form action='/Fighter/update' method='post'>
            <input id='id' name='id' type="hidden" value=<?= $FighterID ?>>

                <div class='class_info'>
                    <img id='classImage' src='<?= $Fighter->class::$picURL ?>' height='100px' width='100px'>
                    <div class="description" id="classDescription">
                        <h4>Class</h4>
                        <h5><?= $Fighter->class ?></h5>
                        <p><?= $Fighter->class::$Description ?></p>
                    </div>
                </div>
                <br>
                
                <h4>Name</h4>
                <input class="form-control" name='name' type='text' value='<?= htmlspecialchars($Fighter->name) ?>' maxLength='30' required>
                <br>
                <br>
                <div class='fighter_info'>
                    <h4>Attack</h4>
                    <?= $strength->display() ?>
                    <h4>Health</h4>
                    <?= $health->display() ?>
                </div>

                <input type="submit" value="Save" class="btn btn-primary">
            </form>
        </div>

        <?php
            if(isset($error)){
                echo "<script>alert('$error');</script>";
            }
        ?>
    </body>
</html>
