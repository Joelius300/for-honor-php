<div class='selectContainer'>
    <input id='<?= $name ?>Value' name='<?= $name ?>Value' type="hidden" value='<?=$startValue?>'>

    <div class='select'>
        <div id="<?= $name ?>Minus" class='selectButton <?= $name ?>Minus' onclick="selectBar<?= $name ?>.ChangeValue(-1)">-</div>
        
        <?php
        for($i = 0; $i < $itemsAmount; $i++){
        ?>
            <div class='selectItem <?= $name ?>'></div>
        <?php
        }
        ?>

        <div id="<?= $name ?>Plus" class='selectButton <?= $name ?>Plus' onclick="selectBar<?= $name ?>.ChangeValue(+1)">+</div>
    </div>

</div>

<script>
    var selectBar<?= $name ?> = new SelectBar('<?= $name ?>', '<?= $selectedColor ?? '' ?>');
    
    selectBar<?= $name ?>.HidePlus(true);
    selectBar<?= $name ?>.Refresh();
</script>