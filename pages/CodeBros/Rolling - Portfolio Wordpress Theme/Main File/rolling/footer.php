<?php
/**
 * The template for displaying the footer.
 *
 * @since   1.0.0
 * @package Rolling
 */
?>	
<div class="clearfix"></div>		
    <!-- Footer Start -->
    <footer class="footer-section">
        <div class="container">
            <div class="row">
		    	<div class="col-md-4 text-left">
		       		<?php
		       			if ( has_nav_menu( 'footer-menu' ) ) {
			       			wp_nav_menu(
								array(
									'theme_location' => 'footer-menu',
									'menu_class'     => 'footer-menu',
									'menu_id'        => 'footer-menu',
									'container'      => false,
									'fallback_cb'    => NULL,
									'depth'          => 1
								)
							);
						} else {
							echo '<ul class="footer-menu"><li><a target="_blank" href="' . esc_url( admin_url( 'nav-menus.php' ) ) . '">' . esc_html__( 'Add Menu', 'rolling' ) . '</a></li></ul>';
						}
		       		?>
          		</div>
           		<div class="col-md-4 text-center">
               		<p><?php
               			echo cs_get_option( 'footer-copyright' );
               		?>
               		</p>
               	</div>
             	<div class="col-md-4 uipasta-credit text-right">
             		<p><?php esc_html_e('Design By ','rolling'); ?><a href="http://www.uipasta.com" target="_blank" title="UiPasta"><?php esc_html_e('UiPasta' ,'rolling' ); ?></a></p>
                </div>
             </div>
        </div>
    </footer>
    <!-- Footer End -->

    <!-- Back to Top Start -->
    <a href="#" class="scroll-to-top"><i class="fa fa-angle-up"></i></a>
    <!-- Back to Top End -->
<?php wp_footer(); ?>
</body>
</html>