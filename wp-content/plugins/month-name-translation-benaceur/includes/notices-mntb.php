<?php
add_action('admin_notices', 'MNTB_notice');

function MNTB_notice() {

if ( current_user_can( 'administrator' ) )
{

	global $current_user;
	$user_id = $current_user->ID;
    $mden_n = mntb_28_07_15_en_mntb;
	
	if ( ! get_user_meta($user_id, 'MNTB_notice_ignore_n') ) {
		    ?>
			<div class="updated" id="<?php echo $mden_n;  ?>" style="margin-top:40px;"><p>
			<span class="hov-mib-en" onmouseup="setcookie('<?php echo $mden_n;  ?>',1)" style="color:#009999;"><strong><span style="margin-top:1px;" class="dashicons dashicons-dismiss"></span> &nbsp;</strong></span>
			<?php _e('After this update Click on ctl+F5 to purge the browser cache ( For those who have installed the previous version(s) only )', 'month-name-translation-benaceur'); ?>
			</p></div>
			
<style>.hov-mib-en:hover {cursor:pointer;}</style>			
			
<script type="text/javascript">
function CheckCookieMNTB(<?php echo $mden_n;  ?>){
 if (cookie(<?php echo $mden_n;  ?>)){
  document.getElementById(<?php echo $mden_n;  ?>).style.display='none';
 }
}

function setcookie(<?php echo $mden_n;  ?>,days){
 document.cookie=<?php echo $mden_n;  ?>+'=true;expires='+(new Date(new Date().getTime()+(1000*60*60*24*30*12)).toGMTString())+';path=/'; //one years
 document.getElementById(<?php echo $mden_n;  ?>).style.display='none';
}

function cookie(<?php echo $mden_n;  ?>){
 var re=new RegExp(<?php echo $mden_n;  ?>+'[^;]+','i');
 if (document.cookie.match(re)){
  return document.cookie.match(re)[0].split("=")[1];
 }
 return null;
}

 CheckCookieMNTB('<?php echo $mden_n;  ?>');
</script>

<?php
}
}	
}
?>
