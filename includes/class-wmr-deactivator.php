<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://github.com/vishalpsharma1988
 * @since      1.0.0
 *
 * @package    Wmr
 * @subpackage Wmr/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Wmr
 * @subpackage Wmr/includes
 * @author     vishal sharma <vishalpsharma1988@gmail.com>
 */
class Wmr_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {

		global $wpdb;

		$tables = [
			'wmr_client',
			'wmr_client_site_report',
		];


		foreach ( $tables as $table ) {
			$table = $wpdb->prefix . $table;
		//	$wpdb->query( "DROP TABLE IF EXISTS $table" );
		}
	}

}
