<?php require_once('../views/header.php'); ?>

<?php
	require_once("../controller/FighterController.php");
?>

<!-- <article class="hreview open special"> -->
	<?php if (empty($fighters)): ?>
		<div> <!-- <div class="dhd"> -->
			<h2 class="item title">Keine fighter gefunden.</h2>
		</div>
	<?php else: ?>
		<?php foreach ($fighters as $fighter): ?>
			<div class="panel panel-default">
				<div class="panel-heading"><?= $fighter->class;?> <?= $fighter->lastName;?></div>
				<div class="panel-body">
					<p class="description">
						In der Datenbank existiert ein fighter mit dem Namen <?= $fighter->firstName;?> <?= $fighter->lastName;?>. 
						Dieser hat die EMail-Adresse: <a href="mailto:<?= $fighter->email;?>"><?= $fighter->email;?></a>
					</p>
				</div>
			</div>
		<?php endforeach ?>
	<?php endif ?>
<!-- </article> -->
