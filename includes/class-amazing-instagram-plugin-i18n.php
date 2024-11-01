<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://www.poivediamo.com/poivediamo/
 * @since      1.0.0
 *
 * @package    Amazing_Instagram_Plugin_Free
 * @subpackage Amazing_Instagram_Plugin_Free/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Amazing_Instagram_Plugin_Free
 * @subpackage Amazing_Instagram_Plugin_Free/includes
 * @author     Poi Vediamo <poivediamo@poivediamo.com>
 */
class Amazing_Instagram_Plugin_Free_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'amazing-instagram-plugin',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
