<div class="form-group">
    <label for="title">Title</label>
    <input class="form-control" type="input" id="title" name="title" value="<?=old('title', $category->title)?>"/>
</div>

<button class="btn btn-success" type="submit"><i class="fa fa-save"></i> <?=$textButton?></button>