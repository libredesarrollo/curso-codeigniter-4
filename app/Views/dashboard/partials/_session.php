<?php if(session('message')): ?>
    <div class="alert alert-success mt-2 mb-2 fade show">
        <?= session('message') ?>
        <button type="button" class="btn-close float-right" data-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif ?>