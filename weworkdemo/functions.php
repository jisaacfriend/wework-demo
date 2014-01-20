<?php
//Create WeWork Demo Custom Post Type
function wework_custom_post() {
	$labels = array(
		'name'               => _x( 'WeWork Demo', 'post type general name' ),
		'singular_name'      => _x( 'WeWork Demo', 'post type singular name' ),
		'add_new'            => _x( 'Add New', 'book' ),
		'add_new_item'       => __( 'Add New WeWork Demo' ),
		'edit_item'          => __( 'Edit WeWork Demo' ),
		'new_item'           => __( 'New WeWork Demo' ),
		'all_items'          => __( 'All WeWork Demos' ),
		'view_item'          => __( 'View WeWork Demo' ),
		'search_items'       => __( 'Search WeWork Demos' ),
		'not_found'          => __( 'No WeWork Demos found' ),
		'not_found_in_trash' => __( 'No WeWork Demos found in the Trash' ), 
		'parent_item_colon'  => '',
		'menu_name'          => 'Demos'
	);
	
	$args = array(
		'labels'        => $labels,
		'description'   => 'Demo posts for import into the Pinterest style masonry grid template.',
		'public'        => true,
		'menu_position' => 5,
		'supports'      => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments', 'revisions' ),
		'has_archive'   => true,
	);
	
	register_post_type( 'wework_demo', $args );

	//Create Taxonomy Labels
	$labels = array(
		'name'              => _x( 'Tags', 'taxonomy general name' ),
		'singular_name'     => _x( 'Tag', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Types' ),
		'all_items'         => __( 'All Tags' ),
		'parent_item'       => __( 'Parent Tag' ),
		'parent_item_colon' => __( 'Parent Tag:' ),
		'edit_item'         => __( 'Edit Tags' ),
		'update_item'       => __( 'Update Tag' ),
		'add_new_item'      => __( 'Add New Tag' ),
		'new_item_name'     => __( 'New Tag Name' ),
	);
	// Custom taxonomy for Project Tags
	register_taxonomy( 'tagweworkdemo', array( 'wework_demo' ), array(
		'hierarchical' => true,
		'labels'       => $labels,
		'show_ui'      => true,
		'query_var'    => true,
		'rewrite'      => array( 'slug' => 'tag-weworkdemo' ),
	));
}

add_action( 'init', 'wework_custom_post' );

//Custom Post Update Messages
function wework_demo_updated_messages( $messages ) {
	global $post, $post_ID;

	$messages['wework_demo'] = array(
		0 => '', // Unused. Messages start at index 1.
		1 => sprintf( __('WeWork Demo updated. <a href="%s">View WeWork Demo</a>'), esc_url( get_permalink($post_ID) ) ),
		2 => __('Custom field updated.'),
		3 => __('Custom field deleted.'),
		4 => __('WeWork Demo updated.'),
		/* translators: %s: date and time of the revision */
		5 => isset($_GET['revision']) ? sprintf( __('WeWork Demo restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => sprintf( __('WeWork Demo published. <a href="%s">View WeWork Demo</a>'), esc_url( get_permalink($post_ID) ) ),
		7 => __('WeWork Demo saved.'),
		8 => sprintf( __('WeWork Demo submitted. <a target="_blank" href="%s">Preview WeWork Demo</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
		9 => sprintf( __('WeWork Demo scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview WeWork Demo</a>'),
		  // translators: Publish box date format, see http://php.net/date
		  date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
		10 => sprintf( __('WeWork Demo draft updated. <a target="_blank" href="%s">Preview WeWork Demo</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
	);

	return $messages;
}

add_filter( 'post_updated_messages', 'wework_demo_updated_messages' );

//Enqueue Isotope
function enqueue_isotope() {
	wp_register_script( 'isotope', get_stylesheet_directory_uri() . '/includes/js/isotope.pkgd.min.js', array( 'jquery' ) );
	wp_enqueue_script( 'isotope' );
}

add_action( 'wp_enqueue_scripts', 'enqueue_isotope' );