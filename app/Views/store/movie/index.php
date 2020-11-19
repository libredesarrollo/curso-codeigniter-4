<form action="" class="form-inline justify-content-center">
    <input name="search" value="<?= $search ?>" type="text" class="form-control form-control-sm w-50 mr-2" placeholder="Buscar...">

    <select class="form-control form-control-sm w-25 mr-2" name="category_id">
        <option value="">Sin categorías</option>
        <?php foreach ($categories as $c) : ?>
            <option <?= $category_id == $c->id ? "selected" : "" ?> value="<?= $c->id ?>"><?= $c->title ?></option>
        <?php endforeach ?>
    </select>

    <button class="btn btn-primary btn-sm" type="submit"><i class="fa fa-search"></i></button>
</form>

<?php foreach ($movies as $key => $m) : ?>

    <div class="card mt-3">

        <?php if ($m->image != "") : ?>
            <img src="<?= route_to('get_image', $m->id, $m->image) ?>" class="d-block w-100" alt="...">
        <?php endif ?>
        <div class="card-header bg-danger"></div>
        <div class="card-body">
            <div class="float-right badge badge-primary badge-pill"><?= $m->price ?>$</div>
            <h3><?= $m->title ?></h3>
            <p><?= character_limiter($m->description, 150) ?></p>

            <a class="btn btn-danger btn-sm float-right" href="<?= route_to('store_movie_show', $m->id) ?>"><i class="fa fa-eye"></i> Ver</a>

        </div>
    </div>

<?php endforeach ?>

<?php if($pager): ?>
<?= $pager->links() ?>
<?php endif ?>