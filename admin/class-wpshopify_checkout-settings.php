<?php

/**
 * The settings of the plugin.
 *
 * @link       http://devinvinson.com
 * @since      1.0.0
 *
 * @package    wpshopify_checkout_Plugin
 * @subpackage wpshopify_checkout_Plugin/admin
 */

/**
 * Class WordPress_Plugin_Template_Settings
 *
 */
class Wpshopify_checkout_Admin_Settings {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * This function introduces the theme options into the 'Appearance' menu and into a top-level
	 * 'WPShopify Checkout' menu.
	 */
	public function setup_plugin_options_menu() {

		//Add the menu to the Plugins set of menu items
		/*
		add_plugins_page(
			'WPShopify Checkout Settings', 					// The title to be displayed in the browser window for this page.
			// 'WPShopify Checkout Options',				// The text to be displayed for this menu item
			'WPShopify Checkout',	   						// The text to be displayed for this menu item
			'manage_options',								// Which type of users can see this menu item
			'wpshopify_checkout_settings',					// The unique ID - that is, the slug - for this menu item
			array( $this, 'render_settings_page_content')	// The name of the function to call when rendering this menu's page
		);
		*/
		
		add_menu_page( 'WPShopify Checkout Settings', 'WPShopify Checkout', 'manage_options', 'wpshopify_checkout_settings', array( $this, 'render_settings_page_content'), 'dashicons-admin-links');
	}

	/**
	 * Provides default values for the Display Options.
	 *
	 * @return array
	 */
	public function default_display_options() {

		$defaults = array(
			'show_header'		=>	'',
			'show_content'		=>	'',
			'show_footer'		=>	'',
		);

		return $defaults;

	}

	/**
	 * Provide default values for the Social Options.
	 *
	 * @return array
	 */
	public function default_social_options() {

		$defaults = array(
			'twitter'		=>	'twitter',
			'facebook'		=>	'',
			'googleplus'	=>	'',
		);

		return  $defaults;

	}

	/**
	 * Provides default values for the Input Options.
	 *
	 * @return array
	 */
	public function default_input_options() {

		$defaults = array(
			// 'input_example'		=>	'default input example',
			'textarea_header'	=>	'',
			'textarea_footer'	=>	'',
			// 'checkbox_example'	=>	'',
			// 'radio_example'		=>	'2',
			// 'time_options'		=>	'default'
		);

		return $defaults;

	}

	/**
	 * Renders a simple page to display for the theme menu defined above.
	 */
	public function render_settings_page_content( $active_tab = '' ) {
		?>
		<!-- Create a header in the default WordPress 'wrap' container -->
		<div class="wrap">

			<!-- <h2><?php // _e( 'WPShopify Checkout Options', 'wpshopify_checkout' ); ?></h2> -->
            
            <h2><?php _e( 'WPShopify Checkout Settings', 'wpshopify_checkout' ); ?></h2>
            
			<?php settings_errors(); ?>

			<?php 
			
			$active_tab = 'input_examples';
			
			/*
			if( isset( $_GET[ 'tab' ] ) ) {
				$active_tab = $_GET[ 'tab' ];
			} else if( $active_tab == 'social_options' ) {
				$active_tab = 'social_options';
			} else if( $active_tab == 'input_examples' ) {
				$active_tab = 'input_examples';
			} else {
				$active_tab = 'display_options';
			} // end if/else
			
			*/
			 ?>

            <!--
			<h2 class="nav-tab-wrapper">
				<a href="?page=wpshopify_checkout_settings&tab=display_options" class="nav-tab <?php //echo $active_tab == 'display_options' ? 'nav-tab-active' : ''; ?>"><?php //_e( 'Display Options', 'wpshopify_checkout' ); ?></a>
				<a href="?page=wpshopify_checkout_settings&tab=social_options" class="nav-tab <?php //echo $active_tab == 'social_options' ? 'nav-tab-active' : ''; ?>"><?php //_e( 'Social Options', 'wpshopify_checkout' ); ?></a>
				<a href="?page=wpshopify_checkout_settings&tab=input_examples" class="nav-tab <?php //echo $active_tab == 'input_examples' ? 'nav-tab-active' : ''; ?>"><?php //_e( 'Input Examples', 'wpshopify_checkout' ); ?></a>
			</h2>
			-->
            
			<form method="post" action="options.php">
				<?php

				if( $active_tab == 'display_options' ) {

					settings_fields( 'wpshopify_checkout_display_options' );
					do_settings_sections( 'wpshopify_checkout_display_options' );

				} elseif( $active_tab == 'social_options' ) {

					settings_fields( 'wpshopify_checkout_social_options' );
					do_settings_sections( 'wpshopify_checkout_social_options' );

				} else {

					settings_fields( 'wpshopify_checkout_input_examples' );
					do_settings_sections( 'wpshopify_checkout_input_examples' );

				} // end if/else

				submit_button();

				?>
			</form>

		</div><!-- /.wrap -->
	<?php
	}


	/**
	 * This function provides a simple description for the General Options page.
	 *
	 * It's called from the 'wpshopify_checkout_initialize_theme_options' function by being passed as a parameter
	 * in the add_settings_section function.
	 */
	public function general_options_callback() {
		$options = get_option('wpshopify_checkout_display_options');
		var_dump($options);
		echo '<p>' . __( 'Select which areas of content you wish to display.', 'wpshopify_checkout' ) . '</p>';
	} // end general_options_callback

	/**
	 * This function provides a simple description for the Social Options page.
	 *
	 * It's called from the 'wpshopify_checkout_theme_initialize_social_options' function by being passed as a parameter
	 * in the add_settings_section function.
	 */
	public function social_options_callback() {
		$options = get_option('wpshopify_checkout_social_options');
		var_dump($options);
		echo '<p>' . __( 'Provide the URL to the social networks you\'d like to display.', 'wpshopify_checkout' ) . '</p>';
	} // end general_options_callback

	/**
	 * This function provides a simple description for the Input Examples page.
	 *
	 * It's called from the 'wpshopify_checkout_theme_initialize_input_examples_options' function by being passed as a parameter
	 * in the add_settings_section function.
	 */
	public function input_examples_callback() {
		$options = get_option('wpshopify_checkout_input_examples');
		// var_dump($options);
		// echo '<p>' . __( 'Provides examples of the five basic element types.', 'wpshopify_checkout' ) . '</p>';
		// echo '<p>' . __( 'Please set the corresponding information for the WP Shopify Checkout plugin:', 'wpshopify_checkout' ) . '</p>';
		echo '<p>' . __( 'Add Javascript code for the Header and Footer in the corresponding text boxes below:', 'wpshopify_checkout' ) . '</p>';
	} // end general_options_callback


	/**
	 * Initializes the theme's display options page by registering the Sections,
	 * Fields, and Settings.
	 *
	 * This function is registered with the 'admin_init' hook.
	 */
	public function initialize_display_options() {

		// If the theme options don't exist, create them.
		if( false == get_option( 'wpshopify_checkout_display_options' ) ) {
			$default_array = $this->default_display_options();
			add_option( 'wpshopify_checkout_display_options', $default_array );
		}


		add_settings_section(
			'general_settings_section',			            // ID used to identify this section and with which to register options
			__( 'Display Options', 'wpshopify_checkout' ),		        // Title to be displayed on the administration page
			array( $this, 'general_options_callback'),	    // Callback used to render the description of the section
			'wpshopify_checkout_display_options'		                // Page on which to add this section of options
		);

		// Next, we'll introduce the fields for toggling the visibility of content elements.
		add_settings_field(
			'show_header',						        // ID used to identify the field throughout the theme
			__( 'Header', 'wpshopify_checkout' ),					// The label to the left of the option interface element
			array( $this, 'toggle_header_callback'),	// The name of the function responsible for rendering the option interface
			'wpshopify_checkout_display_options',	            // The page on which this option will be displayed
			'general_settings_section',			        // The name of the section to which this field belongs
			array(								        // The array of arguments to pass to the callback. In this case, just a description.
				__( 'Activate this setting to display the header.', 'wpshopify_checkout' ),
			)
		);

		add_settings_field(
			'show_content',
			__( 'Content', 'wpshopify_checkout' ),
			array( $this, 'toggle_content_callback'),
			'wpshopify_checkout_display_options',
			'general_settings_section',
			array(
				__( 'Activate this setting to display the content.', 'wpshopify_checkout' ),
			)
		);

		add_settings_field(
			'show_footer',
			__( 'Footer', 'wpshopify_checkout' ),
			array( $this, 'toggle_footer_callback'),
			'wpshopify_checkout_display_options',
			'general_settings_section',
			array(
				__( 'Activate this setting to display the footer.', 'wpshopify_checkout' ),
			)
		);

		// Finally, we register the fields with WordPress
		register_setting(
			'wpshopify_checkout_display_options',
			'wpshopify_checkout_display_options'
		);

	} // end wpshopify_checkout_initialize_theme_options


	/**
	 * Initializes the theme's social options by registering the Sections,
	 * Fields, and Settings.
	 *
	 * This function is registered with the 'admin_init' hook.
	 */
	public function initialize_social_options() {
		delete_option('wpshopify_checkout_social_options');
		if( false == get_option( 'wpshopify_checkout_social_options' ) ) {
			$default_array = $this->default_social_options();
			update_option( 'wpshopify_checkout_social_options', $default_array );
		} // end if

		add_settings_section(
			'social_settings_section',			// ID used to identify this section and with which to register options
			__( 'Social Options', 'wpshopify_checkout-plugin' ),		// Title to be displayed on the administration page
			array( $this, 'social_options_callback'),	// Callback used to render the description of the section
			'wpshopify_checkout_social_options'		// Page on which to add this section of options
		);

		add_settings_field(
			'twitter',
			'Twitter',
			array( $this, 'twitter_callback'),
			'wpshopify_checkout_social_options',
			'social_settings_section'
		);

		add_settings_field(
			'facebook',
			'Facebook',
			array( $this, 'facebook_callback'),
			'wpshopify_checkout_social_options',
			'social_settings_section'
		);

		add_settings_field(
			'googleplus',
			'Google+',
			array( $this, 'googleplus_callback'),
			'wpshopify_checkout_social_options',
			'social_settings_section'
		);

		register_setting(
			'wpshopify_checkout_social_options',
			'wpshopify_checkout_social_options',
			array( $this, 'sanitize_social_options')
		);

	}


	/**
	 * Initializes the theme's input example by registering the Sections,
	 * Fields, and Settings. This particular group of options is used to demonstration
	 * validation and sanitization.
	 *
	 * This function is registered with the 'admin_init' hook.
	 */
	public function initialize_input_examples() {
		//delete_option('wpshopify_checkout_input_examples');
		if( false == get_option( 'wpshopify_checkout_input_examples' ) ) {
			$default_array = $this->default_input_options();
			update_option( 'wpshopify_checkout_input_examples', $default_array );
		} // end if

        
		add_settings_section(
			'input_examples_section',
			'', // __( 'Input Examples', 'wpshopify_checkout' ),
			array( $this, 'input_examples_callback'),
			'wpshopify_checkout_input_examples'
		);

        /*
		add_settings_field(
			'Input Element',
			__( 'Input Element', 'wpshopify_checkout' ),
			array( $this, 'input_element_callback'),
			'wpshopify_checkout_input_examples',
			'input_examples_section'
		);
        */
       
		add_settings_field(
			'Textarea Header',
			// __( 'Textarea Element', 'wpshopify_checkout' ),
			__( 'Add Meta Header code', 'wpshopify_checkout' ),
			array( $this, 'textarea_header_callback'),
			'wpshopify_checkout_input_examples',
			'input_examples_section'
		);
		
		add_settings_field(
			'Textarea Footer',
			// __( 'Textarea Element', 'wpshopify_checkout' ),
			__( 'Add Meta Footer code', 'wpshopify_checkout' ),
			array( $this, 'textarea_footer_callback'),
			'wpshopify_checkout_input_examples',
			'input_examples_section'
		);
		
       /*
		add_settings_field(
			'Checkbox Element',
			__( 'Checkbox Element', 'wpshopify_checkout' ),
			array( $this, 'checkbox_element_callback'),
			'wpshopify_checkout_input_examples',
			'input_examples_section'
		);

		add_settings_field(
			'Radio Button Elements',
			__( 'Radio Button Elements', 'wpshopify_checkout' ),
			array( $this, 'radio_element_callback'),
			'wpshopify_checkout_input_examples',
			'input_examples_section'
		);

		add_settings_field(
			'Select Element',
			__( 'Select Element', 'wpshopify_checkout' ),
			array( $this, 'select_element_callback'),
			'wpshopify_checkout_input_examples',
			'input_examples_section'
		);
        */
		
		register_setting(
			'wpshopify_checkout_input_examples',
			'wpshopify_checkout_input_examples',
			array( $this, 'validate_input_examples')
		);

	}

	/**
	 * This function renders the interface elements for toggling the visibility of the header element.
	 *
	 * It accepts an array or arguments and expects the first element in the array to be the description
	 * to be displayed next to the checkbox.
	 */
	public function toggle_header_callback($args) {

		// First, we read the options collection
		$options = get_option('wpshopify_checkout_display_options');

		// Next, we update the name attribute to access this element's ID in the context of the display options array
		// We also access the show_header element of the options collection in the call to the checked() helper function
		$html = '<input type="checkbox" id="show_header" name="wpshopify_checkout_display_options[show_header]" value="1" ' . checked( 1, isset( $options['show_header'] ) ? $options['show_header'] : 0, false ) . '/>';

		// Here, we'll take the first argument of the array and add it to a label next to the checkbox
		$html .= '<label for="show_header">&nbsp;'  . $args[0] . '</label>';

		echo $html;

	} // end toggle_header_callback

	public function toggle_content_callback($args) {

		$options = get_option('wpshopify_checkout_display_options');

		$html = '<input type="checkbox" id="show_content" name="wpshopify_checkout_display_options[show_content]" value="1" ' . checked( 1, isset( $options['show_content'] ) ? $options['show_content'] : 0, false ) . '/>';
		$html .= '<label for="show_content">&nbsp;'  . $args[0] . '</label>';

		echo $html;

	} // end toggle_content_callback

	public function toggle_footer_callback($args) {

		$options = get_option('wpshopify_checkout_display_options');

		$html = '<input type="checkbox" id="show_footer" name="wpshopify_checkout_display_options[show_footer]" value="1" ' . checked( 1, isset( $options['show_footer'] ) ? $options['show_footer'] : 0, false ) . '/>';
		$html .= '<label for="show_footer">&nbsp;'  . $args[0] . '</label>';

		echo $html;

	} // end toggle_footer_callback

	public function twitter_callback() {

		// First, we read the social options collection
		$options = get_option( 'wpshopify_checkout_social_options' );

		// Next, we need to make sure the element is defined in the options. If not, we'll set an empty string.
		$url = '';
		if( isset( $options['twitter'] ) ) {
			$url = esc_url( $options['twitter'] );
		} // end if

		// Render the output
		echo '<input type="text" id="twitter" name="wpshopify_checkout_social_options[twitter]" value="' . $url . '" />';

	} // end twitter_callback

	public function facebook_callback() {

		$options = get_option( 'wpshopify_checkout_social_options' );

		$url = '';
		if( isset( $options['facebook'] ) ) {
			$url = esc_url( $options['facebook'] );
		} // end if

		// Render the output
		echo '<input type="text" id="facebook" name="wpshopify_checkout_social_options[facebook]" value="' . $url . '" />';

	} // end facebook_callback

	public function googleplus_callback() {

		$options = get_option( 'wpshopify_checkout_social_options' );

		$url = '';
		if( isset( $options['googleplus'] ) ) {
			$url = esc_url( $options['googleplus'] );
		} // end if

		// Render the output
		echo '<input type="text" id="googleplus" name="wpshopify_checkout_social_options[googleplus]" value="' . $url . '" />';

	} // end googleplus_callback

	public function input_element_callback() {

		$options = get_option( 'wpshopify_checkout_input_examples' );

		// Render the output
		echo '<input type="text" id="input_example" name="wpshopify_checkout_input_examples[input_example]" value="' . $options['input_example'] . '" />';

	} // end input_element_callback

	public function textarea_header_callback() {

		$options = get_option( 'wpshopify_checkout_input_examples' );

		// Render the output
		echo '<textarea id="textarea_header" name="wpshopify_checkout_input_examples[textarea_header]" rows="5" cols="50">' . $options['textarea_header'] . '</textarea>';

	} // end textarea_element_callback
	
	public function textarea_footer_callback() {

		$options = get_option( 'wpshopify_checkout_input_examples' );

		// Render the output
		echo '<textarea id="textarea_footer" name="wpshopify_checkout_input_examples[textarea_footer]" rows="5" cols="50">' . $options['textarea_footer'] . '</textarea>';

	} // end textarea_element_callback

	public function checkbox_element_callback() {

		$options = get_option( 'wpshopify_checkout_input_examples' );

		$html = '<input type="checkbox" id="checkbox_example" name="wpshopify_checkout_input_examples[checkbox_example]" value="1"' . checked( 1, $options['checkbox_example'], false ) . '/>';
		$html .= '&nbsp;';
		$html .= '<label for="checkbox_example">This is an example of a checkbox</label>';

		echo $html;

	} // end checkbox_element_callback

	public function radio_element_callback() {

		$options = get_option( 'wpshopify_checkout_input_examples' );

		$html = '<input type="radio" id="radio_example_one" name="wpshopify_checkout_input_examples[radio_example]" value="1"' . checked( 1, $options['radio_example'], false ) . '/>';
		$html .= '&nbsp;';
		$html .= '<label for="radio_example_one">Option One</label>';
		$html .= '&nbsp;';
		$html .= '<input type="radio" id="radio_example_two" name="wpshopify_checkout_input_examples[radio_example]" value="2"' . checked( 2, $options['radio_example'], false ) . '/>';
		$html .= '&nbsp;';
		$html .= '<label for="radio_example_two">Option Two</label>';

		echo $html;

	} // end radio_element_callback

	public function select_element_callback() {

		$options = get_option( 'wpshopify_checkout_input_examples' );

		$html = '<select id="time_options" name="wpshopify_checkout_input_examples[time_options]">';
		$html .= '<option value="default">' . __( 'Select a time option...', 'wpshopify_checkout' ) . '</option>';
		$html .= '<option value="never"' . selected( $options['time_options'], 'never', false) . '>' . __( 'Never', 'wpshopify_checkout' ) . '</option>';
		$html .= '<option value="sometimes"' . selected( $options['time_options'], 'sometimes', false) . '>' . __( 'Sometimes', 'wpshopify_checkout' ) . '</option>';
		$html .= '<option value="always"' . selected( $options['time_options'], 'always', false) . '>' . __( 'Always', 'wpshopify_checkout' ) . '</option>';	$html .= '</select>';

		echo $html;

	} // end select_element_callback


	/**
	 * Sanitization callback for the social options. Since each of the social options are text inputs,
	 * this function loops through the incoming option and strips all tags and slashes from the value
	 * before serializing it.
	 *
	 * @params	$input	The unsanitized collection of options.
	 *
	 * @returns			The collection of sanitized values.
	 */
	public function sanitize_social_options( $input ) {

		// Define the array for the updated options
		$output = array();

		// Loop through each of the options sanitizing the data
		foreach( $input as $key => $val ) {

			if( isset ( $input[$key] ) ) {
				$output[$key] = esc_url_raw( strip_tags( stripslashes( $input[$key] ) ) );
			} // end if

		} // end foreach

		// Return the new collection
		return apply_filters( 'sanitize_social_options', $output, $input );

	} // end sanitize_social_options

	public function validate_input_examples( $input ) {

		// Create our array for storing the validated options
		$output = array();

		// Loop through each of the incoming options
		foreach( $input as $key => $value ) {

			// Check to see if the current option has a value. If so, process it.
			if( isset( $input[$key] ) ) {

				// Strip all HTML and PHP tags and properly handle quoted strings
				$output[$key] = strip_tags( stripslashes( $input[ $key ] ) );

			} // end if

		} // end foreach

		// Return the array processing any additional functions filtered by this action
		return apply_filters( 'validate_input_examples', $output, $input );

	} // end validate_input_examples




}