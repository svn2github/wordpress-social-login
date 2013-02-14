<?php
/*!
* WordPress Social Login
*
* http://hybridauth.sourceforge.net/wsl/index.html | http://github.com/hybridauth/WordPress-Social-Login
*   (c) 2013 Mohamed Mrassi and other contributors | http://wordpress.org/extend/plugins/wordpress-social-login/
*/

/** 
* The LOC in charge of displaying WSL Admin GUInterfaces
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// --------------------------------------------------------------------

function wsl_render_settings()
{
	if ( ! wsl_check_requirements() ){
		wsl_admin_ui_fail();

		exit;
	}

	GLOBAL $WORDPRESS_SOCIAL_LOGIN_ADMIN_TABS;
	GLOBAL $WORDPRESS_SOCIAL_LOGIN_COMPONENTS;
	GLOBAL $WORDPRESS_SOCIAL_LOGIN_PROVIDERS_CONFIG;
	GLOBAL $WORDPRESS_SOCIAL_LOGIN_VERSION;
	GLOBAL $wpdb;

	if( isset( $_REQUEST["enable"] ) && isset( $WORDPRESS_SOCIAL_LOGIN_COMPONENTS[ $_REQUEST["enable"] ] ) ){
		$component = $_REQUEST["enable"];

		$WORDPRESS_SOCIAL_LOGIN_COMPONENTS[ $component ][ "enabled" ] = true;

		update_option( "wsl_components_" . $component . "_enabled", 1 );

		wsl_register_components();
	}

	if( isset( $_REQUEST["disable"] ) && isset( $WORDPRESS_SOCIAL_LOGIN_COMPONENTS[ $_REQUEST["disable"] ] ) ){
		$component = $_REQUEST["disable"];

		$WORDPRESS_SOCIAL_LOGIN_COMPONENTS[ $component ][ "enabled" ] = false;

		update_option( "wsl_components_" . $component . "_enabled", 2 );

		wsl_register_components();
	}

	$wslp            = "networks";
	$wsldwp          = 0;
	$assets_base_url = WORDPRESS_SOCIAL_LOGIN_PLUGIN_URL . '/assets/img/16x16/';

	if( isset( $_REQUEST["wslp"] ) ){
		$wslp = trim( strtolower( strip_tags( $_REQUEST["wslp"] ) ) );
	}

	if( isset( $WORDPRESS_SOCIAL_LOGIN_ADMIN_TABS[$wslp] ) && $WORDPRESS_SOCIAL_LOGIN_ADMIN_TABS[$wslp]["enabled"] ){
		if( isset( $WORDPRESS_SOCIAL_LOGIN_ADMIN_TABS[$wslp]["header_action"] ) && $WORDPRESS_SOCIAL_LOGIN_ADMIN_TABS[$wslp]["header_action"] ){ 
			do_action( $WORDPRESS_SOCIAL_LOGIN_ADMIN_TABS[$wslp]["header_action"] );
		}

		wsl_admin_ui_header( $wslp );

		if( isset( $WORDPRESS_SOCIAL_LOGIN_ADMIN_TABS[$wslp]["body_action"] ) && $WORDPRESS_SOCIAL_LOGIN_ADMIN_TABS[$wslp]["body_action"] ){ 
			do_action( $WORDPRESS_SOCIAL_LOGIN_ADMIN_TABS[$wslp]["body_action"] );
		}

		elseif( ! ( isset( $WORDPRESS_SOCIAL_LOGIN_ADMIN_TABS[$wslp]["admin-url"] ) && ! $WORDPRESS_SOCIAL_LOGIN_ADMIN_TABS[$wslp]["admin-url"] ) ){
			include "components/$wslp/index.php";

			wsl_admin_ui_footer();
		}
	}
	else{
		wsl_admin_ui_header();

		wsl_admin_ui_error();
	}
}

// --------------------------------------------------------------------

function wsl_render_wp_editor( $name, $content )
{
	// HOOKABLE: 
	do_action( "wsl_render_wp_editor_start" );
?>
<div class="postbox"> 
	<div class="wp-editor-textarea">
	<?php 
		wp_editor( 
			$content, $name, 
			array( 'textarea_name' => $name, 'media_buttons' => true, 'tinymce' => array( 'theme_advanced_buttons1' => 'formatselect,forecolor,|,bold,italic,underline,|,justifyleft,justifycenter,justifyright,justifyfull,|,link,unlink' ) ) 
		);
	?>
	</div> 
</div>
<?php
	// HOOKABLE: 
	do_action( "wsl_render_wp_editor_end" );
}

// --------------------------------------------------------------------

function wsl_admin_ui_header( $wslp = null )
{
	// HOOKABLE: 
	do_action( "wsl_admin_ui_header_start" );
	
	GLOBAL $WORDPRESS_SOCIAL_LOGIN_VERSION;
	GLOBAL $WORDPRESS_SOCIAL_LOGIN_ADMIN_TABS;
?>
<style>
h1 {
	color: #333333;
	text-shadow: 1px 1px 1px #FFFFFF; 
	font-size: 2.8em;
	font-weight: 200;
	line-height: 1.2em;
	margin: 0.2em 200px 0.6em 0.2em;
}
h2 .nav-tab {
	color: #21759B;
}
h2 .nav-tab-active {
	color: #464646;
	text-shadow: 1px 1px 1px #FFFFFF;
}
hr{ 
	border-color: #EEEEEE;
	border-style: none none solid;
	border-width: 0 0 1px;
	margin: 2px 0 15px;
} 
.wsldiv { 
	margin: 25px 40px 0 20px; 
}
.wsldiv p{  
	line-height: 1.8em;
}
.wslgn{ 
	margin-left:20px;
}
.wslgn p{ 
	margin-left:20px;
}
.wslpre{ 
	font-size:14m;
	border:1px solid #E6DB55; 
	border-radius: 3px;
	padding:5px;
	width:650px;
}
ul {
	list-style: disc outside none;
}
 
.thumbnails:before,
.thumbnails:after {
  display: table;
  line-height: 0;
  content: "";
}

.thumbnail {
  display: block;
  padding: 4px;
  line-height: 20px;
  border: 1px solid #ddd;
  -webkit-border-radius: 4px;
	 -moz-border-radius: 4px;
		  border-radius: 4px;
  -webkit-box-shadow: 0 1px 3px rgba(0, 0, 0, 0.055);
	 -moz-box-shadow: 0 1px 3px rgba(0, 0, 0, 0.055);
		  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.055);
  -webkit-transition: all 0.2s ease-in-out;
	 -moz-transition: all 0.2s ease-in-out;
	   -o-transition: all 0.2s ease-in-out;
		  transition: all 0.2s ease-in-out;
}

a.thumbnail:hover {
  border-color: #0088cc;
  -webkit-box-shadow: 0 1px 4px rgba(0, 105, 214, 0.25);
	 -moz-box-shadow: 0 1px 4px rgba(0, 105, 214, 0.25);
		  box-shadow: 0 1px 4px rgba(0, 105, 214, 0.25);
}

.thumbnail > img {
  display: block;
  max-width: 100%;
  margin-right: auto;
  margin-left: auto;
}

.thumbnail .caption {
  padding: 9px;
  color: #555555;
}
.span4 {  
	width: 220px; 
}
#wp-social-login-connect-with {  
	font-size: 14px; 
}
#wp-social-login-connect-options {  
	margin:5px; 
}
.wsl_connect_with_provider {  
	text-decoration:none; 
	cursor:not-allowed;
} 
#wsl-w-panel {
	background: linear-gradient(to top, #F5F5F5, #FAFAFA) repeat scroll 0 0 #F5F5F5;
	border-color: #DFDFDF;
	border-radius: 3px 3px 3px 3px;
	border-style: solid;
	border-width: 1px;
	font-size: 13px;
	line-height: 2.1em;
	margin: 20px 0;
	overflow: auto;
	-padding: 23px 10px 12px;
	padding: 5px;
	position: relative;
}
#wsl-w-panel-dismiss {
	font-size: 13px;
	line-height: 1;
	padding: 8px 3px;
	position: absolute;
	right: 10px;
	text-decoration: none;
	top: 0px;
}
#wsl-w-panel-updates-tr {
	display:none;  
} 
.hideinside {
	/* display:none; */
} 

.wp-editor-textarea{
  width:98%;
  padding:1%;
  font-family:"Trebuchet MS", Arial, verdana, sans-serif;
}
.wp-editor-textarea textarea{
  height:100px;
}

.wp-editor-textarea input {
	width: auto !important;
}

#wsl_i18n_pre {
	height: 800px; 
	overflow-x: hidden;
	overflow-y: scroll;
}  
#wsl_i18n {
	width:530px; 
	display:none;
	padding: 10px; 
	border: 1px solid #ddd; 
	background-color: #fff;  
	float:left;
	margin-left: 20px;
	padding: 0 10px 10px; 
} 
#wsl_i18n_form {
	width:420px; 
	display:none;
	padding: 10px; 
	border: 1px solid #ddd; 
	background-color: #fff;
	float:left; 
}
#wsl_i18n_cla {
	display:none;
	padding: 10px;  
	border: 1px solid #ddd; 
	background-color: #fff; 
	
	width: 50%;
	margin: 0px auto;
	margin-top:50px;
}
</style>
<a name="wsltop"></a>
<div class="wsldiv">
<h1>
	WordPress Social Login

	<small><?php echo $WORDPRESS_SOCIAL_LOGIN_VERSION ?></small>

	<?php
		if( get_option( 'wsl_settings_development_mode_enabled' ) ){
			?>
				<span style="color:red;-font-size: 14px;">(<?php _e("Development mode is enabled!", 'wordpress-social-login') ?>)</span>
			<?php
		}
	?>
</h1>
 
<h2 class="nav-tab-wrapper">
	&nbsp;
	<?php
		foreach( $WORDPRESS_SOCIAL_LOGIN_ADMIN_TABS as $name => $settings ){
			if( $settings["enabled"] && ( $settings["visible"] || $wslp == $name ) ){
				if( isset( $settings["admin-url"] ) ){
					?><a class="nav-tab <?php if( $wslp == $name ) echo "nav-tab-active"; ?>" <?php if( isset( $settings["pull-right"] ) && $settings["pull-right"] ) echo 'style="float:right"'; ?> href="<?php echo $settings["admin-url"] ?>"><?php echo $settings["label"] ?></a><?php
				}
				else{
					?><a class="nav-tab <?php if( $wslp == $name ) echo "nav-tab-active"; ?>" <?php if( isset( $settings["pull-right"] ) && $settings["pull-right"] ) echo 'style="float:right"'; ?> href="options-general.php?page=wordpress-social-login&wslp=<?php echo $name ?>"><?php echo $settings["label"] ?></a><?php
				}
			}
		} 
	?>
</h2>

<div id="wsl_admin_tab_content">
<?php
	// HOOKABLE: 
	do_action( "wsl_admin_ui_header_end" );
}

// --------------------------------------------------------------------

function wsl_admin_ui_footer()
{
	// HOOKABLE: 
	do_action( "wsl_admin_ui_footer_start" );

	GLOBAL $WORDPRESS_SOCIAL_LOGIN_VERSION;
?>
</div> <!-- ./wsl_admin_tab_content -->  
<div class="clear"></div>
<?php wsl_admin_localize_widget(); ?>

<script>
	// check for new versions and updates
	jQuery.getScript("http://hybridauth.sourceforge.net/wsl/wsl.version.check.and.updates.php?v=<?php echo $WORDPRESS_SOCIAL_LOGIN_VERSION ?>");
</script>
<?php
	// HOOKABLE: 
	do_action( "wsl_admin_ui_footer_end" );
}

// --------------------------------------------------------------------

function wsl_admin_ui_error()
{
	// HOOKABLE: 
	do_action( "wsl_admin_ui_error_start" );
?>
<h3><?php _e('Something wrong!', 'wordpress-social-login') ?></h3>

<p>
	<?php _e('Unknown or Disabled component! Check the list of enabled components or the typed URL.', 'wordpress-social-login') ?>
	<?php _e("If you believe you've found a problem with <b>WordPress Social Login</b>, be sure to let us know so we can fix it.", 'wordpress-social-login') ?>
</p>
<?php
	// HOOKABLE: 
	do_action( "wsl_admin_ui_error_end" );
}

// --------------------------------------------------------------------

function wsl_admin_ui_fail()
{
	// HOOKABLE: 
	do_action( "wsl_admin_ui_fail_start" );
?>
<style> 
h1 {
    color: #333333;
    text-shadow: 1px 1px 1px #FFFFFF; 
    font-size: 2.8em;
    font-weight: 200;
    line-height: 1.2em;
    margin: 0.2em 200px 0 0;
} 
hr{ 
	border-color: #EEEEEE;
	border-style: none none solid;
	border-width: 0 0 1px;
	margin: 2px 0 15px;
}
.wsldiv { 
    margin: 30px 70px 0 70px; 
}
.wsldiv p{ 
    ont-size: 14px;
	line-height: 1.8em;
}
.wslpre{ 
    font-size:14m;
	border:1px solid #E6DB55; 
	border-radius: 3px;
	padding:5px;
	width:650px;
}
ul {
    list-style: disc outside none;
}
</style>

<div class="wsldiv">
	<h1><?php _e("WordPress Social Login - FAIL!", 'wordpress-social-login') ?></h1>

	<hr />
	
	<p> 
		<?php _e('Despite the efforts, the plugin <a href="http://profiles.wordpress.org/miled/" target="_blank">author</a> and other <a href="https://github.com/hybridauth/WordPress-Social-Login/graphs/contributors" target="_blank">contributors</a>, put into <b>WordPress Social Login</b> in terms of reliability, portability, <br />and maintenance', 'wordpress-social-login') ?>.
		<b style="color:red;"><?php _e('Your server failed the requirements check for this plugin!', 'wordpress-social-login') ?></b>
	</p> 
	<p> 
		<?php _e('These requirements are usually met by default by most "modern" web hosting providers, however some complications may <br />occur with <b>shared hosting</b> and, or <b>custom wordpress installations</b>', 'wordpress-social-login') ?>.
	</p> 
	<p> 
		<?php _e("To determine what may cause this failure, run the <b>WordPress Social Login Requirements Test</b> by clicking the button bellow", 'wordpress-social-login') ?>:
		
		<br />
		<br />
		<a class="button-primary" href='<?php echo WORDPRESS_SOCIAL_LOGIN_PLUGIN_URL ?>/services/diagnostics.php' target='_blank'><?php _e("Run the plugin requirements test", 'wordpress-social-login') ?></a> 
		<a class="button-primary" href='<?php echo WORDPRESS_SOCIAL_LOGIN_PLUGIN_URL ?>/services/siteinfo.php' target='_blank'><?php _e("System Information", 'wordpress-social-login') ?></a> 
	</p> 
 
	<br /> 
	<hr />
 
	<p>
		<?php _e("<b>WordPress Social Login</b> is an open source software licenced under The MIT License (MIT)", 'wordpress-social-login') ?>
	</p> 

<pre class="wslpre">
	Copyright (C) 2011-2013 Mohamed Mrassi and contributors

	Permission is hereby granted, free of charge, to any person obtaining
	a copy of this software and associated documentation files (the
	"Software"), to deal in the Software without restriction, including
	without limitation the rights to use, copy, modify, merge, publish,
	distribute, sublicense, and/or sell copies of the Software, and to
	permit persons to whom the Software is furnished to do so, subject to
	the following conditions:

	The above copyright notice and this permission notice shall be
	included in all copies or substantial portions of the Software.

	THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
	EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
	MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
	NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
	LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
	OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
	WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
</pre>
<br />
<?php
	// HOOKABLE: 
	do_action( "wsl_admin_ui_fail_end" );
}

// --------------------------------------------------------------------
