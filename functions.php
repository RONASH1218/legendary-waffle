<?php
	/**
	 * Madara Functions and Definitions
	 *
	 * @package madara
	 */
	require( get_template_directory() . '/app/theme.php' );
	//raz0r
	update_site_option( 'madara_activated', 'yes' );
	update_site_option( 'madara_purchase_code', '*********************' );
	update_site_option( 'madara_supported_until', '10.10.2040' );
/*
add_filter('wp_manga_chapter_image_url', 'replace_url_to_do_spaces', 10, 5);

function replace_url_to_do_spaces( $url, $host, $src, $post_id, $name){
	$url = str_replace(' https://mydomain.com/wp-content/uploads', ' https://cdn.mydomain.com', $url);

	return $url;
}*/