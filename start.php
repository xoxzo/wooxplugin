<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @wordpress-plugin
 * Plugin Name:       Xoxzo - SMS & Voice Notification for Woocommerce
 * Plugin URI:        https://github.com/xoxzo/wooxplugin
 * Description:       Send SMS & voice notification of WooCommerce events (based on WooCommerce email events) using the Xoxzo Telephony Service.
 * Version:           1.0.0
 * Author:            Xoxzo Inc.
 * Author URI:        https://www.xoxzo.com/
 * License:           MIT
 * License URI:       https://opensource.org/licenses/MIT
 * Text Domain:       wc-xoxzo
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
define( 'WC_XOXZO', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/wc-xoxzo-activator.php
 */
function activate_wc_xoxzo() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/wc-xoxzo-activator.php';
	Wc_Xoxzo_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/wc-xoxzo-deactivator.php
 */
function deactivate_wc_xoxzo() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/wc-xoxzo-deactivator.php';
	Wc_Xoxzo_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wc_xoxzo' );
register_deactivation_hook( __FILE__, 'deactivate_wc_xoxzo' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/wc-xoxzo.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wc_xoxzo() {

	$plugin = new Wc_Xoxzo();
	$plugin->run();

}
run_wc_xoxzo();
