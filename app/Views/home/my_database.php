<table class="table">
    <thead>
        <tr>
            <th>Tablas</th>
            <th>Tabla: movie</th>
            <th>Tabla: peliculas</th>
            <th>Campos: movies</th>
            <th>Campo: nombre tabla movie</th>
            <th>Campo: title tabla movie</th>
            <th>Data movies</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><?= implode(' - ',$db->listTables()) ?></td>
            <td><?= $db->tableExists('movies') ?></td>
            <td><?= (int)$db->tableExists('peliculas') ?></td>
            <td><?= implode(' - ',$db->getFieldNames('movies'))  ?></td>
            <td><?= (int)$db->fieldExists('nombre','movies') ?></td>
            <td><?= $db->fieldExists('title','movies')  ?></td>
            <td><?=  var_dump($db->getFieldData('movies'))?></td>


        </tr>
    </tbody>
</table>