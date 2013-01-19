<?php
	global $wpdb;
?>
<?php 
	$sql = "SELECT meta_value, user_id FROM `{$wpdb->prefix}usermeta` where meta_key = 'wsl_user'";

	$rs1 = $wpdb->get_results( $sql );  

	$assets_base_url = WORDPRESS_SOCIAL_LOGIN_PLUGIN_URL . '/assets/img/16x16/';
?> 
<div style="margin:20px;margin-top:20px;">
<!--
<p class="search-box">
	<label for="user-search-input" class="screen-reader-text">Search Users:</label>
	<input type="search" value="" name="s" id="user-search-input">
	<input type="submit" value="Search Users" class="button" id="search-submit" name="">
</p>
<br />
<br /> 
-->
<table cellspacing="0" class="wp-list-table widefat fixed users">
	<thead>
		<tr> 
			<th><span>Username</span></th> 
			<th><span>Full Name</span></th> 
			<th><span>Provider</span></th>  
			<th><span>Email</span></th> 
			<th><span>Profile Url</span></th> 
		</tr>
	</thead> 
	<tfoot>
		<tr> 
			<th><span>Username</span></th> 
			<th><span>Full Name</span></th> 
			<th><span>Provider</span></th>  
			<th><span>Email</span></th> 
			<th><span>Profile Url</span></th> 
		</tr>
	</tfoot> 
	<tbody data-wp-lists="list:user" id="the-list">
<?php 
	$i = 0;
	foreach( $rs1 as $items ){
		$provider = $items->meta_value; 
		$user_id = $items->user_id; 
?>
		<tr class="<?php if( ++$i % 2 ) echo "alternate" ?>"> 
			<td>
				<?php $wsl_user_image = wsl_get_user_by_meta_key_and_user_id( "wsl_user_image", $user_id); if( $wsl_user_image ) { ?>
					<img width="32" height="32" class="avatar avatar-32 photo" src="<?php echo $wsl_user_image ?>" > 
				<?php } else { ?>
					<img width="32" height="32" class="avatar avatar-32 photo" src="http://1.gravatar.com/avatar/d4ed6debc848ece02976aba03e450d60?s=32" > 
				<?php } ?>
				<strong><a href="user-edit.php?user_id=<?php echo $user_id ?>"><?php echo wsl_get_user_by_meta_key_and_user_id( "nickname", $user_id) ?></a></strong>
				<br>
			</td>
			<td><?php echo wsl_get_user_by_meta_key_and_user_id( "last_name", $user_id) ?> <?php echo wsl_get_user_by_meta_key_and_user_id( "first_name", $user_id) ?></td>
			<td><img src="<?php echo $assets_base_url . strtolower( $provider ) . '.png' ?>" style="vertical-align:top;width:16px;height:16px;" /> <?php echo $provider ?></td> 
			<td>
				<?php $user_email = wsl_get_user_data_by_user_id( "user_email", $user_id); if( $user_email ) { ?>
					<?php if( ! strstr( $user_email, "@example.com" ) ) { ?>
						<a href="mailto:<?php echo $user_email ?>"><?php echo $user_email ?></a>
					<?php } ?>
				<?php } ?>
			</td>
			<td>
				<?php $user_url = wsl_get_user_data_by_user_id( "user_url", $user_id); if( $user_url ) { ?>
					<a href="<?php echo $user_url ?>" target="_blank"><?php echo $user_url ?></a>
				<?php } ?>
			</td> 
		</tr> 
<?php 
	}
?> 
	</tbody>
</table>
</div>

<?php
	function wsl_get_user_by_meta_key_and_user_id( $meta_key, $user_id ){
		global $wpdb;
		
		$sql = "SELECT meta_value FROM `{$wpdb->prefix}usermeta` where meta_key = '$meta_key' and user_id = '$user_id'";
		$rs  = $wpdb->get_results( $sql );

		return $rs[0]->meta_value;
	}

	function wsl_get_user_data_by_user_id( $field, $user_id ){
		global $wpdb;
		
		$sql = "SELECT $field as data_field FROM `{$wpdb->prefix}users` where ID = '$user_id'";
		$rs  = $wpdb->get_results( $sql );

		return $rs[0]->data_field;
	}
?>