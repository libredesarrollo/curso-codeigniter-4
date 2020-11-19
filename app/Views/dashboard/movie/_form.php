
<div class="form-group">
    <label for="title">Title</label>
    <input class="form-control" type="input" id="title" name="title" value="<?=old('title', $movie->title)?>"/>
</div>

<div class="form-group">
    <label for="description">Descripción</label>
    <textarea class="form-control" name="description" id="description"><?=old('description', $movie->description)?></textarea>
</div>

<?php if (!$created): ?>
    <div class="form-group">
        <label for="image">Image</label>
        <input class="form-control" type="file" name="image" />
    </div>
<?php endif?>

<div class="form-group">
    <label for="category_id">Categoría</label>
    <select class="form-control"  name="category_id" id="category_id">
        <?php foreach ($categories as $c): ?>
            <option <?= $movie->category_id !== $c->id ?: "selected"?> value="<?= $c->id ?>"><?= $c->title ?> </option>
        <?php endforeach?>
    </select>
</div>

<button class="btn btn-success" type="submit"><i class="fa fa-save"></i> <?=$textButton?></button>