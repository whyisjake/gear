<html><body>
<?php
$rei = file_get_contents( 'rei.xml' );
$xml = simplexml_load_string( $rei );
foreach ($xml as $product ) {
	WP_CLI::line( $product->Product_Name );
}