<a class="btn btn-success my-2" href="<?= $baseURL . '/new' ?>">Crear</a>

<table class="table">
    <thead>
        <tr>
            <?php foreach ($eheading as $key => $h) : ?>
                <th>
                    <?= $h ?>
                </th>
            <?php endforeach ?>
            <th>
                Acciones
            </th>
        </tr>
    </thead>
    <tbody>


        <?php foreach ($rows as $key => $r) : ?>
            <tr>
                <?php foreach ($iheading as $key => $h) : ?>
                    <td>
                        <?= $r[$h] ?>
                    </td>
                <?php endforeach ?>
                <td>
                    <a href="<?= $baseURL . '/' . $r[$primaryId] . '/edit' ?>">Editar</a>
                    <button class="btn btn-danger btn-sm" data-id="<?= $r[$primaryId] ?>" data-toggle="modal" data-target="#deleteModal">Eliminar</button>
                </td>
            </tr>
        <?php endforeach ?>


        <tr>
            <td scope="row"></td>
            <td></td>
            <td></td>
        </tr>
    </tbody>
</table>


<div class="modal fade" id="deleteModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Eliminar: <span></span></h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ¿Seguro que quieres eliminar el registro seleccionado?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>

                <form action="" method="post" id="formDeleteModal">
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    var deleteModal = document.getElementById('deleteModal')
    deleteModal.addEventListener('show.bs.modal', function(event) {
        // Button that triggered the modal
        var button = event.relatedTarget
        var formDeleteModal = document.querySelector('#formDeleteModal')
        // Extract info from data-* attributes
        var id = button.getAttribute('data-id')

        actionBase = "<?= $baseURL . '/delete/' ?>"
        formDeleteModal.setAttribute('action', actionBase + id)

        var modalTitle = deleteModal.querySelector('.modal-title span')

        modalTitle.textContent = id
    })
</script>