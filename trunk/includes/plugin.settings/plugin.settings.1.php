<script>
	function toggleproviderkeys(idp){
		if(typeof jQuery=="undefined"){
			alert( "Error: WordPress Social Login require jQuery to be installed on your wordpress in ordezr to works!" );

			return;
		}

		if(jQuery('#wsl_settings_' + idp + '_enabled').val()==1){
			jQuery('.wsl_tr_settings_' + idp).show();
		}
		else{
			jQuery('.wsl_tr_settings_' + idp).hide();
		}
		
		return false;
	}
	
	function toggleproviderhelp(idp){
		if(typeof jQuery=="undefined"){
			alert( "Error: WordPress Social Login require jQuery to be installed on your wordpress in ordezr to works!" );

			return false;
		}

		jQuery('.wsl_div_settings_help_' + idp).show();
		
		return false;
	}
</script>

<form method="post" id="wsl_setup_form" action="options.php"> 

	<?php settings_fields( 'wsl-settings-group' ); ?>
	
	
	
	
	
	
<div class="metabox-holder columns-2" id="post-body">

<table width="100%">
<tbody>
<tr valign="top">
<td>
							
<div  id="post-body-content">
 
<?php 
	$nbprovider = 0;
	
	foreach( $WORDPRESS_SOCIAL_LOGIN_PROVIDERS_CONFIG AS $item ):
		$provider_id                = @ $item["provider_id"];
		$provider_name              = @ $item["provider_name"];

		$require_client_id          = @ $item["require_client_id"];
		$provide_email              = @ $item["provide_email"];
		
		$provider_new_app_link      = @ $item["new_app_link"];
		$provider_userguide_section = @ $item["userguide_section"];

		$provider_callback_url      = "" ;

		if( isset( $item["callback"] ) && $item["callback"] ){
			$provider_callback_url  = '<span style="color:green">' . WORDPRESS_SOCIAL_LOGIN_HYBRIDAUTH_ENDPOINT_URL	 . '?hauth.done=' . $provider_id . '</span>';
		}

		$setupsteps = 0; 

		$assets_base_url = WORDPRESS_SOCIAL_LOGIN_PLUGIN_URL . '/assets/img/16x16/';
?>  
		<div class="stuffbox" id="namediv">
			<h3>
				<label for="name">
					<img alt="<?php echo $provider_name ?>" title="<?php echo $provider_name ?>" src="<?php echo $assets_base_url . strtolower( $provider_id ) . '.png' ?>" style="vertical-align: top;width:16px;height:16px;" /> <?php echo $provider_name ?>
				</label>
			</h3>
			<div class="inside">
				<table class="form-table editcomment">
					<tbody>
						<tr valign="top">
							<td style="width:110px">Enabled:</td>
							<td>
								<select 
									name="<?php echo 'wsl_settings_' . $provider_id . '_enabled' ?>" 
									id="<?php echo 'wsl_settings_' . $provider_id . '_enabled' ?>" 
									onChange="toggleproviderkeys('<?php echo $provider_id; ?>')" 
								>
									<option value="1" <?php if(   get_option( 'wsl_settings_' . $provider_id . '_enabled' ) ) echo "selected"; ?> >Yes</option>
									<option value="0" <?php if( ! get_option( 'wsl_settings_' . $provider_id . '_enabled' ) ) echo "selected"; ?> >No</option>
								</select>
							</td>
							<td style="width:140px">&nbsp;</td>
						</tr>

						<?php if ( $provider_new_app_link ){ ?>
							<?php if ( $require_client_id ){ // key or id ? ?>
								<tr valign="top" <?php if( ! get_option( 'wsl_settings_' . $provider_id . '_enabled' ) ) echo 'style="display:none"'; ?> class="wsl_tr_settings_<?php echo $provider_id; ?>" >
									<td>Application ID:</td>
									<td><input type="text" name="<?php echo 'wsl_settings_' . $provider_id . '_app_id' ?>" value="<?php echo get_option( 'wsl_settings_' . $provider_id . '_app_id' ); ?>" ></td>
									<td><a href="javascript:void(0)" onClick="toggleproviderhelp('<?php echo $provider_id; ?>')">Where do I get this info?</a></td>
								</tr> 
							<?php } else { ?>
								<tr valign="top" <?php if( ! get_option( 'wsl_settings_' . $provider_id . '_enabled' ) ) echo 'style="display:none"'; ?> class="wsl_tr_settings_<?php echo $provider_id; ?>" >
									<td>Application Key:</td>
									<td><input type="text" name="<?php echo 'wsl_settings_' . $provider_id . '_app_key' ?>" value="<?php echo get_option( 'wsl_settings_' . $provider_id . '_app_key' ); ?>" ></td>
									<td><a href="javascript:void(0)" onClick="toggleproviderhelp('<?php echo $provider_id; ?>')">Where do I get this info?</a></td>
								</tr>  
							<?php }; ?>	 
								<tr valign="top" <?php if( ! get_option( 'wsl_settings_' . $provider_id . '_enabled' ) ) echo 'style="display:none"'; ?> class="wsl_tr_settings_<?php echo $provider_id; ?>" >
									<td>Application Secret:</td>
									<td><input type="text" name="<?php echo 'wsl_settings_' . $provider_id . '_app_secret' ?>" value="<?php echo get_option( 'wsl_settings_' . $provider_id . '_app_secret' ); ?>" ></td>
									<td><a href="javascript:void(0)" onClick="toggleproviderhelp('<?php echo $provider_id; ?>')">Where do I get this info?</a></td>
								</tr>
						<?php } // if require registration ?> 
					</tbody>
				</table> 
				<?php if ( in_array( $provider_id, array( "Twitter", "Identica", "Tumblr", "Goodreads", "500px", "Vkontakte", "Gowalla", "Steam" ) ) ) : ?>
				<br />
				&nbsp;&nbsp;&nbsp;<b  style="color:#CB4B16;">Note:</b> The <b><?php echo $provider_name ?></b> API do not return a user's email address. A random email will then be generated instead.<br />
				<?php endif; ?> 
				<br />
				<div class="wsl_div_settings_help_<?php echo $provider_id; ?>" style="display:none;"> 
					<hr class="wsl" />
					<span style="color:#CB4B16;">Application</span> id and secret (also sometimes referred as <span style="color:#CB4B16;">Customer</span> key and secret or <span style="color:#CB4B16;">Client</span> id and secret) are what we call an application credentials. 
					This application will link your website <code><?php echo $_SERVER["SERVER_NAME"] ?></code> to <code><?php echo $provider_name ?> API</code> and these credentials are needed in order for <b><?php echo $provider_name ?></b> users to access your website. 
					<br />
					These credentials may also differ in format, name and content depending on the social network.
					<br />
					<br />
					To enable authentication with this provider and register a new application linking <b><?php echo $provider_name ?> API</b> to your website, follow carefully the steps:<br />
					<div class="wsl_div_settings_help_<?php echo $provider_id; ?>" style="margin-left:40px;">
						<?php if ( $provider_new_app_link  ) : ?> 
								<p><?php echo "<b>" . ++$setupsteps . "</b>." ?> Go to <a href="<?php echo $provider_new_app_link ?>" target ="_blanck"><?php echo $provider_new_app_link ?></a> and <b>create a new application</b>.</p>

								<?php if ( $provider_id == "Google" ) : ?>
										<p><?php echo "<b>" . ++$setupsteps . "</b>." ?> On the <b>Dashboard sidebar</b> click on <b>API Access</b> then Click <em style="color:#CB4B16;">"Create an OAuth 2.0 client ID..."</em>.</p> 
								<?php endif; ?>  

								<?php if ( $provider_id == "Google" ) : ?>  
												</p>
												<p><?php echo "<b>" . ++$setupsteps . "</b>." ?> On the <b>"Create Client ID"</b> popup :
												<br />&nbsp;&nbsp; - Enter a product name (the name of your website will do).
												<br />&nbsp;&nbsp; - Enter the URL for a logo if you like.
												<br />&nbsp;&nbsp; - Click Next.
												<br />&nbsp;&nbsp; - Select <em style="color:#CB4B16;">"Web application"</em> as the application type.
												<br />&nbsp;&nbsp; - Then switch to advanced settings by clicking on <b>(more options)</b>
												.</p>
								<?php else: ?>  
										<p><?php echo "<b>" . ++$setupsteps . "</b>." ?> Fill out any required fields such as the application name and description.</p> 
								<?php endif; ?> 

								<?php if ( $provider_callback_url ) : ?>
										<p>
												<?php echo "<b>" . ++$setupsteps . "</b>." ?> Provide this URL as the <b>Callback URL</b> for your application:
												<br />
												<?php echo $provider_callback_url ?>
										</p>
								<?php endif; ?> 

								<?php if ( $provider_id == "MySpace" ) : ?>
										<p><?php echo "<b>" . ++$setupsteps . "</b>." ?> Put your website domain in the <b>External Url</b> and <b>External Callback Validation</b> fields. This should match with the current hostname <em style="color:#CB4B16;"><?php echo $_SERVER["SERVER_NAME"] ?></em>.</p>
								<?php endif; ?> 

								<?php if ( $provider_id == "Live" ) : ?>
										<p><?php echo "<b>" . ++$setupsteps . "</b>." ?> Put your website domain in the <b>Redirect Domain</b> field. This should match with the current hostname <em style="color:#CB4B16;"><?php echo $_SERVER["SERVER_NAME"] ?></em>.</p>
								<?php endif; ?> 

								<?php if ( $provider_id == "Facebook" ) : ?>
										<p><?php echo "<b>" . ++$setupsteps . "</b>." ?> Put your website domain in the <b>Site Url</b> field. This should match with the current hostname <em style="color:#CB4B16;"><?php echo $_SERVER["SERVER_NAME"] ?></em>.</p> 
								<?php endif; ?> 

								<?php if ( $provider_id == "LinkedIn" ) : ?>
										<p><?php echo "<b>" . ++$setupsteps . "</b>." ?> Put your website domain in the <b>Integration URL</b> field. This should match with the current hostname <em style="color:#CB4B16;"><?php echo $_SERVER["SERVER_NAME"] ?></em>.</p> 
										<p><?php echo "<b>" . ++$setupsteps . "</b>." ?> Set the <b>Application Type</b> to <em style="color:#CB4B16;">Web Application</em>.</p> 
								<?php endif; ?> 

								<?php if ( $provider_id == "Twitter" ) : ?>
										<p><?php echo "<b>" . ++$setupsteps . "</b>." ?> Put your website domain in the <b>Application Website</b> and <b>Application Callback URL</b> fields. This should match with the current hostname <em style="color:#CB4B16;"><?php echo $_SERVER["SERVER_NAME"] ?></em>.</p>   
								<?php endif; ?> 
								
								<p><?php echo "<b>" . ++$setupsteps . "</b>." ?> Once you have registered, copy and past the created application credentials into this setup page.</p>  
						<?php else: ?>  
								<p>No registration required for OpenID based providers</p> 
						<?php endif; ?> 
							<p>
								<b>And that's it!</b> 
								<br />
								If for some reason you still can't figure it out then try first to 
									a) <a class="button-primary" href="https://www.google.com/search?q=<?php echo $provider_name ?> API create application" target="_blank">Google that</a> 
									or on b) 
									<a class="button-primary" href="http://www.youtube.com/results?search_query=<?php echo $provider_name ?> API create application " target="_blank">Youtube</a>
									and if not c) 
									<a class="button-primary" href="options-general.php?page=wordpress-social-login&wslp=5 ">ask for support</a>.
							</p>
					</div>  

				</div>  
				
			</div>
		</div>  
 
<?php
	endforeach;
?>
</div>

</td>
<td width="400">


<div class="postbox " id="linksubmitdiv"> 
	<div class="inside">
		<div id="submitlink" class="submitbox"> <h3 style="cursor: default;">Why, hello there</h3>
			<div id="minor-publishing"> 

				<div style="display:none;"><input type="submit" value="Save" class="button" id="save" name="save"></div>

				<div id="misc-publishing-actions">
					<div class="misc-pub-section"> 
						<p style="line-height: 19px;font-size: 13px;" align="justify">
							If you are still new to things, we recommend that you read the <b><a href="http://hybridauth.sourceforge.net/userguide/Plugin_WordPress_Social_Login.html" target="_blank">Plugin User Guide</a></b>
							and to make sure your server settings meet this <b><a href="options-general.php?page=wordpress-social-login&amp;wslp=3">Plugin Requirements</a></b>.
						</p>
						<p style="line-height: 19px;" align="justify">
							If you run into any issue then refer to <b><a href="options-general.php?page=wordpress-social-login&wslp=2" target="_blank">Help & Support</a></b> to konw how to reach me.
						</p>
					</div>
				</div> 
			</div>

			<div id="major-publishing-actions"> 
				<div id="publishing-action">
					<input type="submit" value="Save Settings" accesskey="p" id="publish" class="button-large button-primary" name="save">
				</div>
				<div class="clear"></div>
			</div> 
		</div>
	</div>
</div>





</td>
</tr>
</table>

</div>
 
<div style="margin-left:30px;">
	<b>Thanks for scrolling this far down!</b> Now click the save button to complete the setup.
	<br />
	<br />
	<input type="submit" class="button-primary" value="Save Settings" /> 
</div>

</form>
