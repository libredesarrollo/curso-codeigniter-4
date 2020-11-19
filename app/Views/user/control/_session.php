<?php if(session('message')): ?>
    <div class="alert alert-danger mt-2 fade show">
        <?= session('message') ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif ?>