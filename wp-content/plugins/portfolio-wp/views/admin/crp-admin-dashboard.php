<?php

require_once( CRP_CLASSES_DIR_PATH.'/CRPDashboardListTable.php');

//Create an instance of our package class...
$listTable = new CRPDashboardListTable();
$listTable->prepare_items();

function featuresListToopltip(){
    $tooltip = "";
    $tooltip .= "<div class=\"crp-tooltip-content\">";
    $tooltip .= "<ul>";
    $tooltip .= "<li>* Masonry, Gallery & Puzzle Layouts</li>";
    $tooltip .= "<li>* Full Screen Popup</li>";
    $tooltip .= "<li>* Dark(Full) & Light Popup Styles</li>";
    $tooltip .= "<li>* 100+ Hover Styles</li>";
    $tooltip .= "<li>* Caption Animations</li>";
    $tooltip .= "<li>* Category Filtration & Pagination</li>";
    $tooltip .= "<li>* Social Share Buttons</li>";
    $tooltip .= "<li>* Design Customization</li>";
    $tooltip .= "<li>* Popups With Zooming & Slideshow</li>";
    $tooltip .= "</ul>";
    $tooltip .= "</div>";

    $tooltip = htmlentities($tooltip);
    return $tooltip;
}
?>

<div id="crp-dashboard-wrapper">
    <div id="crp-dashboard-add-new-wrapper">
        <div class="crp-upgrade-note crp-fl">You’re running Free version of Grid Kit. You can <a href="<?php echo CRP_PRO_URL; ?>" class="tooltip" title='<?php echo featuresListToopltip(); ?>'>upgrade</a> your license to unlock all available features.</div>
        <a id="add-portfolio-button" class='button-secondary add-portfolio-button crp-glazzed-btn crp-glazzed-btn-green' href="<?php echo "?page={$crp_adminPage}&action=create" ?>" title='Add new album'>+ Add new album</a>
        <a id="add-gallery-button" class='button-secondary add-portfolio-button crp-glazzed-btn crp-glazzed-btn-green' href="<?php echo "?page={$crp_adminPage}&action=create&type=".CRPGridType::GALLERY; ?>" title='Add new gallery'>+ Add new gallery</a>
        <a id="add-client-logos-button" class='button-secondary add-portfolio-button crp-glazzed-btn crp-glazzed-btn-green' href="<?php echo "?page={$crp_adminPage}&action=create&type=".CRPGridType::CLIENT_LOGOS; ?>" title='Add new gallery'>+ Add new client logos</a>
        <a id="add-team-button" class='button-secondary add-portfolio-button crp-glazzed-btn crp-glazzed-btn-green' href="<?php echo "?page={$crp_adminPage}&action=create&type=".CRPGridType::TEAM; ?>" title='Add new gallery'>+ Add new team</a>
    </div>
<!--    <div><a class='button-secondary upgrade-button tooltip crp-glazzed-btn crp-glazzed-btn-orange' href='--><?php //echo CRP_PRO_URL ?><!--' title='--><?php //echo featuresListToopltip(); ?><!--'>* UNLOCK ALL FEATURES *</a></div>-->

    <!-- Forms are NOT created automatically, so you need to wrap the table in one to use features like bulk actions -->
    <form id="" method="get">
        <!-- For plugins, we also need to ensure that the form posts back to our current page -->
        <input type="hidden" name="page" value="<?php echo $crp_adminPage ?>" />
        <!-- Now we can render the completed list table -->
        <?php $listTable->display() ?>
    </form>

</div>

<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery(".tablenav.top", jQuery(".wp-list-table .no-items").closest("#crp-dashboard-wrapper")).hide();
    });
</script>