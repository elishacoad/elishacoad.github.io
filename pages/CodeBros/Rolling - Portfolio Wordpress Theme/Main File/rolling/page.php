<?php
/**
 * The template for displaying all pages.
 *
 * @since   1.0.0
 * @package Rolling
 */
get_header(); ?>
<div role="main" class="main">
	<div class="container">
     	<div class="row">
            <div class="col-sm-9">
            	<div class="freebie-page uipasta-box-shadow">
					<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
					<?php while ( have_posts() ) : the_post();
						the_content();
					endwhile; ?>
            	</div>
			</div>
         	<div class="col-sm-3 sidebar">
          		<div class="margin-solution"></div>
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