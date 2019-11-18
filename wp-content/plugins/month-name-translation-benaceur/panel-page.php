<?php

function month_name_translation_benaceur_page_options() {
		
        require ('includes/panel-var.php');
		?>
<?php if (isset($_GET['settings-updated']) && $GLOBALS['pagenow'] == 'options-general.php' && $_GET['page'] == MNTB_BEN){ 
echo "<style>#setting-error-settings_updated {margin-top:30px;}</style>";
 } ?>		
            <h2 style="text-shadow:-8px 12px 1px #D2D2D2;"><b><?php _e('Month-Name-Translation-Benaceur', 'month-name-translation-benaceur'); ?></b></h2>
        <br /><br /><h2 style="font-family:Tahoma, Arial;"><?php _e('Settings', 'month-name-translation-benaceur'); ?></h2>
        <form method="post" action="options.php"  >
            <?php settings_fields( 'month_name_translation_benaceur_group' ); 
				do_settings_sections( 'month_name_translation_benaceur_group' );
			?>
<table class="form-table">
	<tr>
		<td>
    <div class="switch demo1">
                        <input type="checkbox"  value="1" <?php if ($mntb_enable_plug) echo 'checked="checked"';  ?> name="month_name_translation_benaceur_enable_plug" />
                        <label></label>
	</div>
	<center><div style="margin-top:10px;margin-bottom:20px;" ><?php _e("Enable plugin",'month-name-translation-benaceur'); ?></div></center>
		</td>
	</tr>
</table>
<br />
<div class="wrap">
    <div id="poststuff">
        <div id="post-body" class="metabox-holder columns-3">
            <!-- sidebar -->
                    <div class="postbox">
                        <div class="inside">
<table border="0" width="98%" cellspacing="0" cellpadding="0">
<?php if (empty($mntb_disable_input)) { $dis = "disabled"; echo '<style>.sm_benaceurlist_caps_input-mntb#h88521  input[type="text"]{color:#A8A8A8;background-color:#F5F5F5;}</style>'; } else { $dis_h = "disabled"; } ?>
	<tr>
		<td  width="50%">
              <table class="form-table-mntb">
                <tr valign="top">
                    <td style="word-wrap:break-word;min-width:20%;">
					<?php _e("The names of months before modification:",'month-name-translation-benaceur'); ?>                   
                   </td>
                </tr>
                <tr valign="top">
                    <td>
					<div class="sm_benaceurlist_caps_input-mntb" id="h88521">
					<input style="font-weight:bold;" type="text" name="month_name_translation_benaceur_jan" value="<?php echo $mntb_jan; ?>" <?php echo $dis; ?> />
					<input style="font-weight:bold;" type="hidden" name="month_name_translation_benaceur_jan" value="<?php echo $mntb_jan; ?>" <?php echo $dis_h; ?> />
					</div>
                   </td>
                </tr>
                <tr valign="top">
                    <td>
					<div class="sm_benaceurlist_caps_input-mntb" id="h88521">
					<input style="font-weight:bold;" type="text" name="month_name_translation_benaceur_Fev" value="<?php echo $mntb_Fev; ?>" <?php echo $dis; ?> />
					<input style="font-weight:bold;" type="hidden" name="month_name_translation_benaceur_Fev" value="<?php echo $mntb_Fev; ?>" <?php echo $dis_h; ?> />
					</div>
                   </td>
                </tr>
                <tr valign="top">
                    <td>
					<div class="sm_benaceurlist_caps_input-mntb" id="h88521">
					<input style="font-weight:bold;" type="text" name="month_name_translation_benaceur_Mar" value="<?php echo $mntb_Mar; ?>" <?php echo $dis; ?> />
					<input style="font-weight:bold;" type="hidden" name="month_name_translation_benaceur_Mar" value="<?php echo $mntb_Mar; ?>" <?php echo $dis_h; ?> />
					</div>
                   </td>
                </tr>
                <tr valign="top">
                    <td>
					<div class="sm_benaceurlist_caps_input-mntb" id="h88521">
					<input style="font-weight:bold;" type="text" name="month_name_translation_benaceur_Avr" value="<?php echo $mntb_Avr; ?>" <?php echo $dis; ?> />
					<input style="font-weight:bold;" type="hidden" name="month_name_translation_benaceur_Avr" value="<?php echo $mntb_Avr; ?>" <?php echo $dis_h; ?> />
					</div>
                   </td>
                </tr>
                <tr valign="top">
                    <td>
					<div class="sm_benaceurlist_caps_input-mntb" id="h88521">
					<input style="font-weight:bold;" type="text" name="month_name_translation_benaceur_Mai" value="<?php echo $mntb_Mai; ?>" <?php echo $dis; ?> />
					<input style="font-weight:bold;" type="hidden" name="month_name_translation_benaceur_Mai" value="<?php echo $mntb_Mai; ?>" <?php echo $dis_h; ?> />
					</div>
                   </td>
                </tr>
                <tr valign="top">
                    <td>
					<div class="sm_benaceurlist_caps_input-mntb" id="h88521">
					<input style="font-weight:bold;" type="text" name="monthnametranslationbenaceurjuin" value="<?php echo $mntb_Juin; ?>" <?php echo $dis; ?> />
					<input style="font-weight:bold;" type="hidden" name="monthnametranslationbenaceurjuin" value="<?php echo $mntb_Juin; ?>" <?php echo $dis_h; ?> />
					</div>
                   </td>
                </tr>
                <tr valign="top">
                    <td>
					<div class="sm_benaceurlist_caps_input-mntb" id="h88521">
					<input style="font-weight:bold;" type="text" name="monthnametranslationbenaceurjuil" value="<?php echo $mntb_Juil; ?>" <?php echo $dis; ?> />
					<input style="font-weight:bold;" type="hidden" name="monthnametranslationbenaceurjuil" value="<?php echo $mntb_Juil; ?>" <?php echo $dis_h; ?> />
					</div>
                   </td>
                </tr>
                <tr valign="top">
                    <td>
					<div class="sm_benaceurlist_caps_input-mntb" id="h88521">
					<input style="font-weight:bold;" type="text" name="month_name_translation_benaceur_Aou" value="<?php echo $mntb_Aou; ?>" <?php echo $dis; ?> />
					<input style="font-weight:bold;" type="hidden" name="month_name_translation_benaceur_Aou" value="<?php echo $mntb_Aou; ?>" <?php echo $dis_h; ?> />
					</div>
                   </td>
                </tr>
                <tr valign="top">
                    <td>
					<div class="sm_benaceurlist_caps_input-mntb" id="h88521">
					<input style="font-weight:bold;" type="text" name="month_name_translation_benaceur_Sep" value="<?php echo $mntb_Sep; ?>" <?php echo $dis; ?> />
					<input style="font-weight:bold;" type="hidden" name="month_name_translation_benaceur_Sep" value="<?php echo $mntb_Sep; ?>" <?php echo $dis_h; ?> />
					</div>
                   </td>
                </tr>
                <tr valign="top">
                    <td>
					<div class="sm_benaceurlist_caps_input-mntb" id="h88521">
					<input style="font-weight:bold;" type="text" name="month_name_translation_benaceur_Oct" value="<?php echo $mntb_Oct; ?>" <?php echo $dis; ?> />
					<input style="font-weight:bold;" type="hidden" name="month_name_translation_benaceur_Oct" value="<?php echo $mntb_Oct; ?>" <?php echo $dis_h; ?> />
					</div>
                   </td>
                </tr>
                <tr valign="top">
                    <td>
					<div class="sm_benaceurlist_caps_input-mntb" id="h88521">
					<input style="font-weight:bold;" type="text" name="month_name_translation_benaceur_Nov" value="<?php echo $mntb_Nov; ?>" <?php echo $dis; ?> />
					<input style="font-weight:bold;" type="hidden" name="month_name_translation_benaceur_Nov" value="<?php echo $mntb_Nov; ?>" <?php echo $dis_h; ?> />
					</div>
                   </td>
                </tr>
                <tr valign="top">
                    <td>
					<div class="sm_benaceurlist_caps_input-mntb" id="h88521">
					<input style="font-weight:bold;" type="text" name="month_name_translation_benaceur_Dec" value="<?php echo $mntb_Dec; ?>" <?php echo $dis; ?> />
					<input style="font-weight:bold;" type="hidden" name="month_name_translation_benaceur_Dec" value="<?php echo $mntb_Dec; ?>" <?php echo $dis_h; ?> />
					</div>
                   </td>
                </tr>
              </table>
		</td>
		<td  width="50%">
              <table class="form-table-mntb">
                <tr valign="top">
                    <td style="word-wrap:break-word;min-width:20%;">
					<?php _e("Enter the new names of the months of your choice (in order):",'month-name-translation-benaceur'); ?>                   
                   </td>
                </tr>
                <tr valign="top">
                    <td>
					<div class="sm_benaceurlist_caps_input-mntb"><input style="font-weight:bold;" type="text" name="month_name_translation_benaceur_t_jan" value="<?php echo $mntb_t_jan; ?>" /></div>
                   </td>
                </tr>
                <tr valign="top">
                    <td>
					<div class="sm_benaceurlist_caps_input-mntb"><input style="font-weight:bold;" type="text" name="month_name_translation_benaceur_t_Fev" value="<?php echo $mntb_t_Fev; ?>" /></div>
                   </td>
                </tr>
                <tr valign="top">
                    <td>
					<div class="sm_benaceurlist_caps_input-mntb"><input style="font-weight:bold;" type="text" name="month_name_translation_benaceur_t_Mar" value="<?php echo $mntb_t_Mar; ?>" /></div>
                   </td>
                </tr>
                <tr valign="top">
                    <td>
					<div class="sm_benaceurlist_caps_input-mntb"><input style="font-weight:bold;" type="text" name="month_name_translation_benaceur_t_Avr" value="<?php echo $mntb_t_Avr; ?>" /></div>
                   </td>
                </tr>
                <tr valign="top">
                    <td>
					<div class="sm_benaceurlist_caps_input-mntb"><input style="font-weight:bold;" type="text" name="month_name_translation_benaceur_t_Mai" value="<?php echo $mntb_t_Mai; ?>" /></div>
                   </td>
                </tr>
                <tr valign="top">
                    <td>
					<div class="sm_benaceurlist_caps_input-mntb"><input style="font-weight:bold;" type="text" name="monthnametranslationbenaceurtjuin" value="<?php echo $mntb_t_Juin; ?>" /></div>
                   </td>
                </tr>
                <tr valign="top">
                    <td>
					<div class="sm_benaceurlist_caps_input-mntb"><input style="font-weight:bold;" type="text" name="monthnametranslationbenaceurtjuil" value="<?php echo $mntb_t_Juil; ?>" /></div>
                   </td>
                </tr>
                <tr valign="top">
                    <td>
					<div class="sm_benaceurlist_caps_input-mntb"><input style="font-weight:bold;" type="text" name="month_name_translation_benaceur_t_Aou" value="<?php echo $mntb_t_Aou; ?>" /></div>
                   </td>
                </tr>
                <tr valign="top">
                    <td>
					<div class="sm_benaceurlist_caps_input-mntb"><input style="font-weight:bold;" type="text" name="month_name_translation_benaceur_t_Sep" value="<?php echo $mntb_t_Sep; ?>" /></div>
                   </td>
                </tr>
                <tr valign="top">
                    <td>
					<div class="sm_benaceurlist_caps_input-mntb"><input style="font-weight:bold;" type="text" name="month_name_translation_benaceur_t_Oct" value="<?php echo $mntb_t_Oct; ?>" /></div>
                   </td>
                </tr>
                <tr valign="top">
                    <td>
					<div class="sm_benaceurlist_caps_input-mntb"><input style="font-weight:bold;" type="text" name="month_name_translation_benaceur_t_Nov" value="<?php echo $mntb_t_Nov; ?>" /></div>
                   </td>
                </tr>
                <tr valign="top">
                    <td>
					<div class="sm_benaceurlist_caps_input-mntb"><input style="font-weight:bold;" type="text" name="month_name_translation_benaceur_t_Dec" value="<?php echo $mntb_t_Dec; ?>" /></div>
                   </td>
                </tr>
              </table>
		</td>
	</tr>
<table style="margin-top:20px;" >
	
                <tr>  
                    <td> 
					<label class="switch-nab">				

	                    <input type="checkbox" class="switch-input" name="month_name_translation_benaceur_dis_input" value="1" <?php if( $mntb_disable_input) { echo 'checked="checked"'; } ?>/>
                        <span class="switch-label" data-on="On" data-off="Off"></span>
                        <span class="switch-handle"></span>
                   </label>
       <td class="mntb-td-sty"><?php _e('Enable editing names of the months', 'month-name-translation-benaceur'); ?></td>
				   </td>
                </tr>
</table>
</table>
							</div> <!-- .inside -->
                         
                    </div> <!-- .postbox -->
        </div> <!-- #post-body .metabox-holder .columns-2 -->
        <br class="clear">
    </div> <!-- #poststuff -->
</div> <!-- .wrap --> 

<div class="wrap588">
  <?php 
   $month_jan = mntb_get_month_name('1');
   $month_feb = mntb_get_month_name('2');
   $month_mar = mntb_get_month_name('3');
   $month_apr = mntb_get_month_name('4');
   $month_may = mntb_get_month_name('5');
   $month_jun = mntb_get_month_name('6');
   $month_jul = mntb_get_month_name('7');
   $month_aug = mntb_get_month_name('8');
   $month_sep = mntb_get_month_name('9');
   $month_oct = mntb_get_month_name('10');
   $month_nov = mntb_get_month_name('11');
   $month_dec = mntb_get_month_name('12');
  ?>
<div class="wrap">
    <div id="poststuff">
        <div id="post-body" class="metabox-holder columns-2">
            <!-- sidebar -->
            <div id="postbox-container-3" class="postbox-container">
                    <div class="postbox">
                     
                        <div style="font-weight:bold;font-size:16px;font-family:arial;padding-right:18px;padding-left:18px;margin-top:14px;"><?php _e("The current names of months in your site",'month-name-translation-benaceur'); ?></div>
                        <div class="inside">
                            <table class="form-table">
                            <tr>
                                <td><label for="mash_b"><?php echo $month_jan; ?></label></td>
                            </tr>
                            <tr>
                                <td><label for="mash_b"><?php echo $month_feb; ?></label></td>
                            </tr>
                            <tr>
                                <td><label for="mash_b"><?php echo $month_mar; ?></label></td>
                            </tr>
                            <tr>
                                <td><label for="mash_b"><?php echo $month_apr; ?></label></td>
                            </tr>
                            <tr>
                                <td><label for="mash_b"><?php echo $month_may; ?></label></td>
                            </tr>
                            <tr>
                                <td><label for="mash_b"><?php echo $month_jun; ?></label></td>
                            </tr>
                            <tr>
                                <td><label for="mash_b"><?php echo $month_jul; ?></label></td>
                            </tr>
                            <tr>
                                <td><label for="mash_b"><?php echo $month_aug; ?></label></td>
                            </tr>
                            <tr>
                                <td><label for="mash_b"><?php echo $month_sep; ?></label></td>
                            </tr>
                            <tr>
                                <td><label for="mash_b"><?php echo $month_oct; ?></label></td>
                            </tr>
                            <tr>
                                <td><label for="mash_b"><?php echo $month_nov; ?></label></td>
                            </tr>
                            <tr>
                                <td><label for="mash_b"><?php echo $month_dec; ?></label></td>
                            </tr>
                            </table>
							</div> <!-- .inside -->
                         
                    </div> <!-- .postbox -->
            </div> <!-- #postbox-container-1 .postbox-container -->
        </div> <!-- #post-body .metabox-holder .columns-2 -->
        <br class="clear">
    </div> <!-- #poststuff -->
</div> <!-- .wrap --> 
</div>  

<div class="wrap588"><div id="poststuff"><div id="post-body" class="metabox-holder columns-2"><div class="postbox">
<div class="inside">
<table style="margin-top:20px;" >
                <tr>  
                    <td> 
					<label class="switch-nab">				

	                    <input type="checkbox" class="switch-input" name="month_name_translation_benaceur_enable_admin" value="1" <?php  if( !empty($mntb_enable_admin) ) { echo 'checked="checked"'; } ?>/>
                        <span class="switch-label" data-on="On" data-off="Off"></span>
                        <span class="switch-handle"></span>
                   </label>
       <td class="mntb-td-sty"><?php _e('Disable in admin panel', 'month-name-translation-benaceur'); ?></td>
				   </td>
                </tr>
                <tr>  
                    <td> 
					<label class="switch-nab">				

	                    <input type="checkbox" class="switch-input" name="month_name_translation_benaceur_enable_front" value="1" <?php  if( !empty($mntb_enable_front) ) { echo 'checked="checked"'; } ?>/>
                        <span class="switch-label" data-on="On" data-off="Off"></span>
                        <span class="switch-handle"></span>
                   </label>
       <td class="mntb-td-sty"><?php _e('Disable in site interface', 'month-name-translation-benaceur'); ?></td>
				   </td>
                </tr>
</table>
				
<table style="margin-top:20px;" >
					<tr>
						<td>
                   <input type="radio" name="month_name_translation_benaceur_delete_all_options" value="delete_opt_mntb" <?php if( $mntb_delete_all_options == 'delete_opt_mntb')echo 'checked';?> >
                    <td><?php _e("Remove all settings and data of the plugin from database when the plugin is disabled",'month-name-translation-benaceur'); ?></td>
						</td>
					</tr>
					<tr> 
						<td>
                   <input type="radio" name="month_name_translation_benaceur_delete_all_options" value="no_delete_opt_mntb" <?php if( $mntb_delete_all_options == 'no_delete_opt_mntb')echo 'checked';?> >
						</td>
                   <td><?php _e("Do not delete",'month-name-translation-benaceur'); ?></td>
					</tr>
</table>
<br />
<table style="margin-top:20px;" >
	
                <tr>  
                    <td> 
					<label class="switch-nab">				

	                    <input type="checkbox" class="switch-input" name="month_name_translation_benaceur_hide_icon_evol_plug" value="1" <?php if( $mntb_hide_icon_evol_plug) { echo 'checked="checked"'; } ?>/>
                        <span class="switch-label" data-on="On" data-off="Off"></span>
                        <span class="switch-handle"></span>
                   </label>
       <td class="mntb-td-sty"><?php _e('Hide the plugin rating icon', 'month-name-translation-benaceur'); ?></td>
				   </td>
                </tr>
</table>
</div> <!-- .inside -->
</div></div><br class="clear"></div></div>  

					<p><?php submit_button(); ?></p>
        </form>
		
<br />
<div id="month-name-translation-benaceur-font">
<br /><div class="to-tr"></div>
<br />
    <form action="options.php" method="post">
            <?php settings_fields( 'month_name_translation_benaceur_all_reset' ); ?>
	  <input type="hidden"  name="mntb_all_reset" value="1" <?php if(empty($mntb_all_reset) ) { echo 'checked="checked"'; } ?>/>
      <input type="submit" value="<?php _e('Reset all settings', 'month-name-translation-benaceur');?>" class="button-secondary" />
    </form>
<p><?php _e("<strong>Note:</strong> If you change the language of your site from one language to another be sure to reset the plugin settings (Reset all settings)",'month-name-translation-benaceur'); ?></p>
<br />
    </div>
	
<br /><br />
<?php if(empty($mntb_hide_icon_evol_plug)) {?>
<div class="hov-button-primary-sub-mntb"><div class="button button-primary"><a target="_blank" href="https://wordpress.org/support/view/plugin-reviews/month-name-translation-benaceur?filter=5"><?php _e('Do not forget to rate the plugin', 'month-name-translation-benaceur');?></a></div></div>
<?php } ?>

</br>

<div class="c-sub-mntb">		
<div id="sub-mntb">
<a target="_blank" href="https://wordpress.org/plugins/news-ticker-benaceur/">https://wordpress.org/plugins/news-ticker-benaceur</a><br /><br />
<a target="_blank" href="https://wordpress.org/plugins/notification-msg-interface-benaceur/">https://wordpress.org/plugins/notification-msg-interface-benaceur</a><br /><br />
<a target="_blank" href="https://wordpress.org/plugins/notification-admin-panel-benaceur/">https://wordpress.org/plugins/notification-admin-panel-benaceur</a><br /><br />
<a target="_blank" href="https://wordpress.org/plugins/month-name-translation-benaceur/">https://wordpress.org/plugins/month-name-translation-benaceur</a>
<br /><br />
</div>
<input type='button'  id='bt-mntb' class="button-secondary" value='<?php _e('My plugins', 'month-name-translation-benaceur'); ?>' onclick="setVisibility_mntb('sub-mntb');";>
</div>

<style>
.mntb-new {background:url(<?php echo plugins_url( 'img/mntb-new.gif', __FILE__ ) ; ?>) no-repeat ;width:33px; height:11px;}
div.postbox {background: #fff url(<?php echo plugins_url( 'img/benaceur.png', __FILE__ ) ; ?>) repeat ;width:100%;border-radius: 5px;}
</style>

<script language="JavaScript">
function setVisibility_mntb(id) {
if(document.getElementById('bt-mntb').value=='<?php _e('Hide this list', 'month-name-translation-benaceur'); ?>'){
document.getElementById('bt-mntb').value = '<?php _e('My plugins', 'month-name-translation-benaceur'); ?>';
document.getElementById(id).style.display = 'none';
}else{
document.getElementById('bt-mntb').value = '<?php _e('Hide this list', 'month-name-translation-benaceur'); ?>';
document.getElementById(id).style.display = 'inline';
}
}
</script>

   <?php
  }

