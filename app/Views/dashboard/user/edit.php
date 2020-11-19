<?= view("dashboard/partials/_form-error"); ?>
<form action="/client/update/<?= $user->id ?>" method="POST" enctype="multipart/form-data">
<?= view("dashboard/user/_form",['textButton' => 'Actualizar','created' => false]); ?>
</form>