<a href="/client/new" class="btn btn-success mb-4"><i class="fa fa-plus"></i> Crear</a>

<table class="table">
    <thead>
        <tr>
            <th>Id</th>
            <th>Email</th>
            <th>Usuario</th>
            <th>Opciones</th>
        </tr>
    </thead>
    <tbody>

        <?php foreach ($users as $key => $u): ?>
            <tr>
                <td><?= $u->id ?></td>
                <td><?= $u->email ?></td>
                <td><?= $u->username ?></td>
                <td>

                    <form action="/client/delete/<?= $u->id ?>" method="POST">
                        <button data-toggle="tooltip" data-placement="top" title="Borrar" class="float-right btn btn-danger btn-sm ml-2" type="submit"><i class="fa fa-trash"></i></button>
                    </form>

                    <a data-toggle="tooltip" data-placement="top" title="Editar" class="float-right ml-2 btn btn-primary btn-sm" href="/client/<?= $u->id ?>/edit"><i class="fa fa-pencil-alt"></i></a>

                </td>
            </tr>
        <?php endforeach?>



    </tbody>
</table>

<?= $pager->links() ?>