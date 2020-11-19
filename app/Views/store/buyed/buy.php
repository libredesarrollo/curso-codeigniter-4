<div class="row">
    <div class="col-md-6 offset-md-3">
        <div class="card mt-5">
            <div class="card-header bg-danger"></div>
            <?php if (count($images)) : ?>
                <img src="<?= route_to('get_image', $movie->id, $images[0]->image) ?>" class="d-block w-100" alt="...">
            <?php endif ?>
            <div class="card-body">
                <h4>Vas a comprar <?= $movie->title ?> con un precio de <?= $movie->price ?>$</h4>
                <p><?= character_limiter($movie->description, 70) ?></p>

                <a class="btn btn-danger btn-block mt-5" href="<?= $approval ?>"><i class="fab fa-paypal"></i> Link de pago</a>

            </div>
        </div>
    </div>
</div>