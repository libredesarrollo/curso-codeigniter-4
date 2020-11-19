<div class="card">


  <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">

      <ol class="carousel-indicators">
        <?php foreach ($images as $index => $i) : ?>
          <li data-slide-to="<?= $index ?>" data-target="#carouselExampleControls" class="<?= $index !== 0 ?: "active" ?>" data-slide-to="1"></li>
        <?php endforeach; ?>
      </ol>

      <?php foreach ($images as $index => $i) : ?>
        <div class="carousel-item <?= $index !== 0 ?: "active" ?>">
          <img src="<?= route_to('get_image', $i->movie_id, $i->image) ?>" class="d-block w-100" alt="...">
        </div>
      <?php endforeach; ?>

    </div>
    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
  <div class="card-body">
    <div class="float-right badge badge-primary badge-pill"><?= $movie->price ?>$</div>
    <?php if (isset($_SESSION['type'])) : ?>
      <a class="btn btn-danger btn-sm mb-3" href="<?= route_to('store_movie_buy', $movie->id) ?>"><i class="fab fa-paypal"></i> PayPal</a>
      <button data-toggle="modal" data-target="#formStripe" class="btn btn-danger  btn-sm mb-3"> <i class="fab fa-stripe"></i> Stripe</button>
    <?php else : ?>
      <a class="btn btn-danger btn-sm mb-3" href="<?= route_to('user_login_get', $movie->id) ?>"><i class="fa fa-user"></i> Debe iniciar sesión para comprar</a>
    <?php endif ?>
    <p class="card-text"><?= $movie->description ?></p>
  </div>
</div>

<!-- Modal stripe -->
<div class="modal fade" id="formStripe" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><?= $movie->title ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="stripeCard"></div>
      </div>
    </div>
  </div>
</div>

<script src="https://js.stripe.com/v3/"></script>

<script>
  window.onload = function() {
    $('#formStripe').on('show.bs.modal', function(event) {

      fetch("<?= base_url() ?>/store/pay/stripe/<?= $movie->id ?>")
        .then(function(res) {
          return res.text()
        })
        .then(function(data) {
          document.querySelector("#stripeCard").innerHTML = data
          stripeForm(<?= $movie->id ?>)
        })

      /* $.ajax({
         url: "<?= base_url() ?>/store/pay/stripe/<?= $movie->id ?>"
       }).done(function(data) {
         $("#stripeCard").html(data)
         stripeForm()
       });*/

    })
  }
</script>