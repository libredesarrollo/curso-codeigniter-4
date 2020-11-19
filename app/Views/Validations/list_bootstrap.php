<?php if (! empty($errors)) : ?>
	<div class="errors" role="alert">
		
		<?php foreach ($errors as $error) : ?>
			<div class="alert alert-danger"><?= esc($error) ?></div>
		<?php endforeach ?>
		
	</div>
<?php endif ?>
