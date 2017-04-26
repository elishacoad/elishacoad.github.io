<?php
/**
 * Register the required plugins for this theme.
 *
 * @since   1.0.0
 * @package Rolling
 */
// Include the TGM_Plugin_Activation class.
include ROLLING_PATH . '/core/libraries/vendors/tgmpa/class-tgmpa.php';

/**
 * Register the required plugins for this theme.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */
function rolling_register_required_plugins() {
	$plugins = array(
		array(
            'name'      => 'Contact Form 7',
            'slug'      => 'contact-form-7',
            'required'  => true,
        ),
        array(
            'name'      => 'KingComposer',
            'slug'      => 'kingcomposer',
            'required'  => true,
        ),
        array(
            'name'      => 'WP Typed JS',
            'slug'      => 'wp-typed-js/',
            'required'  => true,
        ),
	);

	$config = array(
		'id'           => 'tgmpa',
		'default_path' => '',
		'menu'         => 'install-plugins',
		'parent_slug'  => 'ui',
		'capability'   => 'manage_options',
		'has_notices'  => true,
		'dismissable'  => true,
		'dismiss_msg'  => '',
		'is_automatic' => true,
	);
	tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'rolling_register_required_plugins' );