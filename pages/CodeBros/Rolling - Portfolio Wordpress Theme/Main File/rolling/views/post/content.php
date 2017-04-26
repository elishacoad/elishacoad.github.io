<?php
/**
 * The template part for displaying content.
 * 
 * @since   1.0.0
 * @package Rolling
 */
?>

<?php do_action( 'rolling_before_post' ); ?>
<div <?php post_class('col-sm-6 col-xs-12 post')?>>
	<div class="img-box-wrap details-boxed">
		<div class="img-box-banner">
	    	<div class="img-box">
              	<?php rolling_post_thumbnail(); ?>
            </div>
	    </div>
	    <div class="img-box-details">
	    	<?php rolling_post_title(); ?>
	    	<p class="date-publish"><i class="fa fa-calendar-o"></i> <?php rolling_posted_on(); ?></p>
	        <?php
				the_excerpt();
			?>
			<p><a href="<?php esc_url( the_permalink() ); ?>" aria-hidden="true"><?php _e('Read More','rolling') ?> <i class="icon icon-Goto"></i></a></p>
	    </div>
	</div>
</div>
<?php do_action( 'rolling_after_post' ); ?>