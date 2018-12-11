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
				<div class="panel-heading" onclick="window.location.href = '/Fight/Fight?enemy=<?= $fighter->id ?>';"><span class='name'><?= htmlspecialchars($fighter->name); ?></span> - <span class='class'><?= $fighter->class; ?></span>  |  User: <span class='username'><?= $fighter->username; ?></span></div>
			</div>
		<?php endforeach ?>
	<?php endif ?>
</div>
