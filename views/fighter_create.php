<?php 
    require_once('../views/header.php'); 
    require_once('../lib/select.php'); 

    $strength = new select('strength', 10, 7);
    $health = new select('health', 10, 5);

    $strength->selectedColor = '#770e23';
    $health->selectedColor = '#3661aa';
?>



<html>
    <head></head>
    <body>
        <div class='fighter_box'>
            <form action='/Fighter/insert' method='post'>
                <div class='class_info'>
                    <img src='/images/assassin.jpg' height='100px' width='100px'>
                    <div class="description">
                        <p>Text</p>
                    </div>
                </div>
                <h4>Name</h4>
                <input name='name' type='text' placeholder='Name' required>
                <br>
                <br>
                <div class='fighter_info'>
                    <h4>Attack</h4>
                    <?= $strength->display() ?>
                    <h4>Health</h4>
                    <?= $health->display() ?>
                </div>

                <input type="submit" value="Erstellen">
            </form>
        </div>
    </body>
</html>
