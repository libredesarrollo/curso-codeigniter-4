<div class="card">
    <div class="card-body">
        <?= view("Custom/CRUDBaseController/_form-error"); ?>
        <form action="<?= $baseURL . '/update/' . $record[$primaryId] ?>" method="post">
            <?= view("Custom/CRUDBaseController/_form"); ?>
            <button type="submit" class="btn btn-success">Editar</button>
        </form>

    </div>
</div>