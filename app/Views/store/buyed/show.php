<div class="row">
  <div class="col-md-6 offset-md-3">
    <div class="card mt-5">
      <div class="card-header bg-danger"></div>
      <?php if (count($images)) : ?>
        <img src="<?= route_to('get_image', $payment->e_id, $images[0]->image) ?>" class="d-block w-100" alt="...">
      <?php endif ?>
      <div class="card-body">
        <h4>Comprastes <?= $payment->movie ?></h4>
        <p class="text-muted ml-2"><?= character_limiter($payment->movie_description, 70) ?></p>

        <div class="row">
          <div class="col-6">
          <div class="badge badge-primary badge-pill"><?= $payment->price ?>$</div>
          </div>
          <div class="col-6">
            <?php if ($payment->type == "paypal") : ?>
              <i title="PayPal" class="float-right fab fa-2x fa-paypal text-success"></i>
            <?php else : ?>
              <i title="Stripe" class="float-right fab fa-2x fa-stripe text-success"></i>
            <?php endif ?>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>