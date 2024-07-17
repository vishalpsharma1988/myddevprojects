<?php

/**
 * Fired during plugin activation
 *
 * @link       https://github.com/vishalpsharma1988
 * @since      1.0.0
 *
 * @package    Wmr
 * @subpackage Wmr/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Wmr
 * @subpackage Wmr/includes
 * @author     vishal sharma <vishalpsharma1988@gmail.com>
 */
class Wmr_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wmr-client-tables.php';
        $wmr_client_tables = new Wmr_Client_Tables();

	}

}
