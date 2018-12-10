<?php  
    require_once('../views/header.php'); 
    require_once('../lib/select.php'); 

    $strength = new select('strength', 10, $fighter->strength);
    $health = new select('health', 10, $fighter->health);

    $strength->selectedColor = '#770e23';
    $health->selectedColor = '#3661aa';
?>

<html>
    <head></head>
    <body>
        <div class='fighter_box'>
            <form action='/Fighter/insert' method='post'>
                <div class='class_info'>
                    <img src='/images/tank.jpg' height='100px' width='100px'>
                    <div class="description">
                        <p>Text</p>
                    </div>
                </div>
                <br>
                <h4>Class</h4>
                <h5><?=$fighter->class?></h5> 
                <h4>Name</h4>
                <input class="form-control" name='name' type='text' value=<?=$fighter->name?> required>
                <br>
                <br>
                <div class='fighter_info'>
                    <h4>Attack</h4>
                    <?= $strength->display() ?>
                    <h4>Health</h4>
                    <?= $health->display() ?>
                </div>

                <input type="submit" value="Save changes" class="btn btn-primary">
            </form>
        </div>
    </body>
</html>