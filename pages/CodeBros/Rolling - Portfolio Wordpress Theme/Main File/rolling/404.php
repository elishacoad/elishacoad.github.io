<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @since   1.0.0
 * @package Rolling
 */
get_header(); ?>

<div role="main" class="main page-not-found">
	<section class="typo-dark bg-grey">
		<div class="container">
         	<div class="row">
                <div class="col-sm-8">
                	<div class="error-page-result">
						<h1>It's a 404 Error, <span>Page Not Found</span></h1>
						<h3>Here is Why You Seeing 404 Error?</h3>
						<ul class="list-icon size-sm">
							<li>May be, The page you are looking for might have been removed or Name has been changed.</li>
							<li>May be, You did typed wrong keyword that page doesn't exist.</li>
							<li>May be, The link is temporarily unavailable.</li>
						</ul>
						<h3 class="margin-top-30">But Don't Worry, Please try the following</h3>
						<ul class="list-icon size-sm">
							<li>Try to <a href="#" class="btn_header_search">search</a> other similar item.</li>
							<li>Or Go to our <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home Page</a> to find new high quality freebie item</li>
						</ul>
                  </div>
				</div>
             	<div class="col-sm-4">
              		<div class="margin-solution"></div>
              		<?php if ( is_active_sidebar( 'primary-sidebar' ) ) : ?>
						<?php
							if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('primary-sidebar') ) :
						endif; ?>
				    <?php endif; ?>
              	</div>
			</div>
		</div>
	</section>
</div>


<?php get_footer(); ?>