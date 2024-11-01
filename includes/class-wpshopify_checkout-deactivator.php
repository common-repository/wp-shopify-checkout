<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://simplesolutionsfs.com/
 * @since      1.0.0
 *
 * @package    Wpshopify_checkout
 * @subpackage Wpshopify_checkout/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Wpshopify_checkout
 * @subpackage Wpshopify_checkout/includes
 * @author     SimpleSolutionsFS <im@simplesolutionsfs.com>
 */
class Wpshopify_checkout_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {

		$page = get_page_by_title( 'chscs' );
		if (post_exists('shopi-checkout-success')) {
		    wp_delete_post(($page->ID), true);
		}

	}

}
