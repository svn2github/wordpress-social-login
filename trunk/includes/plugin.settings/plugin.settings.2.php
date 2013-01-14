<form method="post" id="wsl_setup_form" action="options.php"> 


<div class="metabox-holder columns-2" id="post-body">

<table width="100%">
<tbody>
<tr valign="top">
<td>
							
<div  id="post-body-content"> 
 
	<div id="namediv" class="stuffbox">
		<h3>
			<label for="name">Basic Settings</label>
		</h3>
		<div class="inside">
			<?php settings_fields( 'wsl-settings-group-customize' ); ?> 
			
			<table width="100%" border="0" cellpadding="5" cellspacing="2" > 
			  <tr>
				<td width="135" align="right"><strong>Connect with caption :</strong></td>
				<td>

			<?php 
				$wsl_settings_connect_with_label = get_option( 'wsl_settings_connect_with_label' );

				if( empty( $wsl_settings_connect_with_label ) ){
					$wsl_settings_connect_with_label = "Connect with:";
				}
			?>
				<input type="text" class="inputgnrc" value="<?php echo $wsl_settings_connect_with_label; ?>" name="wsl_settings_connect_with_label" >
				
				</td>
			  </tr>

			  <tr>
				<td align="right"><strong>Social icon set :</strong></td>
				<td> 
					<select name="wsl_settings_social_icon_set" style="width:400px">
						<option <?php if( get_option( 'wsl_settings_social_icon_set' )   == "wpzoom" ) echo "selected"; ?>   value="wpzoom">WPZOOM social networking icon set</option>
						<option <?php if( get_option( 'wsl_settings_social_icon_set' ) == "icondock" ) echo "selected"; ?> value="icondock">Icondock vector social media icons</option> 
					</select> 
				</td>
			  </tr>
			  
			  <tr>
				<td align="right"><strong>Users avatars :</strong></td>
				<td>
					<select name="wsl_settings_users_avatars" style="width:400px">
						<option <?php if( ! get_option( 'wsl_settings_users_avatars' ) ) echo "selected"; ?> value="0">Display the default users avatars</option> 
						<option <?php if(   get_option( 'wsl_settings_users_avatars' ) ) echo "selected"; ?> value="1">Display users avatars from social networks when available</option>
					</select> 
				</td>
			  </tr> 
			</table> 
			<br>  
		</div>
	</div>
	
	<div id="namediv" class="stuffbox">
		<h3>
			<label for="name">Advanced Settings</label>
		</h3>
		<div class="inside">
			<?php settings_fields( 'wsl-settings-group-customize' ); ?> 
			
			<table width="100%" border="0" cellpadding="5" cellspacing="2" >
			  <tr> 
				<?php 
					$wsl_settings_redirect_url = get_option( 'wsl_settings_redirect_url' );

					if( empty( $wsl_settings_redirect_url ) ){
						$wsl_settings_redirect_url = site_url();
					}
				?>
				<td width="135" align="right" valign="top"><strong>Redirect URL :</strong></td>
				<td>
					<input type="text" name="wsl_settings_redirect_url" value="<?php echo $wsl_settings_redirect_url; ?>" class="inputgnrc">
					<br /> 
					&nbsp;Where should users be redirected to after registring? (<b>By default, to where he comes from</b>) 
				</td>
			  </tr>

			  <tr>
				<td align="right" valign="top"><strong>Authentication flow:</strong></td>
				<td>
					<select name="wsl_settings_use_popup" style="width:400px">
						<option <?php if( get_option( 'wsl_settings_use_popup' ) == 1 || ! get_option( 'wsl_settings_use_popup' ) ) echo "selected"; ?> value="1">Using popup window</option> 
						<option <?php if( get_option( 'wsl_settings_use_popup' ) == 2 ) echo "selected"; ?> value="2">No popup window</option> 
					</select>  
					<br /> 
					&nbsp;If you encounter any issues with the widget or popup (not showing up) then try to change it to (<b>No popup window</b>) 
				</td>
			  </tr> 
			 
			  <tr>
				<td align="right"><strong>Widget display</strong></td>
				<td>
					<select name="wsl_settings_widget_display" style="width:400px">
						<option <?php if( get_option( 'wsl_settings_widget_display' ) == 1 || ! get_option( 'wsl_settings_widget_display' ) ) echo "selected"; ?> value="1">Display the widget in the comments area, login and register forms</option> 
						<option <?php if( get_option( 'wsl_settings_widget_display' ) == 2 ) echo "selected"; ?> value="2">Display the widget ONLY in the comments area</option> 
					</select>  
				</td>
			  </tr> 

			  <tr>
				<td align="right" valign="top"><strong>Notification :</strong></td>
				<td>
					<select name="wsl_settings_users_notification" style="width:400px">
						<option <?php if( ! get_option( 'wsl_settings_users_notification' )      ) echo "selected"; ?> value="0">No notification</option> 
						<option <?php if(   get_option( 'wsl_settings_users_notification' ) == 1 ) echo "selected"; ?> value="1">Notify ONLY the blog admin of a new user</option> 
					</select> 
					<br />
					&nbsp;Should we send a notification when a new user register with <b>WSL</b>? 
					<br />
					&nbsp;If enabled, the blog admin will recive notifications via email at &lt;<?php echo get_option('admin_email') ?>&gt;.
				</td>
			  </tr> 
			</table>

			<br>  
		</div>
	</div>

</div>

</td>
<td width="600">


<div class="postbox " id="linksubmitdiv"> 
	<div class="inside">
		<div id="submitlink" class="submitbox"> 
			<h3 style="cursor: default;">Custom integration</h3>
			<div id="minor-publishing">  
				<div id="misc-publishing-actions"> 
						<p style="margin:10px;"> 
						WordPress Social Login will attempts to work with the default WordPress comment, login and registration forms. 
						</p>

						<ul style="list-style:disc inside;margin-left:25px;"> 
							
							<li>If you want to add the social login widget to another location in your theme, you can insert the following code in that location:
							<pre style="width: 440px;background-color: #FFFFE0;border:1px solid #E6DB55; border-radius: 3px;padding: 10px;margin-top:15px;margin-left:10px;"> &lt;?php do_action( 'wordpress_social_login' ); ?&gt; </pre>  
							</li> 

							<li>Also, if you are a developer or designer then you can customize it to your heart's content: 
								<ul style="list-style:circle inside;margin-left:25px;margin-top:10px;">
									<li>The default css styles are found at <strong>/wordpress-social-login/assets/css/style.css</strong></li> 
									<li>Social icons are found at <strong>/wordpress-social-login/assets/img/32x32/</strong></li> 
									<li>The widget view can be found at <strong>/wordpress-social-login/includes/plugin.ui.php</strong>, function <strong>wsl_render_login_form()</strong></li> 
									<li>The popup and loading screens are found at <strong>/wordpress-social-login/authenticate.php</strong></li> 
								</ul>
							</li> 
						</ul> 
				</div> 
			</div> 
		</div>
	</div>
</div> 

</td>
</tr>
</table>

</div> 

<div style="margin-left:5px;margin-top:-20px;"> 
	<input type="submit" class="button-primary" value="Save Settings" /> 
</div>


</form>
