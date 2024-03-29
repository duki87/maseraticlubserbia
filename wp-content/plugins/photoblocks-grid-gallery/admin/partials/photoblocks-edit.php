<div id="pb-builder" class="grey" data-id="<?php echo isset($_GET['id']) ? $_GET['id'] : "" ?>">
	<div id="pb-app-admin-header">
		<div id="pb-logo"></div>
		<a href="admin.php?page=photoblocks-dashboard" class="pb-close"></a>
	</div>
    <div id="pb-header">
    	<div id="pb-app-header">
			<ul class="pb-app-menu">
				<li>
					<a data-target="#board" title="Images" class=" active" onclick="PBAdmin.switchTab('board')">
						<span class="app-menu-text"><?php _e('Blocks', 'photoblocks') ?></span>
					</a>
				</li>
				<li>
					<a data-target="#gallery" title="" onclick="PBAdmin.switchTab('gallery')">
						<span class="app-menu-text"><?php _e('Gallery', 'photoblocks') ?></span>
					</a>
				</li>
				<li>
					<a data-target="#lightbox" title="" onclick="PBAdmin.switchTab('lightbox')">
						<span class="app-menu-text"><?php _e('Lightbox', 'photoblocks') ?></span>
					</a>
				</li>
				<li>
					<a data-target="#captions" title="" onclick="PBAdmin.switchTab('captions')">
						<span class="app-menu-text"><?php _e('Captions', 'photoblocks') ?></span>
					</a>
				</li>
				<li>
					<a data-target="#filters" title="" onclick="PBAdmin.switchTab('filters')">
						<span class="app-menu-text"><?php _e('Filters', 'photoblocks') ?></span>
					</a>
				</li>
				<li>
					<a data-target="#customisations" title="" onclick="PBAdmin.switchTab('customisations')">
						<span class="app-menu-text"><?php _e('Customizations', 'photoblocks') ?></span>
					</a>
				</li>
			</ul>
		    <a onclick="PBAdmin.save()" title="<?php _e('Publish', 'photoblocks') ?>" class="pb-button publish" tabindex="-1"><img src="<?php echo plugin_dir_url( __FILE__ ) ?>../css/loading.svg" alt="Loading..."> <span><?php _e('Publish', 'photoblocks') ?></span></a>
    	</div>
    </div>
    <div id="pb-main" class="pb-app-main">
    	<div class="wrap" id="photoblocks-add"></div>
		<?php wp_nonce_field('photoblocks', 'photoblocks'); ?>			
			
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <div class="swiper-slide pb-form-slide" id="pb-panel-board"> 
                        <div class="artboard-menu">  
							<a class="button-add" href="#" onclick="PBAdmin.popup('add-blocks')"><i class="pb-plus"></i> Add blocks</a>                          							
							<a class="button-bulk" href="#" onclick="PBAdmin.openBulk()"><i class="pb-check-square-o"></i> Bulk edit</a>
							<a class="button-delete" href="#" onclick="PBAdmin.popup('confirm-deletion')"><i class="pb-trash"></i> <?php _e('Delete all', 'photoblocks') ?></a>
							<a href="#" class="open-drawer" data-drawer="pb-grid-settings"><i class="pb-th"></i> <?php _e('Grid settings', 'photoblocks') ?></a>
                        </div>
						<div class="photoblocks-grids-statusbar">
							<span></span>
						</div>
                        <div id="photoblocks-grids">
							<div class="photoblocks-grid"></div>
						</div>
                    </div>
                    <div class="swiper-slide pb-form-slide" id="pb-panel-gallery">
	                    <div class="pb-inner">
                            <?php $section = "gallery"; ?>
                            <?php include "fields-markup.php"; ?>
                        </div>
                    </div>
                    <div class="swiper-slide pb-form-slide" id="pb-panel-lightbox">
                        <div class="pb-inner">
                            <?php $section = "lightbox"; ?>
                            <?php include "fields-markup.php"; ?>
                        </div>
                    </div>
	                <div class="swiper-slide pb-form-slide" id="pb-panel-captions">
						<div class="pb-inner">
							<?php $section = "captions"; ?>
							<?php include "fields-markup.php"; ?>
						</div>
	                </div>
					<div class="swiper-slide pb-form-slide" id="pb-panel-filters">
						<div class="pb-inner">
							<?php $section = "filters"; ?>
							<?php include "fields-markup.php"; ?>
						</div>
	                </div>
					<div class="swiper-slide pb-form-slide" id="pb-panel-customisations">
						<div class="pb-inner">
							<?php $section = "customisations"; ?>
							<?php include "fields-markup.php"; ?>
						</div>
	                </div>
                </div>
            </div>

			
		</div>
    </div>
    <?php include "drawer.php" ?>
</div>

<div class="pb-modal" style="display:none" id="modal-name">
	<div class="pb-popup">
		<label><?php _e('Gallery name', 'photoblocks') ?>:
			<input class="wiz-gallery-name" type="text">
		</label>
		<p><?php _e('Friendly name for this gallery, it won\'t be shown on your site', 'photoblocks') ?></p>
		<div class="pb-popup-footer">
			<a onclick="PBAdmin.setGalleryName()" class="pb-button"><?php _e('Submit', 'photoblocks') ?></a>
		</div>
	</div>
</div>

<div class="pb-modal" style="display:none" id="modal-bulk">
	<div class="pb-popup">
		<a onclick="PBAdmin.popup('bulk', true)" class="pb-modal-close"><i class="pb-close"></i></a>
		<h3><?php _e('Bulk edit', 'photoblocks') ?></h3>
		<p class="with" style="display:none">Selected <span class="pb-count"></span> images</p>
		<div class="blocks"></div>
		<?php if(photob_fs()->is__premium_only() && photob_fs()->is_plan_or_trial("ultimate")) : ?>
		<p class="filters"></p>
		<?php endif ?>
		<p class="without">No block currently selected</p>
		<div class="pb-popup-footer">
		<?php if(photob_fs()->is__premium_only() && photob_fs()->is_plan_or_trial("ultimate")) : ?>
			<a onclick="PBAdmin.removeFilters()" class="pb-button pb-button-small pb-button-green"><?php _e('Remove filters', 'photoblocks') ?></a>
			<a onclick="PBAdmin.replaceFilters()" class="pb-button pb-button-small pb-button-green"><?php _e('Replace filters', 'photoblocks') ?></a>
			<a onclick="PBAdmin.addFilters()" class="pb-button pb-button-small pb-button-green"><?php _e('Add filters', 'photoblocks') ?></a>
		<?php endif ?>
			<a onclick="PBAdmin.deleteSelectedBlock()" class="pb-button pb-button-small pb-button-red"><?php _e('Delete', 'photoblocks') ?></a>
			<a onclick="PBAdmin.popup('bulk', true)" class="pb-button pb-button-small pb-button-grey"><?php _e('Cancel', 'photoblocks') ?></a>
		</div>
	</div>
</div>

<div class="pb-modal" style="display:none" id="modal-confirm-deletion">
	<div class="pb-popup">
		<h3><?php _e('Delete all blocks?', 'photoblocks') ?></h3>	

		<div class="pb-popup-footer">
			<a onclick="PBAdmin.popup('confirm-deletion', true)" class="pb-button pb-button-grey"><?php _e('No', 'photoblocks') ?></a>
			<a onclick="PBAdmin.deleteAllBlocks()" class="pb-button pb-button-red"><?php _e('Yes', 'photoblocks') ?></a>			
		</div>
	</div>
</div>

<div class="pb-modal" style="display:none" id="modal-add-blocks">
	<div class="pb-popup">
		<a onclick="PBAdmin.popup('add-blocks', true)" class="pb-modal-close"><i class="pb-close"></i></a>
		<h3><?php _e('Add new blocks', 'photoblocks') ?></h3>
		<div class="pb-toggle">
			At the 
			<select class="js-new-blocks-position">
				<option value="prepend"><?php _e('beginning', 'photoblocks') ?></option>
				<option value="append"><?php _e('end', 'photoblocks') ?></option>
			</select>
			of the gallery
		</div>
		<div class="action-buttons">
			<a class="button-add-images" href="#" onclick="PBAdmin.addBlocks('image')"><i class="pb-camera"></i> <?php _e('Images', 'photoblocks') ?></a>
			<?php if(photob_fs()->is__premium_only() && photob_fs()->is_plan_or_trial("ultimate")) : ?>
			<a class="button-add-images" href="#" onclick="PBAdmin.addBlocks('text')"><i class="pb-font"></i> <?php _e('Text', 'photoblocks') ?></a>
			<?php else : ?>
			<a class="button-add-images" href="#" onclick="PBAdmin.showPremium()"><i class="pb-font"></i> <?php _e('Text', 'photoblocks') ?></a>
			<?php endif ?>
			<a class="button-add-images" href="#" onclick="PBAdmin.addBlocks('empty')"><i class="pb-square-o"></i> <?php _e('Empty', 'photoblocks') ?></a>							
		</div>
	</div>
</div>

<div class="pb-modal" style="display:none" id="modal-premium">
	<div class="pb-popup">
		<a onclick="PBAdmin.popup('premium', true)" class="pb-modal-close"><i class="pb-close"></i></a>
		<h3><?php _e('Premium feature', 'photoblocks') ?></h3>	
		<p><?php _e('The requested feature is bundled with the Ultimate plan. You can purchase a license or activate a free 14-days trial.', 'photoblocks') ?></p>
		<div class="pb-popup-footer">
			<a href="?billing_cycle=annual&trial=true&page=photoblocks-dashboard-pricing" class="pb-button pb-button-yellow"><?php _e('Trial', 'photoblocks') ?></a>	
			<a href="?page=photoblocks-dashboard-pricing" class="pb-button pb-button-green"><?php _e('Purchase', 'photoblocks') ?></a>			
		</div>
	</div>
</div>