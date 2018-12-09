<body>
    <div class='selectContainer'>
        <input id='<?= $name ?>Value' name='<?= $name ?>Value' type="hidden" value=<?=$startValue?>>

        <div class='select'>
            <div class='selectButton' onclick="ChangeValue('<?= $name ?>', -1, '<?= $selectedColor ?? '' ?>')">-</div>
            
            <?php
            for($i = 0; $i < $itemsAmount; $i++){
            ?>
                <div class='selectItem <?= $name ?>'></div>
            <?php
            }
            ?>

            <div class='selectButton' onclick="ChangeValue('<?= $name ?>', +1, '<?= $selectedColor ?? '' ?>')">+</div>
        </div>

    </div>

    <script>Refresh('<?= $name ?>', '<?= $selectedColor ?? '' ?>')</script>

</body>