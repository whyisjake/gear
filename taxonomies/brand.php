<?php

function brand_init() {
	register_taxonomy( 'brand', array( 'gear' ), array(
		'hierarchical'            => false,
		'public'                  => true,
		'show_in_nav_menus'       => true,
		'show_ui'                 => true,
		'query_var'               => true,
		'rewrite'                 => true,
		'capabilities'            => array(
			'manage_terms'  => 'edit_posts',
			'edit_terms'    => 'edit_posts',
			'delete_terms'  => 'edit_posts',
			'assign_terms'  => 'edit_posts'
		),
		'labels'                  => array(
			'name'                       =>  __( 'Brands', 'gear' ),
			'singular_name'              =>  __( 'Brand', 'gear' ),
			'search_items'               =>  __( 'Search brands', 'gear' ),
			'popular_items'              =>  __( 'Popular brands', 'gear' ),
			'all_items'                  =>  __( 'All brands', 'gear' ),
			'parent_item'                =>  __( 'Parent brand', 'gear' ),
			'parent_item_colon'          =>  __( 'Parent brand:', 'gear' ),
			'edit_item'                  =>  __( 'Edit brand', 'gear' ),
			'update_item'                =>  __( 'Update brand', 'gear' ),
			'add_new_item'               =>  __( 'New brand', 'gear' ),
			'new_item_name'              =>  __( 'New brand', 'gear' ),
			'separate_items_with_commas' =>  __( 'Brands separated by comma', 'gear' ),
			'add_or_remove_items'        =>  __( 'Add or remove brands', 'gear' ),
			'choose_from_most_used'      =>  __( 'Choose from the most used brands', 'gear' ),
			'menu_name'                  =>  __( 'Brands', 'gear' ),
		),
	) );

}
add_action( 'init', 'brand_init' );
