<?php 
	require_once('../views/header.php'); 
	
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
					<span class='name padding'>
						<?= htmlspecialchars($fighter->name); ?>
					</span>
					<span class='username padding'>
						<?= $fighter->username; ?>
					</span>
				</a>
			</div>
		<?php endforeach ?>
	<?php endif ?>
</div>
