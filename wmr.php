<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/vishalpsharma1988
 * @since             1.0.0
 * @package           Wmr
 *
 * @wordpress-plugin
 * Plugin Name:       Website Maintenance Report
 * Plugin URI:        https://cmsminds.com
 * Description:       After update or upgrade, send the report notification to the client and maintain the records form one place.
 * Version:           1.0.0
 * Author:            vishal sharma
 * Author URI:        https://github.com/vishalpsharma1988/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wmr
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'WMR_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wmr-activator.php
 */
function activate_wmr() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wmr-activator.php';
	Wmr_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wmr-deactivator.php
 */
function deactivate_wmr() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wmr-deactivator.php';
	Wmr_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wmr' );
register_deactivation_hook( __FILE__, 'deactivate_wmr' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wmr.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wmr() {

	$plugin = new Wmr();
	$plugin->run();

}
run_wmr();
