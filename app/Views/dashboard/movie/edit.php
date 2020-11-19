<?= view("dashboard/partials/_form-error"); ?>
<form action="/movie/update/<?= $movie->id ?>" method="POST" enctype="multipart/form-data">
<?= view("dashboard/movie/_form",['textButton' => 'Actualizar','created' => false]); ?>
</form>

<?= view("dashboard/movie/_images"); ?>