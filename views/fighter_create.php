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


        <script>
            var defaults = {};
            <?php Fighter::FillDefaults(); ?> //Fills the JS 'defaults' array

            var switcher = new ClassSwitcher(defaults, <?= $avaiablePoints ?>);

            //Tells the Javascript how many times the user is allowed to upgrade his fighters points
            SelectBarContainer.avaiablePoints = <?= $avaiablePoints ?>;
        </script>
        <div class='fighter_box'>
            <form action='/Fighter/insert' method='post'>
                <input type='hidden' id='avaiablePointsInput' name='avaiablePoints' value='<?= $avaiablePoints ?>'>
                <div class='class_info'>
                    <img id='classImage' src='/images/tank.jpg' alt="class image" height='100' width='100'>
                    <div>
                        <div class="class_select">
                            <h4>Class</h4>
                            <select class="form-control" id="classSelect" name="class" onchange="onSelectChanged();">
                                <?php Fighter::GetOptionsHTML(); ?>
                            </select>
                        </div>
                        <div class="description" id="classDescription">
                            <p>Text</p>
                        </div>
                    </div>
                </div>
                <br>
                
                <h4>Name</h4>
                <input class="form-control" name='name' type='text' placeholder='Name' maxLength='30' required>
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

        <script>
            function onSelectChanged(){
                switcher.Refresh();

                selectBarstrength.Refresh();
                selectBarhealth.Refresh();
            }

            // selectBarstrength and selectBarhealth are the HTML Names generated 
            // by the PHP Class which can be used in Javascript unlike the php SelectBars
            SelectBarContainer.selects = [selectBarstrength, selectBarhealth];
            SelectBarContainer.CheckAvaiablePoints();

            //Checks and Updates the visibility of the selectBars 
            onSelectChanged();
        </script>

        <?php
            if(!empty($error)){
                echo "<script>alert(\"". htmlspecialchars($error) ."\");</script>";
            }
        ?>
