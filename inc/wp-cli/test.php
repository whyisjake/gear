<html><body>
<?php
include '../../../../../wp-load.php';
function make_gear_products_import() {
	echo( 'GO!' );
	$rei = file_get_contents( 'rei.xml' );
	$xml = simplexml_load_string( $rei );
	foreach ($xml->Product as $products ) {
		$post = array(
			'post_title'    => $products->Product_Name,
			'post_type'  	=> 'gear',
			'post_status'   => 'publish',
			'post_author'   => 0,
			'post_content'	=> $products->Long_Description,
			'post_excerpt'	=> $products->Short_Description,
		);

		$id = wp_insert_post( $post );

		if ( $id ) {
			echo( get_the_title( $id ) );
		} elseif ( is_wp_error( $id ) ) {
			echo( $products->Product_Name );
		}

		$terms = wp_set_object_terms( $id, array( $products->Category, $products->SubCategory ), 'category', true );

		$keys = array( 'SKU',
			'Manufacturer_Id',
			'Brand_Name',
			'Thumb_URL',
			'Medium_Image_URL',
			'Image_URL',
			'Buy_Link',
			'Retail_Price',
			'Sale_Price',
			'Brand_Page_Link',
			'Brand_Logo_Image',
			'Product_Page_View_Tracking',
			'Product_Content_Widget',
			'Google_Categorization'
			);
		echo('Setting up ' . get_the_title( $id ) );
		echo('| Post ID ' . $id );
		// echo('| Post SKU' . ( $sku ) ? get_post_meta( $id, 'SKU', true ) : 'Nope...' );
		foreach ( $keys as $key ) {
			echo( '| ' . $key );
			echo( '| ' . $products->$key );
			$meta = ( !empty( $products->$key ) ) ? add_post_meta( $id, $key, (string) $products->$key ) : null;
			// $meta = update_post_meta( $id, $key, $products->$key, true );
			if ( $meta ) {
				echo( $products->$key );
			} else {
				echo( 'Didn\'t add ' . $key );
			}
		}

	}
}

make_gear_products_import();