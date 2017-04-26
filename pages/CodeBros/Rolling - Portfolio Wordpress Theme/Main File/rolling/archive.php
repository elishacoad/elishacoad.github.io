<?php
/**
 * The template for displaying archive pages.
 *
 * @since   1.0.0
 * @package Rolling
 */

get_header(); ?>

<div role="main" class="main">
	<div class="container">
     	<div class="row">
            <div class="col-sm-9">
				<div class="category-description">
					<?php
						the_archive_title( '<h1 class="page-title">', '</h1>' );
						the_archive_description( '<div class="taxonomy-description">', '</div>' );
					?>
				</div>
            	
				<?php
					if ( have_posts() ) :
				?>
				<div class="uip-masonry">
                	<div class="grid-sizer"></div>
					<?php
							while ( have_posts() ) : the_post();
								get_template_part( 'views/post/content', get_post_format() );
							endwhile;
					?>
				</div>
				<?php
					else :
						get_template_part( 'views/post/content', 'none' );
					endif;
				?>
				
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