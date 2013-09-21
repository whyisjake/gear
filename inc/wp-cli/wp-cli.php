<?php
/**
 * gear commands for the WP-CLI framework
 *
 * @package wp-cli
 * @since 3.0
 * @see https://github.com/wp-cli/wp-cli
 */

WP_CLI::add_command( 'gear', 'GEAR_WP_CLI_Command' );

class GEAR_WP_CLI_Command extends WP_CLI_Command {
	
	/**
	 * Inserts products from the datafeed.
	 *
	 * @subcommand products
	 * 
	 */
	public function make_gear_products_import() {
		if ( file_exists( 'rei.xml' ) ) {
			$xml = simplexml_load_file('rei.xml');
		} else {
			exit('Failed to open rei.xml.');
		}

		$products = $xml->Product;

		foreach ($products as $product) {
			$post = array(
				'post_title'    => $product['title'],
				'post_name'		=> $product['name'],
				'post_type'  	=> 'gear',
				'post_status'   => 'publish',
				'post_author'   => 0,
			);
			$post_id = wp_insert_post( $post );
			if ( $post_id ) {
				WP_CLI::line( get_the_title( $post_id ) );
			}
			// $title = get_the_title( $post_id );
			// WP_CLI::line('☆.。.:*・°☆.。.:*・°☆.。.:*・°☆.。.:*・°☆');
			// if ( !$post_id ) {
			// 	WP_CLI::warning( "Couldn't insert post... Sorry about that." );
			// } else {
			// 	WP_CLI::success( "Inserted product: " . $title  );
			// }
			// $meta_id = update_post_meta( $post_id, 'url', esc_url( $product['url'] ) );
			// if ( !$meta_id ) {
			// 	WP_CLI::warning( "Didn't add the URL meta..." );
			// } else {
			// 	WP_CLI::success( "Added " . $product['url'] . " to " . $title );
			// }
			// $bitly = make_bitly_url( esc_url_raw ($product['url'] ) );
			// $bitlyurl = update_post_meta( $post_id, 'bitly_url', $bitly );
			// if ( !$bitlyurl ) {
			// 	WP_CLI::warning( "Didn't add the Bit.ly URL meta..." );
			// } else {
			// 	WP_CLI::success( "Added a shorturl of " . $bitly . " to " . $title );
			// }
			// WP_CLI::line('');
		}
	}
}
