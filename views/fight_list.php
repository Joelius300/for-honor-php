<?php 
	require_once('../views/header.php'); 
	
?>

<div class="fighterListContainer">
	<?php if (empty($fighters)): ?>
		<div class="dhd">
			<h2 class="item title">Your enemies feared you and disappeared.</h2>
		</div>
	<?php else: ?>
		<?php foreach ($fighters as $fighter): ?>
			<div class="panel panel-default">
				<a class="panel-heading" 
					href = '/Fight/Fight?enemy=<?= $fighter->id ?>'>
					<span class='class'>
						<img src='<?= $fighter->class::$picURL; ?>' alt="class image" height='30' width='30'>
					</span>
					<span class='name padding'>
						<?= htmlspecialchars($fighter->name); ?>
					</span>
					<span class='username padding'>
						<?= htmlspecialchars($fighter->username); ?>
					</span>
				</a>
			</div>
		<?php endforeach ?>
	<?php endif ?>
</div>
