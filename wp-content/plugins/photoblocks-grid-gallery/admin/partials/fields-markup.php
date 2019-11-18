<?php foreach($this->settings->fields[$section] as $group) : ?>
<div class="pb-section-group">
    <h3><?php _e($group["name"], 'photoblocks') ?></h3>
    <ul class="photoblocks-expandable js-group-<?php echo Photoblocks_Utils::slugify($group["name"]) ?> settings-panel">
        <?php foreach($group["fields"] as $k => $field) : ?>
        <li class="field field-code-<?php echo $field["code"] ?>" data-code="<?php echo $field["code"] ?>" data-show-if="<?php echo $field["show_if"] ?>">
            <?php include "field-type/" . $field["type"]  . ".php" ?>
        </li>
        <?php endforeach ?>
    </ul>
</div>
<?php endforeach ?>