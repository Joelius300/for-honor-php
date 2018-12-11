<?php 
	require_once('../views/header.php'); 
	
	require_once("../controller/FighterController.php");
	$controller = new FighterController();

	$fighters = $controller->GetAll(0, 5000)
?>

<div class="fighterListContainer">
	<?php if (empty($fighters)): ?>
		<div class="dhd">
			<h2 class="item title">Keine fighter gefunden.</h2>
		</div>
	<?php else: ?>
		<?php foreach ($fighters as $fighter): ?>
			<div class="panel panel-default">
				<a class="panel-heading" 
					href = '/Fight/Fight?enemy=<?= $fighter->id ?>'>
					<span class='class'>
						<img id='classImage' src='<?= $fighter->class::$picURL; ?>' height='30px' width='30px'>
					</span>
					<span class='name'>
						<?= htmlspecialchars($fighter->name); ?>
					</span>
					<span class='username'>
						<?= $fighter->username; ?>
					</span>
				</a>
			</div>
		<?php endforeach ?>
	<?php endif ?>
</div>
