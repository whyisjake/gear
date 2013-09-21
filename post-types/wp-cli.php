<?php
/**
 * gear commands for the WP-CLI framework
 *
 * @package wp-cli
 * @since 3.0
 * @see https://github.com/wp-cli/wp-cli
 */

WP_CLI::add_command( 'gear', 'MAKE_WP_CLI_Command' );

class MAKE_WP_CLI_Command extends WP_CLI_Command {
	
	/**
	 * Inserts the Go: Redirects
	 *
	 * @subcommand go
	 * 
	 */
	public function make_go_links_import() {
		include_once 'rei.xml';
		foreach ($redirects as $redirect) {
			$post = array(
				'post_title'    => $redirect['title'],
				'post_name'		=> $redirect['name'],
				'post_type'  	=> 'go',
				'post_status'   => 'publish',
				'post_author'   => 0,
			);
			$post_id = wp_insert_post( $post );
			$title = get_the_title( $post_id );
			WP_CLI::line('☆.。.:*・°☆.。.:*・°☆.。.:*・°☆.。.:*・°☆');
			if ( !$post_id ) {
				WP_CLI::warning( "Couldn't insert post... Sorry about that." );
			} else {
				WP_CLI::success( "Inserted redirect: " . $title  );
			}
			$meta_id = update_post_meta( $post_id, 'url', esc_url( $redirect['url'] ) );
			if ( !$meta_id ) {
				WP_CLI::warning( "Didn't add the URL meta..." );
			} else {
				WP_CLI::success( "Added " . $redirect['url'] . " to " . $title );
			}
			$bitly = make_bitly_url( esc_url_raw ($redirect['url'] ) );
			$bitlyurl = update_post_meta( $post_id, 'bitly_url', $bitly );
			if ( !$bitlyurl ) {
				WP_CLI::warning( "Didn't add the Bit.ly URL meta..." );
			} else {
				WP_CLI::success( "Added a shorturl of " . $bitly . " to " . $title );
			}
			WP_CLI::line('');
		}
	}
}
