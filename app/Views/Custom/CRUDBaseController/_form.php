<?php foreach ($eheading as $i => $h) : ?>

    <div class="form-group">
        
        <?php if ($iheading[$i] == $primaryId) : ?>
            <input name="<?= $iheading[$i] ?>" type="hidden" value="<?= old($iheading[$i], !isset($record) ? "" : $record[$iheading[$i]]) ?>">
        <?php elseif (array_key_exists($iheading[$i], $selects)) : ?>
            <label for=""><?= $h ?></label>
            <select name="<?= $iheading[$i] ?>" class="form-control">
                <?php
                foreach ($selects[$iheading[$i]]->data as $s) : ?>
                    <option 
                    <?= isset($record) && $record[$iheading[$i]] == $s[$selects[$iheading[$i]]->fkField]  ? "selected" : "" ?>
                    value="<?= $s[
                        $selects[$iheading[$i]]->fkField
                    ] ?>">
                        <?= $s[
                            $selects[$iheading[$i]]->fkFieldName
                        ] ?>
                    </option>
                <?php endforeach ?>
            </select>
        <?php elseif ($types[$h] == "textarea") : ?>
            <label for=""><?= $h ?></label>
            <textarea name="<?= $iheading[$i] ?>" id="<?= $iheading[$i] ?>" class="form-control"><?= old($iheading[$i], !isset($record) ? "" : $record[$iheading[$i]]) ?></textarea>
        <?php elseif ($types[$h] == "number") : ?>
            <label for=""><?= $h ?></label>
            <input name="<?= $iheading[$i] ?>" type="number" class="form-control" value="<?= old($iheading[$i], !isset($record) ? "" : $record[$iheading[$i]]) ?>">
        <?php else : ?>
            <label for=""><?= $h ?></label>
            <input name="<?= $iheading[$i] ?>" type="text" class="form-control" value="<?= old($iheading[$i], !isset($record) ? "" : $record[$iheading[$i]]) ?>">
        <?php endif; ?>


    </div>

<?php endforeach ?>