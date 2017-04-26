<?php
/**
 * The template for displaying all single posts.
 *
 * @since   1.0.0
 * @package Rolling
 */


get_header(); ?>
<div role="main" class="main">
	<div class="container">
     	<div class="row">
            <div class="col-sm-9">
				<?php while ( have_posts() ) : the_post();
					// Include the single post content template.
					get_template_part( 'views/post/content', 'single' );

					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) {
						comments_template();
					}
				endwhile; ?>
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