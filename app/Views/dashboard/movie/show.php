<div class="card">
    

<div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
  <div class="carousel-inner">

  <ol class="carousel-indicators">
    <?php foreach ($images as $index => $i): ?>
        <li data-slide-to="<?= $index ?>" data-target="#carouselExampleControls" class="<?= $index !==0 ?: "active" ?>" data-slide-to="1"></li>
    <?php endforeach;?>
  </ol>

    <?php foreach ($images as $index => $i): ?>
        <div class="carousel-item <?= $index !==0 ?: "active" ?>">
            <img src="<?= route_to('get_image',$i->movie_id,$i->image) ?>" class="d-block w-100" alt="...">
        </div>
    <?php endforeach;?>

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
        <p class="card-text"><?= $movie->description ?></p>
    </div>
</div>