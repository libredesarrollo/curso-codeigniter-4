<table class="table">
    <tr>
        <th>ID</th>
        <th>Comprado</th>
        <th>Pasarela</th>
        <th>Película</th>
        <th>Acciones</th>
    </tr>

    <?php foreach ($payments as $key => $p) : ?>
        <tr>
            <td><?= $p->id ?></td>
            <td><?= formatDefaultDateTime($p->created_at) ?></td>

            <td>
                <?php if ($p->type == "paypal") : ?>
                    <i title="PayPal" class="fab fa-paypal text-success"></i>
                <?php else : ?>
                    <i title="Stripe" class="fab fa-stripe text-success"></i>
                <?php endif ?>
            </td>

            <td><?= $p->movie ?></td>
            <td><a href="<?= route_to('store_buyed_show', $p->id) ?>"><i class="fa fa-eye"></i></a></td>
        </tr>
    <?php endforeach ?>
</table>