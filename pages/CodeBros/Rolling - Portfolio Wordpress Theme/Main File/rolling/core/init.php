<?php
/**
 * Initialize framework and libraries.
 *
 * @since   1.0.0
 * @package Rolling
 */

// Theme options
include ROLLING_PATH . '/core/admin/cs-framework.php';

// Vendor libraries
$libs = 'tgmpa, aq-resizer';
$libs = array_map( 'trim', explode( ',', $libs ) );
foreach ( $libs as $lib ) {
	include ROLLING_PATH . '/core/libraries/vendors/' . $lib . '/init.php';
}

// Theme libraries
include ROLLING_PATH . '/core/libraries/uipasta/hooks/action.php';
include ROLLING_PATH . '/core/libraries/uipasta/hooks/filter.php';
include ROLLING_PATH . '/core/libraries/uipasta/hooks/helper.php';