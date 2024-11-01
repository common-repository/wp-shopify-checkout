<?php
/**
 * Template Name: WPShopify Checkout
 * Description: A Page Template for the WP Shopify Checout plugin.
 *
 * @link       https://simplesolutionsfs.com/
 * @since      1.0.0
 *
 * @package    Wpshopify_checkout
 * @subpackage Wpshopify_checkout/public/partials
 */
?>

 <?php wp_head(); ?>

<?php

 $request_uri = $_SERVER[REQUEST_URI];
 if (strpos($request_uri, 'checkout/order-received') !== false) {
    $new_uri = str_replace("checkout","shopi-checkout-success",$request_uri);
	header("Location: " . $new_uri);
 }

?>

<?php
$options = get_option( 'wpshopify_checkout_input_examples' );
// echo 'Header: ' . $options['textarea_header'] . '<br>' . 'Footer: ' . $options['textarea_footer'] . '<br>';

?>

<!-- Hide content until fully loaded -->
<div id="cover"></div>

<?php

    // Set billing email
	$bemail = '';
	if ( is_user_logged_in() ) {
	$current_user = wp_get_current_user();
	$bemail = $current_user->user_email;
	}

	// Set logo
	$custom_logo_id = get_theme_mod( 'custom_logo' );
	$image = wp_get_attachment_image_src( $custom_logo_id , 'full' );

?>

	<!-- END - Hide content until fully loaded -->
 <?php  $checkout = WC()->checkout(); ?>


<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

        <div class="container">
        <?php


        // echo do_shortcode('[woocommerce_checkout]');

        // Start the loop.
        // while ( have_posts() ) : the_post();

        //     // Include the page content template.
        //     get_template_part( 'template-parts/content', 'page' );

        //     // If comments are open or we have at least one comment, load up the comment template.
        //     if ( comments_open() || get_comments_number() ) {
        //         comments_template();
        //     }

        //     // End of the loop.
        // endwhile;


        ?>

            <form class="checkout_coupon" method="post" style="display:block !important">

                <p class="form-row form-row-first">
                    <input type="text" name="coupon_code" class="input-text" placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>" id="coupon_code" value="" />
                </p>

                <p class="form-row form-row-last">
                    <input type="submit" class="shopifu-btn-sm" name="apply_coupon" value="<?php esc_attr_e( 'Apply', 'woocommerce' ); ?>" />
                </p>

                <div class="clear"></div>
            </form>
<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

            <div class="col-md-12">
                <?php the_custom_logo(); ?><br>
            </div>

            <div id="order_review" class="woocommerce-checkout-review-order col-md-5 col-md-push-7">

            <div class="collapse-cart">
                <a onclick="toggleShoppingDetail()" class="pull-left view-cart"><i class="fa fa-shopping-cart"></i>Show Order Summary:  </a>
                <span class="pull-right mobile-total-grand"><?php wc_cart_totals_order_total_html(); ?></span>
            </div>
            <div id="coupon-destination" class="not-visible-mobile"> </div>
            <div class="section-background"></div>
                 <div class="section-content not-visible-mobile">
                 <!-- <h3 id="order_review_heading"><?php // _e( 'Your order', 'woocommerce' ); ?></h3> -->

                    <?php do_action( 'woocommerce_checkout_before_order_review_custom' ); ?>

                    <?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

                    <?php do_action( 'woocommerce_checkout_order_review' ); ?>

                 </div>
            </div>

    <?php if ( $checkout->get_checkout_fields() ) : ?>

        <?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

        <div class="col-md-7 col-md-pull-5" id="customer_details">


            <ul class="shopify-list ">
                <li>
                    <span >Contact </span>
                    <span id="contact-data"></span>
                     <a class="pull-right" onclick="goToPage('shipping-section')">change </a>
                </li>
                <li>
                    <span>Ship to </span>
                    <span id="shipping-data"> </span>
                     <a class="pull-right" onclick="goToPage('shipping-section')">change </a>
                </li>
            </ul>

            <div class="woocommerce-notices-wrapper">
                <?php
                wc_print_notices();
                wc_clear_notices();
                ?>
            </div>
            <div class="col-1 shipping-section ">

              <div class="woocommerce-shipping-fields active-section">
    <?php // if ( true === WC()->cart->needs_shipping_address() ) : ?>

<?php // if ( ! is_user_logged_in() ) { ?>

        <h3>Contact Information</h3>
                <p class="form-row form-row-wide validate-required validate-required validate-email" id="billing_email_custom_field" data-priority="10"><label for="billing_email_custom" class="">Email address <abbr class="required" title="required">*</abbr></label><input class="input-text " name="billing_email_custom" id="billing_email_custom" placeholder="" type="text" value="<?php echo $bemail; ?>"> <!-- autocomplete="email username" > -->
                </p>

    <?php // } ?>

    <?php if ( true === WC()->cart->needs_shipping_address() ) : ?>

        <h3>Shipping Address</h3>

        <div> <!--  class="shipping_address"> -->

            <?php do_action( 'woocommerce_before_checkout_shipping_form', $checkout ); ?>

            <div class="woocommerce-shipping-fields__field-wrapper">
                <?php
                    $fields = $checkout->get_checkout_fields( 'shipping' );

                    foreach ( $fields as $key => $field ) {
                        if ( isset( $field['country_field'], $fields[ $field['country_field'] ] ) ) {
                            $field['country'] = $checkout->get_value( $field['country_field'] );
                        }
                        woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
                    }
                ?>
            </div>

            <?php do_action( 'woocommerce_after_checkout_shipping_form', $checkout ); ?>

        </div>

    <?php endif; ?>
</div>

<h3 id="payment-label"><?php _e( 'Payment Method', 'woocommerce' ); ?></h3>
<div class="woocommerce-additional-fields">
    <?php do_action( 'woocommerce_before_order_notes', $checkout ); ?>

    <?php if ( apply_filters( 'woocommerce_enable_order_notes_field', 'yes' === get_option( 'woocommerce_enable_order_comments', 'yes' ) ) ) : ?>

        <?php if ( ! WC()->cart->needs_shipping() || wc_ship_to_billing_address_only() ) : ?>

            <h3><?php _e( 'Additional information', 'woocommerce' ); ?></h3>

        <?php endif; ?>

        <div class="woocommerce-additional-fields__field-wrapper">
            <?php foreach ( $checkout->get_checkout_fields( 'order' ) as $key => $field ) : ?>
                <?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>
            <?php endforeach; ?>
        </div>

    <?php endif; ?>

    <?php do_action( 'woocommerce_after_order_notes', $checkout ); ?>

</div>

            </div>

            <div class="col-2 billing-section">
                <?php //do_action( 'woocommerce_checkout_shipping' ); ?>
                <div class="shopify-list-div">
<h3><?php _e( 'Billing Address', 'woocommerce' ); ?></h3>
    <ul class="shopify-list">

    <li>

        <!-- <input type="radio" id="billing_type_1" name="billing_type" value="1" onclick="billingType('1');" checked="checked">    -->

        <input type="radio" id="billing_type_1" name="billing_type" value="1" onclick="addsenderemail('<?php echo $bemail; ?>');">

        <label for="billing_type_1">Same as shipping address </label>
    </li>
    <li>
         <input type="radio" id="billing_type_2" name="billing_type" value="2" onclick="billingType('2');" checked="checked">
        <label for="billing_type_2"> Use a different billing address </label>

                  <h3 id="ship-to-different-address">
            <label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
                <input id="ship-to-different-address-checkbox" class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" <?php checked( apply_filters( 'woocommerce_ship_to_different_address_checked', 'shipping' === get_option( 'woocommerce_ship_to_destination' ) ? 1 : 0 ), 1 ); ?> type="checkbox" name="ship_to_different_address" value="1" /> <span><?php _e( 'Ship to a different address?', 'woocommerce' ); ?></span>
            </label>
        </h3>


    </li>
    </ul>
</div>
<div class="woocommerce-billing-fields">
    <?php if ( wc_ship_to_billing_address_only() && WC()->cart->needs_shipping() ) : ?>

        <!-- <h3><?php // _e( 'Billing &amp; Shipping', 'woocommerce' ); ?></h3> -->

    <?php else : ?>

        <!-- <h3><?php // _e( 'Billing details', 'woocommerce' ); ?></h3> -->

    <?php endif; ?>

    <?php do_action( 'woocommerce_before_checkout_billing_form', $checkout ); ?>

    <div class="woocommerce-billing-fields__field-wrapper">
        <?php
            $fields = $checkout->get_checkout_fields( 'billing' );
            foreach ( $fields as $key => $field ) {
                if ( isset( $field['country_field'], $fields[ $field['country_field'] ] ) ) {
                    $field['country'] = $checkout->get_value( $field['country_field'] );
                }
        woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
            }
            // $fields=array(
            //     "billing_email",
            //     "billing_first_name",
            //     "billing_last_name",
            //     "billing_address_1",
            //     "billing_city",
            //     "billing_state",
            //     "billing_postcode",
            //     "billing_country",
            //     "billing_phone",
            // );

            // foreach ($fields as $key) :
            //  woocommerce_form_field( $key, $checkout->checkout_fields['billing'][$key], $checkout->get_value( $key ) );
            // endforeach;



        ?>
    </div>

    <?php do_action( 'woocommerce_after_checkout_billing_form', $checkout ); ?>
</div>


<?php if ( ! is_user_logged_in() && $checkout->is_registration_enabled() ) : ?>
    <div class="woocommerce-account-fields">
        <?php if ( ! $checkout->is_registration_required() ) : ?>

            <!-- <p class="form-row form-row-wide create-account"> -->
            <p class="form-row form-row-wide create-account woocommerce-validated">
                <label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
                    <input class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" id="createaccount" <?php checked( ( true === $checkout->get_value( 'createaccount' ) || ( true === apply_filters( 'woocommerce_create_account_default_checked', false ) ) ), true ) ?> type="checkbox" name="createaccount" value="1" /> <span><?php _e( 'Create an account?', 'woocommerce' ); ?></span>
                </label>
            </p>

        <?php endif; ?>

        <?php do_action( 'woocommerce_before_checkout_registration_form', $checkout ); ?>

        <?php // if ( $checkout->get_checkout_fields( 'account' ) ) : ?>

            <!-- <div class="create-account"> -->
            <div class="create-account" style="display: none;">
                <?php // foreach ( $checkout->get_checkout_fields( 'account' ) as $key => $field ) : ?>
                    <?php // woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>
                <?php // endforeach; ?>

                <p class="form-row validate-required woocommerce-invalid woocommerce-invalid-required-field" id="account_password_field" data-priority=""><label for="account_password" class="">Create account password&nbsp;<abbr class="required" title="required">*</abbr></label><span class="woocommerce-input-wrapper"><input type="password" class="input-text " name="account_password" id="account_password" placeholder="Password" value=""></span></p>

                <div class="clear"></div>
            </div>

        <?php // endif; ?>

        <?php do_action( 'woocommerce_after_checkout_registration_form', $checkout ); ?>

    </div>
<?php endif; ?>

            </div>

    <div id="payment-section"></div>
            <div class="continue-btn active-section " style="margin-top: 25px;">
                    <!-- <a class="button  custom-btn-sp continue-btn-position" onclick="goToPage('payment');"> Continue</a> -->
                    <a class="button  custom-btn-sp continue-btn-position" onclick="addems('<?php echo $bemail; ?>');"> Continue</a>
            </div>
        </div>

        <?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

    <?php endif; ?>


   <div id="order_payment">

   </div>

    <?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
    <div class="col-md-2 col-md-offset-5">
   <input class=" shopifu-btn" name="woocommerce_checkout_place_order" id="place_order" value="Place order" data-value="Place order" type="submit">
 </div>
</form>
<?php do_action('woocommerce_after_checkout_form'); ?>
<?php do_action('woocommerce_checkout_update_order_meta'); ?>

    </div>
    </main><!-- .site-main -->

    <?php //get_sidebar( 'content-bottom' ); ?>

</div><!-- .content-area -->

 <!-- <div class="creds col-md-12 text-center"><p>Copyright © <?php //echo date('Y'); ?> | <a href="">Noomie, Florida</a></p></div> -->
<?php //get_sidebar(); ?>
<?php // get_footer(); ?>
<?php wp_footer(); ?>


<?php

/////////
/**
Add Javascript in Header
*/
add_action( 'wp_head', 'wps_header_scripts' );
function wps_header_scripts(){
     echo $options['textarea_header'];
}

/**
Add Javascript in Footer
*/
add_action( 'wp_footer', 'wps_footer_scripts' );
function wps_footer_scripts(){
     echo $options['textarea_footer'];
}
////////
?>

<!-- <script async="" type="text/javascript" src="https://static.klaviyo.com/onsite/js/klaviyo.js?company_id=KQA2Ut"></script> -->
