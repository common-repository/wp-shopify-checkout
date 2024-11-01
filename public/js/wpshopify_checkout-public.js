// (function( $ ) {
	// 'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

    // var jQuery = $.noConflict();

// })( jQuery );
// alert("pepito");
jQuery(window).on('load', function() {
   jQuery("#cover").hide();
});

jQuery('body').trigger('update_checkout');

jQuery( document.body ).on( 'checkout_error', function() {
    // jQuery( 'html, body' ).stop();
    window.scrollTo(0, 0);
    console.log('error');
} );

jQuery( window ).load(function() {

    jQuery(".checkout_coupon").appendTo("#coupon-destination");
    jQuery("#shipping_address_1_field").prepend("<label>Address</label>");
     jQuery("#payment").appendTo(".woocommerce-additional-fields");
     jQuery(".checkout_coupon").addClass('active-section');
     jQuery(".woocommerce-additional-fields__field-wrapper").addClass('active-section'); 
     var couponOffset = jQuery('.coupon-position').offset();
     
     var tableOffset = jQuery('.woocommerce-checkout-review-order-table tbody').height();
     var tableOffset2 = jQuery('.collapse-cart').height();

     var   couponOffsetTop = parseInt(tableOffset) + parseInt(tableOffset2*2)+ parseInt(94);
     
     jQuery("#coupon-destination").css({top:couponOffsetTop+'px'});
     jQuery(".checkout_coupon").addClass('active-section');
     
 });

jQuery( ".woocommerce-checkout input" ).focus(function() {
    
   

    jQuery('.form-row').removeClass('focus-input');
    var currentId = jQuery(this).attr('id');

    // console.log(jQuery(this).val());
    // console.log(currentId);
    jQuery("#"+currentId+'_field').addClass('focus-input');
  //jQuery( this ).next( "span" ).css( "display", "inline" ).fadeOut( 1000 );
});

function billingType(type){
    

    if(type === "1"){
        copyShipping();
        if (!jQuery('#ship-to-different-address-checkbox').is(':checked')) {
            //jQuery('#ship-to-different-address label').trigger('click');
        }
        jQuery(".billing-section .woocommerce-billing-fields").removeClass('active-section');
    }else{
        cleanBilling();
        if (jQuery('#ship-to-different-address-checkbox').is(':checked')) {
            //jQuery('#ship-to-different-address label').trigger('click');
        }
        jQuery(".billing-section .woocommerce-billing-fields").addClass('active-section');
    }
    

}

function copyShipping(){
   jQuery("#billing_email").val(jQuery( "#billing_email_custom" ).val());
  jQuery("#billing_first_name").val(jQuery( "#shipping_first_name" ).val());
  jQuery("#billing_last_name").val(jQuery( "#shipping_last_name" ).val());

  jQuery("#billing_address_1").val(jQuery( "#shipping_address_1" ).val());
  jQuery("#billing_address_2").val(jQuery( "#shipping_address_2" ).val());
  jQuery("#billing_city").val(jQuery( "#shipping_city" ).val());
  jQuery("#billing_postcode").val(jQuery( "#shipping_postcode" ).val());
  jQuery("#billing_phone").val(jQuery( "#shipping_phone" ).val());   
}

function cleanBilling(){
      // jQuery("#billing_email").val(jQuery( "#billing_email_custom" ).val());
  jQuery("#billing_first_name").val('');
  jQuery("#billing_last_name").val('');

  jQuery("#billing_address_1").val('');
  jQuery("#billing_address_extra").val('');
  jQuery("#billing_city").val('');
  jQuery("#billing_postcode").val('');
  jQuery("#billing_phone").val('');
}
function goToPage(page){

    var isShippingvalid = validateShipping();

    if (isShippingvalid){

        jQuery(".shipping-section .woocommerce-shipping-fields").removeClass('active-section');
        jQuery("#payment").removeClass('active-section'); 
        jQuery("#payment-label").removeClass('active-section'); 
        jQuery(".continue-btn").removeClass('active-section'); 
        jQuery(".woocommerce-additional-fields").removeClass('active-section');
        jQuery("#contact-data").html(jQuery( "#billing_email_custom" ).val());
        var fullAdr = jQuery( "#shipping_address_1" ).val();
        var city = jQuery( "#shipping_city" ).val();
        var zip = jQuery( "#shipping_postcode" ).val();
        jQuery("#shipping-data").html(fullAdr + ', '+ city + ' '+ zip);


        if(page === 'payment'){
             setTimeout(function() {
                  jQuery("#payment").addClass('active-section'); 
            }, 1000);
                 jQuery(".woocommerce-additional-fields").addClass('active-section');
                jQuery("#payment-label").addClass('active-section'); 
                jQuery(".shopify-list").addClass('active-section'); 
                jQuery(".shopifu-btn").addClass('active-section'); 
                jQuery(".shopify-list-div").addClass('active-section'); 
                jQuery(".woocommerce-additional-fields__field-wrapper").removeClass('active-section'); 
                //billing-section
                var selValue = jQuery('input[name=billing_type]:checked').val(); 
                if (selValue === "2"){
                   jQuery(".billing-section .woocommerce-billing-fields").addClass('active-section');  
                }
            
        }
        
        if(page === 'shipping-section'){
            jQuery(".shipping-section .woocommerce-shipping-fields").addClass('active-section');
            jQuery(".continue-btn").addClass('active-section'); 
            jQuery(".billing-section .woocommerce-billing-fields").removeClass('active-section');
            jQuery(".shopifu-btn").removeClass('active-section');
            jQuery(".shopify-list-div").removeClass('active-section');
            jQuery(".woocommerce-additional-fields__field-wrapper").addClass('active-section'); 
            


        }
    }
    window.scrollTo(0, 0);
      
}

function validateShipping(){

    jQuery(".error-msg").each(function(){
        var context = jQuery(this);
        context.empty();
    });

    var flag = true;
    var email = jQuery( "#billing_email_custom" ).val();
    if(!isValidEmailAddress(email)){
        jQuery( "#billing_email_custom_field" ).addClass('focus-error');
        jQuery( "#billing_email_custom_field" ).append('<span class="error-msg error-email">Please enter a valid email address</div>');
        flag = false;
    }
    if(jQuery( "#shipping_first_name" ).val() === ""){
        jQuery( "#shipping_first_name_field" ).addClass('focus-error');
        jQuery( "#shipping_first_name_field" ).append('<span class="error-msg error-name">Please enter your name</div>');
        flag = false;
    }

    if(jQuery( "#shipping_last_name" ).val() === ""){
        jQuery( "#shipping_last_name_field" ).addClass('focus-error');
        jQuery( "#shipping_last_name_field" ).append('<span class="error-msg error-lastname">Please enter your last name</div>');
        flag = false;
    }

    if(jQuery( "#shipping_city" ).val() === ""){
        jQuery( "#shipping_city_field" ).addClass('focus-error');
        jQuery( "#shipping_city_field" ).append('<span class="error-msg error-city">Please enter a city</div>');
        flag = false;
    }

    if(jQuery( "#shipping_postcode" ).val() === ""){
        jQuery( "#shipping_postcode_field" ).addClass('focus-error');
        jQuery( "#shipping_postcode_field" ).append('<span class="error-msg error-zip">Please enter a zipcode</div>');
        flag = false;
    }
    if(jQuery( "#shipping_address_1" ).val() === ""){
        jQuery( "#shipping_address_1_field" ).addClass('focus-error');
        jQuery( "#shipping_address_1_field" ).append('<span class="error-msg error-address">Please enter a Address</div>');
        flag = false;
    }
    if(jQuery( "#shipping_phone" ).val() === ""){
        jQuery( "#shipping_phone_field" ).addClass('focus-error');
        jQuery( "#shipping_phone_field" ).append('<span class="error-msg error-phone">Please enter a Phone Number</div>');
        flag = false;
    }

    if (flag){
        flag = isValidEmailAddress(email);
    }
    return flag;
}


function toggleShoppingDetail(){



    jQuery( ".section-content" ).toggleClass('not-visible-mobile');
    jQuery( "#coupon-destination" ).toggleClass('not-visible-mobile');
    if(jQuery( "#order_review2" ).hasClass('item-show')){
        jQuery( ".woocommerce-checkout-review-order-table" ).removeClass('item-show');
        jQuery( "#coupon-destination" ).removeClass('item-show');
    }else{
        jQuery( ".woocommerce-checkout-review-order-table" ).addClass('item-show');
        jQuery( "#coupon-destination" ).addClass('item-show');
    }

    var tableOffset = jQuery('.woocommerce-checkout-review-order-table tbody').height();
    var tableOffset2 = jQuery('.collapse-cart').height();
    // var   couponOffsetTop = parseInt(tableOffset) + parseInt(tableOffset2*2)+ parseInt(44);    
    var   couponOffsetTop = -40; 
    
    jQuery("#coupon-destination").css({top:couponOffsetTop+'px'});
    jQuery( "#order_review2" ).toggleClass('item-show');

}


jQuery( window ).load(function() {
    //jQuery('#ship-to-different-address label').trigger('click');

  jQuery("#billing_email").val(jQuery( "#billing_email_custom" ).val());
  jQuery("#billing_first_name").val(jQuery( "#shipping_first_name" ).val());
  jQuery("#billing_last_name").val(jQuery( "#shipping_last_name" ).val());

  jQuery("#billing_address_1").val(jQuery( "#shipping_address_1" ).val());
  jQuery("#billing_address_2").val(jQuery( "#shipping_address_2" ).val());
  jQuery("#billing_city").val(jQuery( "#shipping_city" ).val());
  jQuery("#billing_postcode").val(jQuery( "#shipping_postcode" ).val());
  jQuery("#billing_phone").val(jQuery( "#shipping_phone" ).val());

});

//ON CHANGE
jQuery( "#billing_email_custom" ).change(function() {
   jQuery('#billing_email_custom_field').removeClass('focus-error');
   jQuery('.error-email').remove();
	
  
  jQuery("#billing_email").val(jQuery( "#billing_email_custom" ).val());
  jQuery("#contact-data").html(jQuery( "#billing_email_custom" ).val());
  jQuery('#billing_email').trigger('change');
});
jQuery( "#shipping_first_name" ).change(function() {
   jQuery('#shipping_first_name_field').removeClass('focus-error');
   jQuery('.error-name').remove();
  jQuery("#billing_first_name").val(jQuery( "#shipping_first_name" ).val());
});
jQuery( "#shipping_phone" ).change(function() {
   jQuery('#shipping_phone_field').removeClass('focus-error');
   jQuery('.error-phone').remove();
  jQuery("#billing_phone").val(jQuery( "#shipping_phone" ).val());
});
jQuery( "#shipping_last_name" ).change(function() {
    jQuery('#shipping_last_name_field').removeClass('focus-error');
   jQuery('.error-lastname').remove();
  jQuery("#billing_last_name").val(jQuery( "#shipping_last_name" ).val());
});
jQuery( "#shipping_address_1" ).change(function() {
    jQuery( "#shipping_address_1_field" ).removeClass('focus-error');
   jQuery('.error-address').remove();
    var address = jQuery( "#shipping_address_1" ).val();
  jQuery("#billing_address_1").val(address);
});
jQuery( "#shipping_address_2" ).change(function() {
    var address = jQuery( "#shipping_address_2" ).val();
  jQuery("#billing_address_extra").val(address);
});

jQuery( "#shipping_city" ).change(function() {
    jQuery('#shipping_city_field').removeClass('focus-error');
   jQuery('.error-city').remove();
  jQuery("#billing_city").val(jQuery( "#shipping_city" ).val());
});
jQuery( "#shipping_postcode" ).change(function() {
    jQuery('#shipping_postcode_field').removeClass('focus-error');
   jQuery('.error-zip').remove();
  jQuery("#billing_postcode").val(jQuery( "#shipping_postcode" ).val());
});


//ON KEYUP
jQuery( "#billing_email_custom" ).keyup(function() {
   jQuery('#billing_email_custom_field').removeClass('focus-error');
   jQuery('.error-email').remove();

  jQuery("#billing_email").val(jQuery( "#billing_email_custom" ).val());
  jQuery("#contact-data").html(jQuery( "#billing_email_custom" ).val());
});
jQuery( "#shipping_first_name" ).keyup(function() {
   jQuery('#shipping_first_name_field').removeClass('focus-error');
   jQuery('.error-name').remove();

  jQuery("#billing_first_name").val(jQuery( "#shipping_first_name" ).val());
});
jQuery( "#shipping_last_name" ).keyup(function() {
    jQuery('#shipping_last_name_field').removeClass('focus-error');
   jQuery('.error-lastname').remove();
  jQuery("#billing_last_name").val(jQuery( "#shipping_last_name" ).val());
});
jQuery( "#shipping_address_1" ).keyup(function() {
     jQuery( "#shipping_address_1_field" ).removeClass('focus-error');
   jQuery('.error-address').remove();

    var address = jQuery( "#shipping_address_1" ).val();
  jQuery("#billing_address_1").val(address);
});
jQuery( "#shipping_address_2" ).keyup(function() {
    var address = jQuery( "#shipping_address_2" ).val();
  jQuery("#billing_address_extra").val(address);
});

jQuery( "#shipping_city" ).keyup(function() {
    jQuery('#shipping_city_field').removeClass('focus-error');
   jQuery('.error-city').remove();
  jQuery("#billing_city").val(jQuery( "#shipping_city" ).val());
});
jQuery( "#shipping_postcode" ).keyup(function() {
    jQuery('#shipping_postcode_field').removeClass('focus-error');
   jQuery('.error-zip').remove();
  jQuery("#billing_postcode").val(jQuery( "#shipping_postcode" ).val());
});

jQuery('#shipping_state').on('change', function() {
    
  jQuery("#billing_state").val(this.value);

        setTimeout(function() {
                  jQuery(".mobile-total-grand").html(jQuery(".total-grand").html());
            }, 1800);
  //jQuery('#billing_state option[value="'+this.value+'"]');
})

function isValidEmailAddress(emailAddress) {
    var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
    return pattern.test(emailAddress);
}

// Function to match billing emails - IM
function addsenderemail(bemail) {
   
   if (bemail != '') { // Customer is looged in
	  document.getElementById('billing_email').value = bemail; 
   } else { // Customer is a guest 
	  document.getElementById('billing_email').value = document.getElementById('billing_email_custom').value; 
   }
   
   billingType('1');
   
}  

function addems(bemail) {
	
	if (bemail != '') { // Customer is looged in
	  document.getElementById('billing_email').value = bemail; 
	} else { // Customer is a guest 
	  document.getElementById('billing_email').value = document.getElementById('billing_email_custom').value; 
	}
	
	goToPage('payment');
	
}		