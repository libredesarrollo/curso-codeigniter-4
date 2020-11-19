<a class="btn btn-success my-2" href="<?= $baseURL.'/new' ?>">Crear</a>

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