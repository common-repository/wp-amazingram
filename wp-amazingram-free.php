<?php

/**
 * @link              http://www.bidzillweb.com/wp-amazingram/
 * @since             1.0
 * @package           Amazing_Instagram_Plugin_Free
 *
 * @wordpress-plugin
 * Plugin Name:       Instagram - WP Amazingram, Instagram Images and Videos in Landscape, Portrait and Square mode
 * Plugin URI:        http://www.bidzillweb.com/wp-amazingram/
 * Description:       Free Version of Wp Amazingram Premium, an Amazing Wordpress Plugin for Instagram that supports Images and Videos in  Landscape and Portrait Orientation in Slider, Wall and Justified mode view. Select feed by multiple user, multiple hashtag, likes and location. Filter your feed by user, hashtag or content.
 * Version:           1.2
 * Author:            bidzillweb, beecodex
 * Author URI:        http://www.bidzillweb.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       amazing-instagram-plugin
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-amazing-instagram-plugin-activator.php
 */
function activate_Amazing_Instagram_Plugin_Free_free() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-amazing-instagram-plugin-activator.php';
	Amazing_Instagram_Plugin_Free_Activator_Free::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-amazing-instagram-plugin-deactivator.php
 */
function deactivate_Amazing_Instagram_Plugin_Free_free() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-amazing-instagram-plugin-deactivator.php';
	Amazing_Instagram_Plugin_Free_Deactivator_Free::deactivate();
}

register_activation_hook( __FILE__, 'activate_Amazing_Instagram_Plugin_Free_free' );
register_deactivation_hook( __FILE__, 'deactivate_Amazing_Instagram_Plugin_Free_free' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-amazing-instagram-plugin.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_Amazing_Instagram_Plugin_Free_free() {

	$plugin = new Amazing_Instagram_Plugin_Free();
	$plugin->run();

}
run_Amazing_Instagram_Plugin_Free_free();
