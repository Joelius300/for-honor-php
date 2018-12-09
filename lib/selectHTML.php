<div class='container'>
    <input id='<?= $name ?>Value' type="hidden" value=<?=$startValue?>>

    <div class='select'>
        <div class='button' onclick="ChangeValue('<?= $name ?>', -1)">-</div>
        
        <?php
        for($i = 0; $i < $itemsAmount; $i++){
        ?>
            <div class='item <?= $name ?>'></div>
        <?php
        }
        ?>

        <div class='button' onclick="ChangeValue('<?= $name ?>', +1)">+</div>
    </div>

</div>