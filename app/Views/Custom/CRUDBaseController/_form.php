<?php foreach ($eheading as $i => $h) : ?>

    <div class="form-group">
        <label for=""><?= $h ?></label>

        <?php if ($types[$h] == "textarea") : ?>
            <textarea name="<?= $iheading[$i] ?>" id="<?= $iheading[$i] ?>" class="form-control"><?= old($iheading[$i], !isset($record) ? "" : $record[$iheading[$i]]) ?></textarea>
        <?php elseif ($types[$h] == "number") : ?>
            <input name="<?= $iheading[$i] ?>" type="number" class="form-control" value="<?= old($iheading[$i], !isset($record) ? "" : $record[$iheading[$i]]) ?>">
        <?php else : ?>
            <input name="<?= $iheading[$i] ?>" type="text" class="form-control" value="<?= old($iheading[$i], !isset($record) ? "" : $record[$iheading[$i]]) ?>">
        <?php endif; ?>


    </div>

<?php endforeach ?>