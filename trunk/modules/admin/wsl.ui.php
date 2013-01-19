<?php
function wsl_render_settings()
{
	if ( ! wsl_check_requirements() ){
		include "wsl.fail.php";

		exit();
	}

	GLOBAL $WORDPRESS_SOCIAL_LOGIN_PROVIDERS_CONFIG;

	$tabs = array(
		"overview"     => array( "label" => "Overview"       , "enabled" => false, "visible" => false ),
		"networks"     => array( "label" => "Networks"       , "enabled" => true, "visible" => true , "default" => true ),
		"login-widget" => array( "label" => "Widget"         , "enabled" => true, "visible" => true ), 
		"bouncer"      => array( "label" => "Bouncer"        , "enabled" => true, "visible" => true ),
		"share"        => array( "label" => "Sharing"        , "enabled" => false, "visible" => false ),
		"users"        => array( "label" => "Users"          , "enabled" => true, "visible" => true ),
		"contacts"     => array( "label" => "Contacts"       , "enabled" => true, "visible" => true ),
		"diagnostics"  => array( "label" => "Diagnostics"    , "enabled" => true, "visible" => false , "pull-right" => true ),
		"help"         => array( "label" => "Help & Support" , "enabled" => true, "visible" => true  , "pull-right" => true ),
	);

	$wslp = trim( strtolower( strip_tags( $_REQUEST["wslp"] ) ) );

	if( isset( $tabs[$wslp] ) && $tabs[$wslp]["enabled"] ){
		include "wsl.header.php";
		include "wsl.$wslp.php";
	}
	else{
		$wslp = "networks";
		include "wsl.header.php";
		include "wsl.networks.php";
	}
}
