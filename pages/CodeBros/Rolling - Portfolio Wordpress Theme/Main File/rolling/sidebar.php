<?php
/**
 * The sidebar containing the main widget area.
 *
 * @since   1.0.0
 * @package Rolling
 */
// Get all sidebars
$sidebar = cs_get_option( 'blog-sidebar' );

echo '<div class="sidebar" role="complementary">';
	if ( is_active_sidebar( $sidebar ) ) {
		dynamic_sidebar( $sidebar );
	}
echo '</div>';