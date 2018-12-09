<?php 
    require_once('../views/header.php'); 
    require_once('../lib/select.php'); 

    $strength = new select('strength', 10, 7);
    $health = new select('health', 10, 5);
?>




<div class='fighter_box'>
    
    <div class='class_info'>
        <img src='/images/assassin.jpg' height='100px' width='100px'>
        <p>blablabla</p>
    </div>
    <p id='fighter_name'>Name: <br>REEEE</p>
    <div class='fighter_info'>
        <p>Attack</p>
        <?php $strength->display() ?>
        <p>Health</p>
        <?php $health->display() ?>
    </div>
</div>