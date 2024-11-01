<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://simplesolutionsfs.com/
 * @since             1.0.0
 * @package           Wpshopify_checkout
 *
 * @wordpress-plugin
 * Plugin Name:       WP Shopify Checkout
 * Plugin URI:        https://simplesolutionsfs.com/wpshopify
 * Description:       This plugin emulates the Shopify Checkout page in WooCommerce.
 * Version:           1.0.0
 * Author:            SimpleSolutionsFS
 * Author URI:        https://simplesolutionsfs.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wpshopify_checkout
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
define( 'WPSHOPIFY_CHECKOUT_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wpshopify_checkout-activator.php
 */
function activate_wpshopify_checkout() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wpshopify_checkout-activator.php';
	Wpshopify_checkout_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wpshopify_checkout-deactivator.php
 */
function deactivate_wpshopify_checkout() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wpshopify_checkout-deactivator.php';
	Wpshopify_checkout_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wpshopify_checkout' );
register_deactivation_hook( __FILE__, 'deactivate_wpshopify_checkout' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wpshopify_checkout.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wpshopify_checkout() {

	$plugin = new Wpshopify_checkout();
	$plugin->run();

}

/**
 * Add plugin action links.
 *
 * Add a link to the settings page on the plugins.php page.
 *
 * @since 1.0.0
 *
 * @param  array  $links List of existing plugin action links.
 * @return array         List of modified plugin action links.
 */
function wpshopify_checkout_action_links( $links ) {
	$links = array_merge( array(
		'<a href="' . esc_url( admin_url( '/plugins.php?page=wpshopify_checkout_settings' ) ) . '">' . __( 'Settings', 'wpshopify_checkout' ) . '</a>'
	), $links );
	return $links;
}
add_action( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'wpshopify_checkout_action_links' );

// Add Phone (required) with corresponding priority to the Shipping form
add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );

function custom_override_checkout_fields( $fields ) {

	 // Add Phone (required) to the Shipping form
     $fields['shipping']['shipping_phone'] = array(
        'label'     => __('Phone', 'woocommerce'),
		// 'placeholder'   => _x('Phone', 'placeholder', 'woocommerce'),
		'required'  => true,
		'class'     => array('form-row-wide'),
		'priority'  => 25,
		'clear'     => true
     );

	 // Change field width inthe shipping form
     $fields['shipping']['shipping_company']['class'] = array('im_company_shipping');
	 $fields['shipping']['shipping_country']['class'] = array('im_country_shipping');
	 $fields['shipping']['shipping_state']['class'] = array('im_state_shipping');
	 $fields['shipping']['shipping_address_1']['class'] = array('im_address_shipping');

	 // Change order of field billing_email in the billing form
	 $fields['billing']['billing_email']['priority'] = 1;

     return $fields;
}

///////

// Modify Order Review output in checkout page
// add_action( 'woocommerce_checkout_order_review', 'im_cart_modification');

add_action( 'woocommerce_checkout_before_order_review_custom', 'im_cart_modification' );

function im_cart_modification() {

	global $woocommerce;
	$items = $woocommerce->cart->get_cart();

	foreach($items as $item => $values) {
		$_product =  wc_get_product( $values['data']->get_id() );
		$prodimg = '<img src="' . wp_get_attachment_url( $_product->get_image_id() ) . '" class="prdimg" />';

		?>
		<div class="col-md-12 table table-top-margin">
			<div class="col-xs-3"><?php echo $prodimg; ?></div>
			<div class="col-xs-9">
				<?php
			  echo  $_product->get_title() .'</b>
			  <br> Quantity: '. $values['quantity'].'<br>';
			  $price = get_post_meta($values['product_id'] , '_price', true);
			  echo woocommerce_price($price);
			  ?>
			</div>
		</div>


	   <?php

	}

}


/**
 * Detect if WooCommerce plugin is installed and activated.
 */

if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

	run_wpshopify_checkout();

} else {

	echo 'You need to install and activate the WooCommerce Plugin in order to use the WPShopify Plugin' . '<br><br>';

}
