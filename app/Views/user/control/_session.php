<?php if(session('message')): ?>
    <div class="alert alert-danger mt-2 fade show alert-dismissible">
        <?= session('message') ?>
        <button type="button" class="btn-close float-right" data-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif ?>