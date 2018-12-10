<?php 
    require_once('../views/header.php'); 
    require_once('../lib/select.php'); 

    $strength = new select('strength', 10, 7);
    $health = new select('health', 10, 5);

    $strength->selectedColor = '#770e23';
    $health->selectedColor = '#3661aa';

    // /images/assassin.jpg
    // /images/tank.jpg
    // /images/warrior.jpg

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
                <select class="form-control">
                    <option>Tank</option>
                    <option>Assassin</option>
                    <option>Warrior</option>
                </select>  
                <h4>Name</h4>
                <input class="form-control" name='name' type='text' placeholder='Name' required>
                <br>
                <br>
                <div class='fighter_info'>
                    <h4>Attack</h4>
                    <?= $strength->display() ?>
                    <h4>Health</h4>
                    <?= $health->display() ?>
                </div>

                <input type="submit" value="Erstellen" class="btn btn-primary">
            </form>
        </div>
    </body>
</html>
