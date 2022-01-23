<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://coderninja.ng/rafkev
 * @since             1.0.0
 * @package           Share_Sales_Amount
 *
 * @wordpress-plugin
 * Plugin Name:       Test-Takers
 * Plugin URI:        kevsolutions.com.ng
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Awosan Raphael Kolawole
 * Author URI:        kevsolutions.com.ng
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       share-sales-amount
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
define( 'SHARE_SALES_AMOUNT_VERSION', '1.0.0' );
$upload_url=$path_array['baseurl'];
$upload_dir=$path_array['basedir'];
define('Share_Sales_Amount_DIR', plugin_dir_path( __FILE__ ) );
define('Share_Sales_Amount_URI', plugin_dir_url( __FILE__ ) );
define('Share_Sales_Amount_UPLOAD_URI', $upload_url);
define('Share_Sales_Amount_UPLOAD_DIR', $upload_dir);


/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-share-sales-amount-activator.php
 */
function activate_share_sales_amount() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-share-sales-amount-activator.php';
	Share_Sales_Amount_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-share-sales-amount-deactivator.php
 */
function deactivate_share_sales_amount() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-share-sales-amount-deactivator.php';
	Share_Sales_Amount_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_share_sales_amount' );
register_deactivation_hook( __FILE__, 'deactivate_share_sales_amount' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-share-sales-amount.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_share_sales_amount() {

	$plugin = new Share_Sales_Amount();
	$plugin->run();

}
run_share_sales_amount();
