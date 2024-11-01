<?php

/**
 * Fired during plugin activation
 *
 * @link       http://www.poivediamo.com/poivediamo/
 * @since      1.0.0
 *
 * @package    Amazing_Instagram_Plugin_Free
 * @subpackage Amazing_Instagram_Plugin_Free/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Amazing_Instagram_Plugin_Free
 * @subpackage Amazing_Instagram_Plugin_Free/includes
 * @author     Poi Vediamo <poivediamo@poivediamo.com>
 */
class Amazing_Instagram_Plugin_Free_Activator_Free {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		update_option('aip_clientid','5af5eb46954546cbb5bb6de6daa91850');
		update_option('aip_callback','http://www.bidzillweb.com/aip_access_token.php');
}

}
