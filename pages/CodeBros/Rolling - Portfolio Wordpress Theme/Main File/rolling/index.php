<?php
/**
 * The main template file.
 *
 * @since   1.0.0
 * @package Rolling
 */

get_header(); ?>

<div role="main" class="main">
	<div class="container">
     	<div class="row">
            <div class="col-sm-9">
            	<div class="uip-masonry">
                	<div class="grid-sizer"></div>
					<?php
						if ( have_posts() ) :
							while ( have_posts() ) : the_post();
								get_template_part( 'views/post/content', get_post_format() );
							endwhile;
						else :
							get_template_part( 'views/post/content', 'none' );
						endif;
					?>
				</div>
				<?php rolling_pagination(); ?>
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
<?php get_footer(); ?>