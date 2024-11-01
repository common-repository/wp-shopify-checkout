<?php

/**
 * Fired during plugin activation
 *
 * @link       https://simplesolutionsfs.com/
 * @since      1.0.0
 *
 * @package    Wpshopify_checkout
 * @subpackage Wpshopify_checkout/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Wpshopify_checkout
 * @subpackage Wpshopify_checkout/includes
 * @author     SimpleSolutionsFS <im@simplesolutionsfs.com>
 */
class Wpshopify_checkout_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

			if (!post_exists('shopi-checkout-success')) {
	 		   $post_details = array(
	 		  'post_title'    => 'Shopi Checkout Success',
	 		  'post_content'  => '[woocommerce_checkout]',
	 		  'post_status'   => 'publish',
	 		  'post_author'   => 1,
	 		  'post_type' => 'page'
	 		   );
	 		   wp_insert_post( $post_details );
	 	  }

		} else {

			echo 'You need to install and activate the WooCommerce Plugin in order to use the WPShopify Plugin' . '<br><br>';

		}


	}

}
