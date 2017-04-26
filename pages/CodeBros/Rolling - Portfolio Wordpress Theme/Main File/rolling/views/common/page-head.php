<?php
/**
 * The heading of page.
 *
 * @since   1.0.0
 * @package Rolling
 */

// Get page options
$options = get_post_meta( get_the_ID(), '_custom_page_options', true );

if ( isset( $options['pagehead'] ) && ! $options['pagehead'] ) return;

if ( is_single() ) {

	echo rolling_head_single();

} else {

	echo rolling_head_page();

}