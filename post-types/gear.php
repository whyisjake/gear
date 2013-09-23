<?php

function gear_init() {
	register_post_type( 'gear', array(
		'taxonomies'		  => array( 'category', 'post_tag' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_in_nav_menus'   => true,
		'show_ui'             => true,
		'supports'            => array( 'title', 'editor', 'custom-fields' ),
		'has_archive'         => true,
		'query_var'           => true,
		'rewrite'             => true,
		'labels'              => array(
			'name'                => __( 'Gear', 'gear' ),
			'singular_name'       => __( 'Gear', 'gear' ),
			'add_new'             => __( 'Add new gear', 'gear' ),
			'all_items'           => __( 'Gear', 'gear' ),
			'add_new_item'        => __( 'Add new gear', 'gear' ),
			'edit_item'           => __( 'Edit gear', 'gear' ),
			'new_item'            => __( 'New gear', 'gear' ),
			'view_item'           => __( 'View gear', 'gear' ),
			'search_items'        => __( 'Search gear', 'gear' ),
			'not_found'           => __( 'No gear found', 'gear' ),
			'not_found_in_trash'  => __( 'No gear found in trash', 'gear' ),
			'parent_item_colon'   => __( 'Parent gear', 'gear' ),
			'menu_name'           => __( 'Gear', 'gear' ),
		),
	) );

}
add_action( 'init', 'gear_init' );

function gear_updated_messages( $messages ) {
	global $post;

	$permalink = get_permalink( $post );

	$messages['gear'] = array(
		0 => '', // Unused. Messages start at index 1.
		1 => sprintf( __('Gear updated. <a target="_blank" href="%s">View gear</a>', 'gear'), esc_url( $permalink ) ),
		2 => __('Custom field updated.', 'gear'),
		3 => __('Custom field deleted.', 'gear'),
		4 => __('Gear updated.', 'gear'),
		/* translators: %s: date and time of the revision */
		5 => isset($_GET['revision']) ? sprintf( __('Gear restored to revision from %s', 'gear'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => sprintf( __('Gear published. <a href="%s">View gear</a>', 'gear'), esc_url( $permalink ) ),
		7 => __('Gear saved.', 'gear'),
		8 => sprintf( __('Gear submitted. <a target="_blank" href="%s">Preview gear</a>', 'gear'), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		9 => sprintf( __('Gear scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview gear</a>', 'gear'),
		// translators: Publish box date format, see http://php.net/date
		date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
		10 => sprintf( __('Gear draft updated. <a target="_blank" href="%s">Preview gear</a>', 'gear'), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
	);

	return $messages;
}
add_filter( 'post_updated_messages', 'gear_updated_messages' );