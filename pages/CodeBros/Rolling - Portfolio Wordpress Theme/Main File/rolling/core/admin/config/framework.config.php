<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.
// ===============================================================================================
// -----------------------------------------------------------------------------------------------
// FRAMEWORK SETTINGS
// -----------------------------------------------------------------------------------------------
// ===============================================================================================
$type = 'add_submenu';
$settings = array(
	'menu_title'  => esc_html__( 'Theme Options', 'rolling' ),
	'menu_parent' => 'ui',
	'menu_type'   => $type . '_page',
	'menu_slug'   => 'theme-options',
	'ajax_save'   => true,
);

// Get list all menu
$menus = wp_get_nav_menus();
$menu  = array();
if ( $menus ) {
	foreach ( $menus as $key => $value ) {
		$menu[$value->term_id] = $value->name;
	}
}

// ===============================================================================================
// -----------------------------------------------------------------------------------------------
// FRAMEWORK OPTIONS
// -----------------------------------------------------------------------------------------------
// ===============================================================================================
$options = array();

// ----------------------------------------
// a option section for options layout    -
// ----------------------------------------
$options[] = array(
	'name'  => 'layout',
	'title' => esc_html__( 'General Layout', 'rolling' ),
	'icon'  => 'fa fa-dashboard',
	'fields' => array(
		array(
			'id'        => 'logo',
			'type'      => 'image',
			'title'     => esc_html__( 'Logo', 'rolling' ),
			'add_title' => esc_html__( 'Upload', 'rolling' ),
		),
		array(
			'id'      => 'footer-copyright',
			'type'    => 'textarea',
			'title'   => esc_html__( 'Copyright Text', 'rolling' ),
			'desc'    => esc_html__( 'HTML is allowed', 'rolling' ),
			'default' => sprintf( wp_kses_post( '&copy; Copyright 2017 Rolling', 'rolling' ), esc_url( home_url() ) )
		),
		array(
			'id'       => 'custom-css',
			'type'     => 'textarea',
			'title'    => esc_html__( 'Custom CSS Style', 'rolling' ),
			'desc'     => esc_html__( 'Paste your CSS code here. Do not place any &lt;style&gt; tags in these areas as they are already added for your convenience', 'rolling' ),
			'sanitize' => 'html'
		),
		array(
			'id'       => 'custom-js',
			'type'     => 'textarea',
			'title'    => esc_html__( 'Custom JS Code', 'rolling' ),
			'desc'     => esc_html__( 'Paste your Javscript code here. You can add your Google Analytics Code here. Do not place any &lt;script&gt; tags in these areas as they are already added for your convenience.', 'rolling' ),
			'sanitize' => 'html'
		),
	),
);

// ----------------------------------------
// a option section for options typography-
// ----------------------------------------
$options[] = array(
	'name'  => 'typography',
	'title' => esc_html__( 'Typography', 'rolling' ),
	'icon'  => 'fa fa-font',
	'fields' => array(
		array(
			'type'    => 'subheading',
			'content' => esc_html__( 'Body Font Settings', 'rolling' ),
		),
		array(
			'id'        => 'body-font',
			'type'      => 'typography',
			'title'     => esc_html__( 'Font Family', 'rolling' ),
			'default'   => array(
				'family'  => 'Poppins',
				'font'    => 'google',
				'variant' => 'regular',
			),
		),
		array(
			'id'      => 'body-font-size',
			'type'    => 'number',
			'title'   => esc_html__( 'Font Size', 'rolling' ),
			'after'   => ' <i class="cs-text-muted">px</i>',
			'default' => 14
		),
		array(
			'type'    => 'subheading',
			'content' => esc_html__( 'Heading Font Settings', 'rolling' ),
		),
		array(
			'id'        => 'heading-font',
			'type'      => 'typography',
			'title'     => esc_html__( 'Font Family', 'rolling' ),
			'default'   => array(
				'family'  => 'Poppins',
				'font'    => 'google',
				'variant' => '600',
			),
		),
		array(
			'id'      => 'h1-font-size',
			'type'    => 'number',
			'title'   => esc_html__( 'H1 Font Size', 'rolling' ),
			'after'   => ' <i class="cs-text-muted">px</i>',
			'default' => '48'
		),
		array(
			'id'      => 'h2-font-size',
			'type'    => 'number',
			'title'   => esc_html__( 'H2 Font Size', 'rolling' ),
			'after'   => ' <i class="cs-text-muted">px</i>',
			'default' => '36'
		),
		array(
			'id'      => 'h3-font-size',
			'type'    => 'number',
			'title'   => esc_html__( 'H3 Font Size', 'rolling' ),
			'after'   => ' <i class="cs-text-muted">px</i>',
			'default' => '24'
		),
		array(
			'id'      => 'h4-font-size',
			'type'    => 'number',
			'title'   => esc_html__( 'H4 Font Size', 'rolling' ),
			'after'   => ' <i class="cs-text-muted">px</i>',
			'default' => '21'
		),
		array(
			'id'      => 'h5-font-size',
			'type'    => 'number',
			'title'   => esc_html__( 'H5 Font Size', 'rolling' ),
			'after'   => ' <i class="cs-text-muted">px</i>',
			'default' => '18'
		),
		array(
			'id'      => 'h6-font-size',
			'type'    => 'number',
			'title'   => esc_html__( 'H6 Font Size', 'rolling' ),
			'after'   => ' <i class="cs-text-muted">px</i>',
			'default' => '16'
		),
	),
);


// ------------------------------
// backup                       -
// ------------------------------
$options[]   = array(
	'name'     => 'backup_section',
	'title'    => 'Backup',
	'icon'     => 'fa fa-hdd-o',
	'fields'   => array(
		array(
			'type'    => 'notice',
			'class'   => 'warning',
			'content' => esc_html__( 'You can save your current options. Download a Backup and Import.', 'rolling' ),
		),
		array(
			'type'    => 'backup',
		),
  	)
);


// ------------------------------
// backup                       -
// ------------------------------
$options[]   = array(
	'name'     => 'support_section',
	'title'    => 'Support',
	'icon'     => 'fa fa-support',
	'fields'   => array(
		array(
			'type'    => 'subheading',
			'content' => esc_html__( 'Support', 'rolling' ),
		),
		array(

			'type'    => 'content',
			'class'   => 'warning',
			'content' => 'We support all our freebies, If you need any kind of help so do not hesitate to contact us - Please visit our <strong><a href="http://www.uipasta.com/support/" target="_blank">support  page</a></strong>',
		),
  	)
);


// ----------------------------------------
// a option section for options about    -
// ----------------------------------------
$options[] = array(
	'name'  => 'About',
	'title' => esc_html__( 'About', 'rolling' ),
	'icon'  => 'fa fa-user',
	'fields' => array(
		array(
			'type'    => 'content',
			'content' => '
				<h3>About Us</h3>
				<p style="line-height: 22px;"><strong><a href="http://www.uipasta.com/" target="_blank" style="text-decoration: none">UiPasta</a></strong> is a place where we share and distribute our handcrafted design and development works completely free. We are passionate about creating high quality freebie resources for designer and developer community. Our mission is to make the web world more beautiful and attractive place, That is why we build <strong><a href="http://www.uipasta.com/" target="_blank" style="text-decoration: none">UiPasta</a></strong><br/><br/></p> 
				<p style="line-height: 22px;">We release new freebies every week so Do not forget to subscribe our free newsletter, When you subscribe to our newsletter so We will directly send you our new freebies release at your mail - <strong><a href="http://eepurl.com/cyczJj" target="_blank" style="color: red;">Subscribe now</a></strong></p>',
		),
		array(
			'type'    => 'content',
			'content' => '
					<h3>We are available for freelance work</h3>
					<p>Please send your work requirement at <strong><a href="mailto:uipasta@gmail.com" target="_blank" style="text-decoration: none">uipasta@gmail.com</a></p>',
		),
		array(
			'type'    => 'content',
			'content' => '
					<h3>Follow us on your favourite social media channels</h3>
					<p class="socials">
						<a href="https://web.facebook.com/UiPasta/" target="_blank" title="facebook"><i class="fa fa-facebook"></i></a>
						<a class="twitter" href="https://twitter.com/uipasta" target="_blank" title="twitter"><i class="fa fa-twitter"></i></a>
						<a class="google-plus" href="https://plus.google.com/109614950844616154494" target="_blank" title="google+"><i class="fa fa-google-plus"></i></a>
					</p>',
		),
	)
);

CSFramework::instance( $settings, $options );
