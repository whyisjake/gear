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
		WP_CLI::line( 'GO!' );
		$rei = file_get_contents( get_stylesheet_directory_uri() . '/inc/wp-cli/rei.xml' );
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
				WP_CLI::success( get_the_title( $id ) );
			} elseif ( is_wp_error( $id ) ) {
				WP_CLI::warning( $products->Product_Name );
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
			WP_CLI::line('Setting up ' . get_the_title( $id ) );
			WP_CLI::line('| Post ID ' . $id );
			// WP_CLI::line('| Post SKU' . ( $sku ) ? get_post_meta( $id, 'SKU', true ) : 'Nope...' );
			foreach ( $keys as $key ) {
				WP_CLI::line( '| ' . $key );
				WP_CLI::line( '| ' . $products->$key );
				$meta = ( !empty( $products->$key ) ) ? add_post_meta( $id, $key, (string) $products->$key ) : null;
				// $meta = update_post_meta( $id, $key, $products->$key, true );
				if ( $meta ) {
					WP_CLI::success( $products->$key );
				} else {
					WP_CLI::warning( 'Didn\'t add ' . $key );
				}
			}

		}
	}

	/**
	 * Delete all of the Makers in the makers custom post type
	 *
	 * @subcommand mjolnir
	 * 
	 */
	public function mf_delete_makers( $args, $assoc_args ) {

		WP_CLI::line( ' 
                                                  zee.                      
        z**=.                                  .P"  $                       
         %   ^c                               z"   $                        
          b    %                             d    4"                        
          4     $            ....           4"    $                         
           F     L       .P"       "%.      $     $                         
           $     4     e"             "c    "     $                         
           $      F  z"                 *  4      $                         
           P      $ d                    3.$      $                         
           %      $d       ..eeeec..      *$      \'b                        
          d       $%   .e$*c d" ".z**$%.   $       $                        
          F       $  e" $   *F   $   ^F.db.$        b                       
         J        $d\" ^$   4b   $    $  3/$        *                       
         $        $*$   $c  P *P" * ."F  .$$         b                      
        4F        $ $c .EeP""      ^C$$..*F F        $                      
        J         $ $.*"-"*.      ."    "b$ F        \'r                     
        $         *"$   zc. ..  -"..-""\  $$%         $                     
        $          $      ..  L P  ebe    4$          $                     
        $          ^F   d%*$J%3 $ *$* "   4F          $                     
        *          4b       @   3 ^r      4$          $                     
        4          d$.          4         $3.        4F                     
         L         $$*.                  %$ $        J                      
         $        d $ $      -   ^.     P $c $       $                      
          r      z".$L L    .$%..*$    J  $P. *.    d                       
          "     z" P$$ ^%  z"      ".  L d$$"c "e  z%                       
           *  .P .*$$$  "*"   .$c        $$$$.b  ^$"                        
            *$  dL$$$$r ^4. ./" ""%..r"  $$$$$$J$e"                         
             *$b$$$$$$F        ""        $$$$$$$P                           
              ^$$$$$$$$                  $$$$$"                             
                 "*$$$$                  $"                                 
                      \'                 4                                   
                       *  $         .$  F                                   
                        % 4F       .$  "                                    
                          *$%     .$dr                                      
                            *.    .*                                        
                              ".." ' );

		$args = array(
			'posts_per_page' => 2000,
			'post_type' => 'gear',
			'post_status' => 'any',

			// Prevent new posts from affecting the order
			'orderby' => 'ID',
			'order' => 'ASC',

			// Speed this up
			'no_found_rows' => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
		);

		// Get the first set of posts
		$query = new WP_Query( $args );

		while ( $query->have_posts() ) : $query->the_post();
		
		$title = get_the_title( get_the_ID() );

		$del = wp_delete_post( get_the_ID() );

		if ( $del ) {
			WP_CLI::success( 'Deleted ' . $title );
		} else {
			WP_CLI::warning( 'Failed to delete ' . $title );
		}
		endwhile;
	}
}
