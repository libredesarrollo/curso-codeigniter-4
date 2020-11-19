
<a href="/movie/new" class="btn btn-success mb-4"><i class="fa fa-plus"></i> Crear</a>

<table class="table">
    <thead>
        <tr>
            <th>Id</th>
            <th>Nombre</th>
            <th>Categoría</th>
            <th>Opciones</th>
        </tr>
    </thead>
    <tbody>

        <?php foreach ($movies as $key => $m): ?>
            <tr>
                <td><?= $m->id ?></td>
                <td><?= $m->title ?></td>
                <td><?= $m->category ?></td>
                <td>

                    <a data-toggle="tooltip" data-placement="top" title="Ver detalle" class="float-right ml-2 btn btn-primary btn-sm" href="/movie/<?= $m->id ?>"><i class="fa fa-eye"></i></a>

                    <form action="/movie/delete/<?= $m->id ?>" method="POST">
                        <button data-toggle="tooltip" data-placement="top" title="Borrar" class="float-right btn btn-danger btn-sm ml-2" type="submit"><i class="fa fa-trash"></i></button>
                    </form>

                    <a data-toggle="tooltip" data-placement="top" title="Editar" class="float-right ml-2 btn btn-primary btn-sm" href="/movie/<?= $m->id ?>/edit"><i class="fa fa-pencil-alt"></i></a>

                </td>
            </tr>
        <?php endforeach?>



    </tbody>
</table>

<?= $pager->links() ?>