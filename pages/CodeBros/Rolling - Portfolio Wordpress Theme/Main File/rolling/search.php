<?php
/**
 * The template for displaying search results pages.
 *
 * @since   1.0.0
 * @package Rolling
 */


get_header();?>
<div role="main" class="main">
	<div class="container">
     	<div class="row">
            <div class="col-sm-9">
            	<div class="page-not-found">
						<?php
							if ( have_posts() ) :
						?>
						<div class="search-result">
                			<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'rolling' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
                		</div>
	                	<div class="jas-masonry">
		                	<div class="grid-sizer"></div>
							<?php
									while ( have_posts() ) : the_post();
										get_template_part( 'views/post/content', get_post_format() );
									endwhile;
							?>
						</div>
						<?php rolling_pagination(); ?>
						<?php
							else :
								get_template_part( 'views/post/content', 'none' );
							endif;
						?>
					
					
				</div>
			</div>
         	<div class="col-sm-3 sidebar">
          		<?php if ( is_active_sidebar( 'primary-sidebar' ) ) : ?>
					<?php
						if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('primary-sidebar') ) :
					endif; ?>
			    <?php endif; ?>
          	</div>
		</div>
	</div>
</div>
<?php get_footer();