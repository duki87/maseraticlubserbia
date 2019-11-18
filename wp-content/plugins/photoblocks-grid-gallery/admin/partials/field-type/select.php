<label class="pb-settings-label">
    <span class="control"><?php _e($field["name"], 'photoblocks') ?>
    <select name="<?php echo $field["code"] ?>" class="js-serialize p-<?php echo $field["code"] ?>">
    <?php foreach($field["values"] as $k => $v) : ?>
        <option value="<?php echo $k ?>"><?php _e($v, 'photoblocks') ?></option>
    <?php endforeach ?>
    </select>
</label>
<div class="pb-settings-description"><p><?php _e($field["description"], 'photobocks') ?></p></div>