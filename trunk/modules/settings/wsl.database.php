<?php
global $wsl_database_migration_version;

$wsl_database_migration_version = 2;

function wsl_database_migration_hook () {
    wsl_database_migration_process();
}

add_action( 'plugins_loaded', 'wsl_database_migration_process' );

function wsl_database_migration_process(){ 
    global $wpdb;
    global $divebook_db_table_dive_version;
	
    $table_name    = "{$wpdb->prefix}wsluserscontacts";
    $installed_ver = get_option( "wsl_database_migration_version" );

    if( $installed_ver != $divebook_db_table_dive_version || $wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name ) {
		$sql = "CREATE TABLE " . $table_name . " (
					  id int(11) NOT NULL AUTO_INCREMENT,
					  user_id int(11) NOT NULL,
					  provider varchar(50) NOT NULL,
					  identifier varchar(255) NOT NULL,
					  full_name varchar(255) NOT NULL,
					  email varchar(255) NOT NULL,
					  profile_url varchar(255) NOT NULL,
					  photo_url varchar(255) NOT NULL,
					  PRIMARY KEY (id)
				);";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );

		update_option( "wsl_database_migration_version", $wsl_database_migration_version );
	}

    add_option( "wsl_database_migration_version", $wsl_database_migration_version );
}
