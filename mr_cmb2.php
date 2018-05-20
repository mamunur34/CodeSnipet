<?php
/**
 * Include and setup custom metaboxes and fields. (make sure you copy this file to outside the CMB2 directory)
 *
 * Be sure to replace all instances of 'arielle_' with your project's prefix.
 * http://nacin.com/2010/05/11/in-wordpress-prefix-everything/
 *
 * @category YourThemeOrPlugin
 * @package  Demo_CMB2
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/CMB2/CMB2
 */

/**
 * Get the bootstrap! If using the plugin from wordpress.org, REMOVE THIS!
 */

if ( file_exists( get_template_directory() . '/assets/cmb2/init.php' ) ) {
	require_once get_template_directory() . '/assets/cmb2/init.php';
} 

/**
 * Conditionally displays a metabox when used as a callback in the 'show_on_cb' cmb2_box parameter
 *
 * @param  CMB2 $cmb CMB2 object.
 *
 * @return bool      True if metabox should show
 */
function arielle_show_if_front_page( $cmb ) {
	// Don't show this metabox if it's not the front page template.
	if ( get_option( 'page_on_front' ) !== $cmb->object_id ) {
		return false;
	}
	return true;
}

/**
 * Conditionally displays a field when used as a callback in the 'show_on_cb' field parameter
 *
 * @param  CMB2_Field $field Field object.
 *
 * @return bool              True if metabox should show
 */
function arielle_hide_if_no_cats( $field ) {
	// Don't show this field if not in the cats category.
	if ( ! has_tag( 'cats', $field->object_id ) ) {
		return false;
	}
	return true;
}

/**
 * Manually render a field.
 *
 * @param  array      $field_args Array of field arguments.
 * @param  CMB2_Field $field      The field object.
 */
function arielle_render_row_cb( $field_args, $field ) {
	$classes     = $field->row_classes();
	$id          = $field->args( 'id' );
	$label       = $field->args( 'name' );
	$name        = $field->args( '_name' );
	$value       = $field->escaped_value();
	$description = $field->args( 'description' );
	?>
	<div class="custom-field-row <?php echo esc_attr( $classes ); ?>">
		<p><label for="<?php echo esc_attr( $id ); ?>"><?php echo esc_html( $label ); ?></label></p>
		<p><input id="<?php echo esc_attr( $id ); ?>" type="text" name="<?php echo esc_attr( $name ); ?>" value="<?php echo $value; ?>"/></p>
		<p class="description"><?php echo esc_html( $description ); ?></p>
	</div>
	<?php
}

/**
 * Manually render a field column display.
 *
 * @param  array      $field_args Array of field arguments.
 * @param  CMB2_Field $field      The field object.
 */
function arielle_display_text_small_column( $field_args, $field ) {
	?>
	<div class="custom-column-display <?php echo esc_attr( $field->row_classes() ); ?>">
		<p><?php echo $field->escaped_value(); ?></p>
		<p class="description"><?php echo esc_html( $field->args( 'description' ) ); ?></p>
	</div>
	<?php
}

/**
 * Conditionally displays a message if the $post_id is 2
 *
 * @param  array      $field_args Array of field parameters.
 * @param  CMB2_Field $field      Field object.
 */
function arielle_before_row_if_2( $field_args, $field ) {
	if ( 2 == $field->object_id ) {
		echo '<p>Testing <b>"before_row"</b> parameter (on $post_id 2)</p>';
	} else {
		echo '<p>Testing <b>"before_row"</b> parameter (<b>NOT</b> on $post_id 2)</p>';
	}
}

add_action( 'cmb2_admin_init', 'arielle_register_metabox' );
/**
 * Hook in and add a demo metabox. Can only happen on the 'cmb2_admin_init' or 'cmb2_init' hook.
 */
function arielle_register_metabox() {
	$prefix = 'toronto_';

	/**
	 * Sample metabox to demonstrate each field type included
	 */
	$cmb_demo = new_cmb2_box( array(
		'id'            => $prefix . 'metabox',
		'title'         => esc_html__( 'Custom Metabox', 'cmb2' ),
		'object_types'  => array( 'page',  ), // Post type
		// 'show_on_cb' => 'arielle_show_if_front_page', // function should return a bool value
		// 'context'    => 'normal',
		  'priority'   => 'high',
		// 'show_names' => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // true to keep the metabox closed by default
		// 'classes'    => 'extra-class', // Extra cmb2-wrap classes
		// 'classes_cb' => 'arielle_add_some_classes', // Add classes through a callback.
	) );

	  
	$cmb_demo->add_field( array(
		'name' => esc_html__( 'Set Call-To-Action Button URL', 'cmb2' ),
		'desc' => esc_html__( 'Input Call-To-Action Button URL', 'cmb2' ),
		'id'   => $prefix . 'cta_url',
		'type' => 'text',
	) );
    
	$cmb_demo->add_field( array(
		'name' => esc_html__( 'Set Call-To-Action Button Text', 'cmb2' ),
		'desc' => esc_html__( 'Set Call-To-Action Button Text', 'cmb2' ),
		'id'   => $prefix . 'cta_button_text',
		'type' => 'text',
	) );
    
	$cmb_demo->add_field( array(
		'name' => esc_html__( 'Set Sponsor page url ', 'cmb2' ),
		'desc' => esc_html__( 'Set Sponsor page url ', 'cmb2' ),
		'id'   => $prefix . 'sponsor_page_url',
		'type' => 'text',
	) ); 
	
	$cmb_demo->add_field( array(
		'name' => esc_html__( 'Do we show Judges Section?', 'cmb2' ),
		'desc' => esc_html__( 'Do we show Judges Section?', 'cmb2' ),
		'id'   => $prefix . 'judges_bool',
		'type' => 'checkbox',
	) );
	
	$cmb_demo->add_field( array(
		'name'       => 'Select Categoris of Judges to be shown',
		'desc'           => 'Select Categoris of Judges to be shown.',
		'id'             => 'judges_category',
		'type'           => 'multicheck',
		// Use a callback to avoid performance hits on pages where this field is not displayed (including the front-end).
		'options_cb'     => 'cmb2_get_term_options',
		// Same arguments you would pass to `get_terms`.
		'get_terms_args' => array(
			'taxonomy'   => 'category',
			'hide_empty' => false,
		),
	) );
	
	 
	
	$cmb_demo->add_field( array(
		'name' => esc_html__( 'Do we show  Hostes Section?', 'cmb2' ),
		'desc' => esc_html__( 'Do we show Hostes Section?', 'cmb2' ),
		'id'   => $prefix . 'hosts_bool',
		'type' => 'checkbox',
	) );	
	
		$cmb_demo->add_field( array(
		'name'       => 'Select Categoris of Hostes to be shown',
		'desc'           => 'Select Categoris of Hostes to be shown.',
		'id'             => 'hostes_category',
		'type'           => 'multicheck',
		// Use a callback to avoid performance hits on pages where this field is not displayed (including the front-end).
		'options_cb'     => 'cmb2_get_term_options',
		// Same arguments you would pass to `get_terms`.
		'get_terms_args' => array(
			'taxonomy'   => 'category',
			'hide_empty' => false,
		),
	) );
	$cmb_demo->add_field( array(
		'name' => esc_html__( 'Do we show  Official Partners Section?', 'cmb2' ),
		'desc' => esc_html__( 'Do we show Official Partners Section?', 'cmb2' ),
		'id'   => $prefix . 'partner_bool',
		'type' => 'checkbox',
	) );
	$cmb_demo->add_field( array(
		'name'       => 'Select Categoris of Official Partners to be shown',
		'desc'           => 'Select Categoris of Official Partners to be shown.',
		'id'             => 'partner_category',
		'type'           => 'multicheck',
		// Use a callback to avoid performance hits on pages where this field is not displayed (including the front-end).
		'options_cb'     => 'cmb2_get_term_options',
		// Same arguments you would pass to `get_terms`.
		'get_terms_args' => array(
			'taxonomy'   => 'category',
			'hide_empty' => false,
		),
	) );
	
	
	/////////////////////////////////////////////////////////
	/**
	 *  metabox for mr_judge  post type 
	 */
         
        
	$mr_judge_meta_tree = new_cmb2_box( array(
		'id'            => $prefix . 'mr_judge',
		'title'         => esc_html__( 'Judges Page Metabox ', 'cmb2' ),
		'object_types'  => array( 'mr_judge',  'partner', 'mr_host' ), // Post type
		// 'show_on_cb' => 'charitysympathy_show_if_front_page', // function should return a bool value
		// 'context'    => 'normal',
		  'priority'   => 'high',
		// 'show_names' => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // true to keep the metabox closed by default
		// 'classes'    => 'extra-class', // Extra cmb2-wrap classes
		// 'classes_cb' => 'charitysympathy_add_some_classes', // Add classes through a callback.
	) );

  
	

	$mr_judge_meta_tree->add_field( array(
		'name' => esc_html__( 'Job Title', 'cmb2' ),
		'desc' => esc_html__( 'Job Title', 'cmb2' ),
		'id'   => $prefix . 'mr_judge_job',
		'type' => 'text', 
	) ); 
	
	
	$mr_judge_meta_tree->add_field( array(
		'name' => esc_html__( 'Company', 'cmb2' ),
		'desc' => esc_html__( 'Input Company', 'cmb2' ),
		'id'   => $prefix . 'mr_judge_company',
		'type' => 'text', 
	) ); 
	
	$mr_judge_meta_tree->add_field( array(
		'name' => esc_html__( 'Facebook Link', 'cmb2' ),
		'desc' => esc_html__( 'Input url', 'cmb2' ),
		'id'   => $prefix . 'mr_judge_fb',
		'type' => 'text_url', 
	) ); 
	$mr_judge_meta_tree->add_field( array(
		'name' => esc_html__( 'Linkedin Link', 'cmb2' ),
		'desc' => esc_html__( 'Linkedin url', 'cmb2' ),
		'id'   => $prefix . 'mr_judge_linkedin',
		'type' => 'text_url', 
	) ); 
	$mr_judge_meta_tree->add_field( array(
		'name' => esc_html__( 'Google Plus Link', 'cmb2' ),
		'desc' => esc_html__( 'Input Google Plus url', 'cmb2' ),
		'id'   => $prefix . 'mr_judge_gp',
		'type' => 'text_url', 
	) );
 	
	$mr_judge_meta_tree->add_field( array(
		'name' => esc_html__( 'Twitter Link', 'cmb2' ),
		'desc' => esc_html__( 'Input Twitter url', 'cmb2' ),
		'id'   => $prefix . 'mr_judge_twit',
		'type' => 'text_url', 
	) ); 
 
 
 /*
	Header Text Box
 */
	$mr_page_texts_option_tree = new_cmb2_box( array(
		'id'            => $prefix . 'mr_text_one',
		'title'         => esc_html__( 'Header Text Box', 'cmb2' ),
		'object_types'  => array( 'page' ), // Post type
		 'priority'   => 'high',
		// 'show_names' => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // true to keep the metabox closed by default
		// 'classes'    => 'extra-class', // Extra cmb2-wrap classes
		// 'classes_cb' => 'charitysympathy_add_some_classes', // Add classes through a callback.
	) );

  
	

	$mr_page_texts_option_tree->add_field( array(
		'name' => esc_html__( 'Header Intro', 'cmb2' ),
		'desc' => esc_html__( 'Header Intro', 'cmb2' ),
		'id'   => $prefix . 'header_intro',
		'type' => 'text', 
	) ); 
	
	$mr_page_texts_option_tree->add_field( array(
		'name' => esc_html__( 'Header Intro Box1', 'cmb2' ),
		'desc' => esc_html__( 'Header Intro Box1', 'cmb2' ),
		'id'   => $prefix . 'header_intro_box1',
		'type' => 'text', 
	) ); 	
	$mr_page_texts_option_tree->add_field( array(
		'name' => esc_html__( 'Header Intro Box2', 'cmb2' ),
		'desc' => esc_html__( 'Header Intro Box2', 'cmb2' ),
		'id'   => $prefix . 'header_intro_box2',
		'type' => 'text', 
	) ); 	
	$mr_page_texts_option_tree->add_field( array(
		'name' => esc_html__( 'Header Intro Box3', 'cmb2' ),
		'desc' => esc_html__( 'Header Intro Box3', 'cmb2' ),
		'id'   => $prefix . 'header_intro_box3',
		'type' => 'text', 
	) ); 

	
/*
	//TOP 5 STARTUPS
 */
 
 $mr_top_5_startups_option_tree = new_cmb2_box( array(
		'id'            => $prefix . 'mr_top_5_startups',
		'title'         => esc_html__( 'Top 5 Startup Section', 'cmb2' ),
		'object_types'  => array( 'page' ), // Post type
		 'priority'   => 'high',
		// 'show_names' => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // true to keep the metabox closed by default
		// 'classes'    => 'extra-class', // Extra cmb2-wrap classes
		// 'classes_cb' => 'charitysympathy_add_some_classes', // Add classes through a callback.
	) );

  
	

	$mr_top_5_startups_option_tree->add_field( array(
		'name' => esc_html__( 'Title', 'cmb2' ),
		'desc' => esc_html__( 'Title', 'cmb2' ),
		'id'   => $prefix . 'top_5_sec_title',
		'type' => 'text', 
	) ); 
	
	$mr_top_5_startups_option_tree->add_field( array(
		'name' => esc_html__( 'Line One Text', 'cmb2' ),
		'desc' => esc_html__( 'Line One Text', 'cmb2' ),
		'id'   => $prefix . 'top_5_sec_line_one_text',
		'type' => 'text', 
	) ); 	
	$mr_top_5_startups_option_tree->add_field( array(
		'name' => esc_html__( 'Line Two Text', 'cmb2' ),
		'desc' => esc_html__( 'Line Two Text', 'cmb2' ),
		'id'   => $prefix . 'top_5_sec_line_two_text',
		'type' => 'text', 
	) ); 	
	$mr_top_5_startups_option_tree->add_field( array(
		'name' => esc_html__( 'Line Three Text', 'cmb2' ),
		'desc' => esc_html__( 'Line Theree Text', 'cmb2' ),
		'id'   => $prefix . 'top_5_sec_line_three_text',
		'type' => 'text', 
	) ); 	
	$mr_top_5_startups_option_tree->add_field( array(
		'name' => esc_html__( 'Line Four Text', 'cmb2' ),
		'desc' => esc_html__( 'Line Four Text', 'cmb2' ),
		'id'   => $prefix . 'top_5_sec_line_four_text',
		'type' => 'text', 
	) ); 
 
 
 	
/*
	//Table html
 */
 
 $mr_table_html = new_cmb2_box( array(
		'id'            => $prefix . 'mr_table_html',
		'title'         => esc_html__( 'Insert Table HTML', 'cmb2' ),
		'object_types'  => array( 'page' ), // Post type
		 'priority'   => 'high',
	) );

	$mr_table_html->add_field( array(
		'name' => esc_html__( 'Put Timeline Table HTML', 'cmb2' ),
		'desc' => esc_html__( 'Put Timeline Table HTML', 'cmb2' ),
		'id'   => $prefix . 'mr_table_html_content',
		'type' => 'textarea_code', 
	) ); 
	
/*
	//Who Qualifies Section
 */
 
 $mr_who_qualifies_option_tree = new_cmb2_box( array(
		'id'            => $prefix . 'mr_who_qualifies',
		'title'         => esc_html__( 'Who Qualifies Section', 'cmb2' ),
		'object_types'  => array( 'page' ), // Post type
		 'priority'   => 'high',
	) );

  
	

	$mr_who_qualifies_option_tree->add_field( array(
		'name' => esc_html__( 'Title', 'cmb2' ),
		'desc' => esc_html__( 'Title', 'cmb2' ),
		'id'   => $prefix . 'who_qualifies_sec_title',
		'type' => 'text', 
	) ); 
	
	$mr_who_qualifies_option_tree->add_field( array(
		'name' => esc_html__( 'Line One Text', 'cmb2' ),
		'desc' => esc_html__( 'Line One Text', 'cmb2' ),
		'id'   => $prefix . 'who_qualifies_sec_line_one_text',
		'type' => 'text', 
	) ); 	
	$mr_who_qualifies_option_tree->add_field( array(
		'name' => esc_html__( 'Line Two Text', 'cmb2' ),
		'desc' => esc_html__( 'Line Two Text', 'cmb2' ),
		'id'   => $prefix . 'who_qualifies_sec_line_two_text',
		'type' => 'text', 
	) ); 	
	$mr_who_qualifies_option_tree->add_field( array(
		'name' => esc_html__( 'Line Three Text', 'cmb2' ),
		'desc' => esc_html__( 'Line Theree Text', 'cmb2' ),
		'id'   => $prefix . 'who_qualifies_sec_line_three_text',
		'type' => 'text', 
	) ); 	
	$mr_who_qualifies_option_tree->add_field( array(
		'name' => esc_html__( 'Line Four Text', 'cmb2' ),
		'desc' => esc_html__( 'Line Four Text', 'cmb2' ),
		'id'   => $prefix . 'who_qualifies_sec_line_four_text',
		'type' => 'text', 
	) ); 	
	$mr_who_qualifies_option_tree->add_field( array(
		'name' => esc_html__( 'Line Five Text', 'cmb2' ),
		'desc' => esc_html__( 'Line Five Text', 'cmb2' ),
		'id'   => $prefix . 'who_qualifies_sec_line_five_text',
		'type' => 'text', 
	) );  
 
 
 	
/*
	//Call To Action Section
 */
 
 $mr_call_to_action_option_tree = new_cmb2_box( array(
		'id'            => $prefix . 'mr_call_to_action',
		'title'         => esc_html__( 'Call To Action Section', 'cmb2' ),
		'object_types'  => array( 'page' ), // Post type
		 'priority'   => 'high',
	) );

  
	

	$mr_call_to_action_option_tree->add_field( array(
		'name' => esc_html__( 'Call To Action Title Text', 'cmb2' ),
		'desc' => esc_html__( 'Call To Action Title Text', 'cmb2' ),
		'id'   => $prefix . 'mr_cta_title',
		'type' => 'text', 
	) ); 
 
 
	
}
    