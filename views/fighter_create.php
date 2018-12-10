<?php 
    require_once('../views/header.php'); 
    require_once('../lib/selectBar.php'); 

    require_once("../Fighter/fighter.php");
    require_once("../Fighter/assassin.php");
    require_once("../Fighter/tank.php");
    require_once("../Fighter/warrior.php");


    $strength = new selectBar('strength', 10, 1);
    $health = new selectBar('health', 10, 1);

    $strength->selectedColor = '#770e23';
    $health->selectedColor = '#3661aa';
?>

<html>
    <head>
        <script src="/js/ClassSwitcher.js?v=<?=time();?>"></script>     
        <script>
            var defaults = {};
            <?php Fighter::FillDefaults(); ?> //Fills the JS 'defaults' array

            var switcher = new ClassSwitcher(defaults);

            function onSelectChanged(){
                switcher.Refresh();
                Refresh('strength', '<?= $strength->selectedColor ?? '' ?>');
                Refresh('health', '<?= $health->selectedColor ?? '' ?>');
            }
        </script>
    </head>
    <body>
        <div class='fighter_box'>
            <form action='/Fighter/insert' method='post'>
                <div class='class_info'>
                    <img id='classImage' src='/images/tank.jpg' height='100px' width='100px'>
                    <div class="description" id="classDescription">
                        <p>Text</p>
                    </div>
                </div>
                <br>
                <h4>Class</h4>
                <select class="form-control" id="classSelect" onchange="onSelectChanged()" value=0>
                    <?php Fighter::GetOptionsHTML(); ?>
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

                <input type="submit" value="Create Fighter" class="btn btn-primary">
            </form>
        </div>
    </body>
</html>
