<?php
/**
 * Theme constants definition and functions.
 *
 * @since   1.0.0
 * @package Rolling
 */

// Constants definition
define( 'ROLLING_PATH', get_template_directory()     );
define( 'ROLLING_URL',  get_template_directory_uri() );

// Initialize core file
require ROLLING_PATH . '/core/init.php';