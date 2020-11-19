<div class="card">
    <div class="card-body">
        <?= view("Custom/CRUDBaseController/_form-error"); ?>
        <form action="<?= $baseURL . '/create'  ?>" method="post">
            <?= view("Custom/CRUDBaseController/_form"); ?>
            <button type="submit" class="btn btn-success">Crear</button>
        </form>
    </div>
</div>