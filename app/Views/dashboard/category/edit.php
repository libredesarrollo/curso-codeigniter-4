<?= view("dashboard/partials/_form-error"); ?>
<form action="/category/update/<?= $category->id ?>" method="POST" enctype="multipart/form-data">
<?= view("dashboard/category/_form",['textButton' => 'Actualizar','created' => false]); ?>
</form>