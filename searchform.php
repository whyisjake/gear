<?php
/**
 * The template for displaying search forms in Gear
 *
 * @package Gear
 */
?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label>
		<span class="screen-reader-text"><?php _ex( 'Search for:', 'label', 'gear' ); ?></span>
		<input type="search" class="search-field" placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'gear' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" name="s" title="<?php echo esc_attr_x( 'Search for:', 'label', 'gear' ); ?>">
	</label>
	<input type="submit" class="search-submit" value="<?php echo esc_attr_x( 'Search', 'submit button', 'gear' ); ?>">
</form>
