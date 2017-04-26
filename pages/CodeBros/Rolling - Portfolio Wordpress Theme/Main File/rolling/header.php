<?php
/**
 * The header for our theme.
 *
 * @since   1.0.0
 * @package Rolling
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo( 'charset' ); ?>"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
        <link rel="apple-touch-icon" sizes="129x129" href="<?php echo ROLLING_URL.'/assets/images/apple-touch-icon.png';?>">
		<?php wp_head(); ?>
	</head>
	<body <?php body_class(); ?>>
		<!-- Preloader Start -->
	    <div id="preloader">
			<div class="loader"></div>
	    </div>
	    <!-- Preloader End -->

	    <!-- Home & Menu Section Start -->
	    <header id="header" class="header" itemscope="itemscope" itemtype="http://schema.org/WPHeader">  
	        <div class="header-top-area">
	            <div class="container">
	                <div class="row">
	                    <div class="col-sm-3">
	                        <div class="logo">
	                            <?php rolling_logo(); ?>
	                        </div>
	                    </div>
	                    
	                    <div class="col-sm-9">
	                        <div class="navigation-menu">
	                            <div class="navbar">
	                                <div class="navbar-header">
	                                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
	                                        <span class="sr-only"><?php _e('Toggle navigation','rolling'); ?></span>
	                                        <span class="icon-bar"></span>
	                                        <span class="icon-bar"></span>
	                                        <span class="icon-bar"></span>
	                                    </button>
	                                </div>
	                                <div class="navbar-collapse collapse">
                                        <?php
											if ( has_nav_menu( 'primary-menu' ) ) {	
												wp_nav_menu(
													array(
														'theme_location' => 'primary-menu',
														'menu_class'     => 'nav navbar-nav navbar-right',
														'menu_id'        => 'mainMenu',
														'container'      => false,
														'fallback_cb'    => NULL
													)
												);
											} else {
												echo '<ul class="nav navbar-nav navbar-right"><li><a target="_blank" href="' . esc_url( admin_url( 'nav-menus.php' ) ) . '">' . esc_html__( 'Create Primary Menu', 'rolling' ) . '</a></li></ul>';
											}
										?>
	                                </div>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </header>
	    <!-- Home & Menu Section End-->
			
			
			
