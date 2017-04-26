<?php
/**
 * Custom template tags.
 *
 * @since   1.0.0
 * @package Rolling
 */

/**
 * Render logo.
 *
 * @return string
 */
if ( ! function_exists( 'rolling_logo' ) ) {
	function rolling_logo() {
		$output = '';
			$output .= '<a href="' . esc_url( home_url( '/' ) ) . '">';
				if ( cs_get_option( 'logo' ) ) {
					$logo = wp_get_attachment_image_src( cs_get_option( 'logo' ), 'full', true );
					$output .= '<img class="regular-logo" data-sticky-width="119" data-sticky-height="24" src="' . esc_url( $logo[0] ) . '" width="119" height="24" alt="' . get_bloginfo( 'name' ) . '" />';
				} else {
					$output .= '<img class="regular-logo" data-sticky-width="119" data-sticky-height="24" src="' . ROLLING_URL . '/assets/images/logo.png' . '" width="119" height="24" alt="' . get_bloginfo( 'name' ) . '" />';
				}
			$output .= '</a>';

		echo apply_filters( 'rolling_logo', $output );
	}
}

/**
 * Prints HTML with meta information for the current post-date/time and author.
 *
 * @return string
 */
if ( ! function_exists( 'rolling_posted_on' ) ) {
	function rolling_posted_on() {
		$output = '';
		$time = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

		$output .= sprintf( $time,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_url( get_permalink() )
		);

		echo apply_filters( 'rolling_posted_on',  $output  );
	}
}

/**
 * Prints post title.
 *
 * @return string
 */
if ( ! function_exists( 'rolling_post_title' ) ) {
	function rolling_post_title( $link = true ) {
		$output = '';

		if ( $link ) {
			$output .= sprintf( '<h4 class="title"><a class="chp" href="%2$s" rel="bookmark">%1$s</a></h4>', get_the_title(), esc_url( get_permalink() ) );
		} else {
			$output .= sprintf( '<h4 class="title">%s</h4>', get_the_title() );
		}
		echo apply_filters( 'rolling_post_title', $output );
	}
}

/**
 * Prints post meta with the post author, categories and post comments.
 *
 * @return string
 */
if ( ! function_exists( 'rolling_post_meta' ) ) {
	function rolling_post_meta() {
		$output = '';
		// Post author
		$output .= sprintf(
			esc_html__( '%1$s', 'rolling' ),
			'<span class="author vcard pr"><i class="fa fa-user"></i> ' . esc_html__( 'By ', 'rolling' ) . '<a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		// Post categories
		$categories = get_the_category_list( esc_html__( ', ', 'rolling' ) );
		if ( $categories ) {
			$output .= sprintf(
				'<span class="cat pr"><i class="fa fa-folder-open"></i> ' . esc_html__( 'In %1$s', 'rolling' ) . '</span>', $categories 
			);
		}

		// Post comments
		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			$output .= sprintf( '<span class="comment-number pr"><i class="fa fa-comments"></i> ' . esc_html__( 'Comments ', 'rolling' ) . '<a href="%2$s">' . esc_html__( '%1$s', get_comments_number(), 'rolling' ) . '</a></span>', number_format_i18n( get_comments_number() ), get_comments_link() );
		}

		echo apply_filters( 'rolling_post_title', $output );
	}
}

/**
 * Render post categories.
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'rolling_get_categories' ) ) :
	function rolling_get_categories() {
		$output = '';

		// Get the tag list
		$categories_list = get_the_category_list( '', esc_html__( ', ', 'rolling' ) );
		if ( $categories_list ) {
			$output .= sprintf( '<div class="post-tags"><i class="fa fa-folder-open"></i> ' . esc_html__( '%1$s', 'rolling' ) . '</div>', $categories_list );
		}
		return apply_filters( 'rolling_get_categories', $output );
	}
endif;


/**
 * Render post tags.
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'rolling_get_tags' ) ) :
	function rolling_get_tags() {
		$output = '';

		// Get the tag list
		$tags_list = get_the_tag_list( '', esc_html__( ', ', 'rolling' ) );
		if ( $tags_list ) {
			$output .= sprintf( '<div class="post-tags"><i class="fa fa-tags"></i> ' . esc_html__( '%1$s', 'rolling' ) . '</div>', $tags_list );
		}
		return apply_filters( 'rolling_get_tags', $output );
	}
endif;

/**
 * Display an optional post thumbnail.
 *
 * Wraps the post thumbnail in an anchor element on index views, or a div
 * element when on single views.
 *
 * @return string
 */
if ( ! function_exists( 'rolling_post_thumbnail' ) ) {
	function rolling_post_thumbnail() {
		if ( post_password_required() || is_attachment() ) {
			return;
		}
		?>	
			<?php if ( has_post_thumbnail() ) : ?>
				<a href="<?php esc_url( the_permalink() ); ?>" aria-hidden="true">
					<?php the_post_thumbnail( 'post-thumbnail', array( 'alt' => get_the_title() ) ); ?>
				</a>
			<?php endif; ?>
		<?php
	}
}

/**
 * Display navigation to next/previous set of posts when applicable.
 *
 * @return string
 */
if ( ! function_exists( 'rolling_pagination' ) ) {
	function rolling_pagination( $nav_query = false ) {

		global $wp_query, $wp_rewrite;

		// Don't print empty markup if there's only one page.
		if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
			return;
		}

		// Prepare variables
		$query        = $nav_query ? $nav_query : $wp_query;
		$max          = $query->max_num_pages;
		$current_page = max( 1, get_query_var( 'paged' ) );
		$big          = 999999;
		?>
		<nav class="text-center" role="navigation">
			<?php
				echo '' . paginate_links(
					array(
						'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
						'format'    => '?paged=%#%',
						'current'   => $current_page,
						'total'     => $max,
						'type'      => 'list',
						'prev_text' => esc_html__( '&larr; Prev', 'rolling' ),
						'next_text' => esc_html__( 'Next &rarr;', 'rolling' ),
					)
				) . ' ';
			?>
		</nav><!-- .page-nav -->
		<?php
	}
}

/**
 * Create a breadcrumb menu.
 *
 * @return string
 */
if ( ! function_exists( 'rolling_breadcrumb' ) ) {
	function rolling_breadcrumb() {
		// Settings
		$sep   = '<i class="fa fa-angle-right"></i>';
		$home  = esc_html__( 'Home', 'rolling' );
		$blog  = esc_html__( 'Blog', 'rolling' );
		$shop  = esc_html__( 'Shop', 'rolling' );
		 
		// Get the query & post information
		global $post, $wp_query;

		// Get post category
		$category = get_the_category();

		$output = '';
		 
		// Build the breadcrums
		$output .= '<div class="jas-breadcrumb pt__15 pb__15">';
			$output .= '<div class="jas-container">';
				$output .= '<ul class="oh">';
					$output .= '<li class="fl home"><a href="' . esc_url( get_home_url() ) . '" title="' . esc_attr( $home ) . '">' . $home . '</a></li>';
					$output .= '<li class="fl separator"> ' . $sep . ' </li>';
				 
					// Do not display on the homepage
					if ( ! is_front_page() ) {

						if ( is_home() ) {
							
							// Home page
							$output .= '<li class="fl separator"> ' . $blog . ' </li>';

						} elseif ( is_post_type_archive() ) {

							$post_type = get_post_type_object( get_post_type() );
							$output .= '<li class="fl current">' . $post_type->labels->singular_name . '</li>';

						} elseif ( is_tax() ) {

							$term = $GLOBALS['wp_query']->get_queried_object();
							$output .= '<li class="fl current">' . $term->name . '</li>';

						} elseif ( is_single() ) {
							if ( is_singular( 'jhelp-kb' ) ) {

								$output .= '<li class="fl"><a href="' . get_post_type_archive_link( 'jhelp-kb' ) . '">' . esc_html__( 'Knowledge Base', 'rolling' ) . '</a></li>';
								$output .= '<li class="fl separator"> ' . $sep . ' </li>';
								$output .= '<li class="fl current">' . get_the_title() . '</li>';

							} else {
								$output .= '<li class="fl"><a href="' . get_permalink( get_option( 'page_for_posts' ) ) . '">' . esc_html__( 'Blog', 'rolling' ) . '</a></li>';
								$output .= '<li class="fl separator"> ' . $sep . ' </li>';

								// Single post (Only display the first category)
								if ( ! empty( $category ) ) {
									$output .= '<li class="fl"><a href="' . esc_url( get_category_link( $category[0]->term_id ) ) . '" title="' . esc_attr( $category[0]->cat_name ) . '">' . $category[0]->cat_name . '</a></li>';
								}
								
								$output .= '<li class="fl separator"> ' . $sep . ' </li>';
								$output .= '<li class="fl current">' . get_the_title() . '</li>';
							}
							 
						} elseif ( is_category() ) {
							$output .= '<li class="fl"><a href="' . get_permalink( get_option( 'page_for_posts' ) ) . '">' . esc_html__( 'Blog', 'rolling' ) . '</a></li>';
							$output .= '<li class="fl separator"> ' . $sep . ' </li>';

							$thisCat = get_category( get_query_var( 'cat' ), false );
							if ( $thisCat->parent != 0 ) echo get_category_parents( $thisCat->parent, TRUE, ' ' );

							// Category page
							$output .= '<li class="fl current">' . single_cat_title( '', false ) . '</li>';
							 
						} elseif ( is_page() ) {

							// Standard page
							if ( $post->post_parent ) {
								 
								// If child page, get parents 
								$anc = get_post_ancestors( $post->ID );
								 
								// Get parents in the right order
								$anc = array_reverse($anc);
								 
								// Parent page loop
								foreach ( $anc as $ancestor ) {
									$parents = '<li class="fl"><a href="' . esc_url( get_permalink( $ancestor ) ) . '" title="' . esc_attr( get_the_title( $ancestor ) ) . '">' . get_the_title( $ancestor ) . '</a></li>';
									$parents .= '<li class="fl separator"> ' . $sep . ' </li>';
								}
								 
								// Display parent pages
								$output .= $parents;
								 
								// Current page
								$output .= '<li class="fl current"> ' . get_the_title() . '</li>';
								 
							} else {
								 
								// Just display current page if not parents
								$output .= '<li class="fl current"> ' . get_the_title() . '</li>';
								 
							}
							 
						} elseif ( is_tag() ) {
							 
							// Tag page
							 
							// Get tag information
							$term_id  = get_query_var( 'tag_id' );
							$taxonomy = 'post_tag';
							$args     = 'include=' . $term_id;
							$terms    = get_terms( $taxonomy, $args );
							 
							// Display the tag name
							$output .= '<li class="fl current">' . $terms[0]->name . '</li>';
						 
						} elseif ( is_day() ) {
							 
							// Day archive
							 
							// Year link
							$output .= '<li class="fl"><a href="' . esc_url( get_year_link( get_the_time( 'Y' ) ) ) . '" title="' . esc_attr( get_the_time( 'Y' ) ) . '">' . get_the_time( 'Y' ) . esc_html__( ' Archives', 'rolling' ) . '</a></li>';
							$output .= '<li class="fl separator"> ' . $sep . ' </li>';
							 
							// Month link
							$output .= '<li class="fl"><a href="' . esc_url( get_month_link( get_the_time('Y'), get_the_time( 'm' ) ) ) . '" title="' . esc_attr( get_the_time( 'M' ) ) . '">' . get_the_time( 'M' ) . esc_html__( ' Archives', 'rolling' ) . '</a></li>';
							$output .= '<li class="fl separator"> ' . $sep . ' </li>';
							 
							// Day display
							$output .= '<li class="fl current"> ' . get_the_time('jS') . ' ' . get_the_time('M') . esc_html__( ' Archives', 'rolling' ) . '</li>';
							 
						} elseif ( is_month() ) {
							 
							// Month Archive
							 
							// Year link
							$output .= '<li class="fl"><a href="' . esc_url( get_year_link( get_the_time( 'Y' ) ) ) . '" title="' . esc_attr( get_the_time( 'Y' ) ) . '">' . get_the_time( 'Y' ) . esc_html__( ' Archives', 'rolling' ) . '</a></li>';
							$output .= '<li class="fl separator"> ' . $sep . ' </li>';
							 
							// Month display
							$output .= '<li class="fl">' . get_the_time( 'M' ) . esc_html__( ' Archives', 'rolling' ) . '</li>';
							 
						} elseif ( is_year() ) {
							 
							// Display year archive
							$output .= '<li class="fl current">' . get_the_time('Y') . esc_html__( 'Archives', 'rolling' ) . '</li>';
							 
						} elseif ( is_author() ) {
							 
							// Auhor archive
							 
							// Get the author information
							global $author;
							$userdata = get_userdata( $author );
							 
							// Display author name
							$output .= '<li class="fl current">' . esc_html__( 'Author: ', 'rolling' ) . $userdata->display_name . '</li>';
						 
						} elseif ( get_query_var('paged') ) {
							 
							// Paginated archives
							$output .= '<li class="fl current">' .  esc_html__( 'Page', 'rolling' ) . ' ' . get_query_var( 'paged' ) . '</li>';
							 
						} elseif ( is_search() ) {
						 
							// Search results page
							$output .= '<li class="fl current">' .  esc_html__( 'Search results for: ', 'rolling' ) . get_search_query() . '</li>';
						 
						} elseif ( is_404() ) {

							$output .= '<li class="fl current">' . esc_html__( 'Error 404', 'rolling' ) . '</li>';

						}
						 
					} else  {
						$output .= '<li class="fl current">' . esc_html__( 'Front Page', 'rolling' ) . '</li>';
					}
			 
				$output .= '</ul>';
			$output .= '</div>';
		$output .= '</div>';

		return apply_filters( 'rolling_breadcrumb', $output );
	}
}

/**
 * Print HTML for social share.
 *
 * @return  void
 */
if ( ! function_exists( 'rolling_social_share' ) ) {
	function rolling_social_share() {
		global $post;
		$src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), false, '' );
		?>
			<div class="social-share">
				<div class="jas-social">
					<a title="<?php echo esc_html__( 'Share this post on Facebook', 'rolling' ); ?>" class="cb facebook" href="http://www.facebook.com/sharer.php?u=<?php esc_url( the_permalink() ); ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=380,width=660');return false;">
						<i class="fa fa-facebook"></i>
					</a>
					<a title="<?php echo esc_html__( 'Share this post on Twitter', 'rolling' ); ?>" class="cb twitter" href="https://twitter.com/share?url=<?php esc_url( the_permalink() ); ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=380,width=660');return false;">
						<i class="fa fa-twitter"></i>
					</a>
					<a title="<?php echo esc_html__( 'Share this post on Google Plus', 'rolling' ); ?>" class="cb google-plus" href="https://plus.google.com/share?url=<?php esc_url( the_permalink() ); ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=380,width=660');return false;">
						<i class="fa fa-google-plus"></i>
					</a>
					<a title="<?php echo esc_html__( 'Share this post on Pinterest', 'rolling' ); ?>" class="cb pinterest" href="//pinterest.com/pin/create/button/?url=<?php esc_url( the_permalink() ); ?>&media=<?php echo esc_url( $src[0] ); ?>&description=<?php the_title(); ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
						<i class="fa fa-pinterest"></i>
					</a>
					<a data-title="<?php echo esc_html__( 'Share this post on Tumbr', 'rolling' ); ?>" class="cb tumblr" data-content="<?php echo esc_url( $src[0] ); ?>" href="//tumblr.com/widgets/share/tool?canonicalUrl=<?php esc_url( the_permalink() ); ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=540');return false;">
						<i class="fa fa-tumblr"></i>
					</a>
				</div>
			</div>
		<?php
	}
}

/**
 * Print HTML for social list.
 *
 * @return  void
 */
if ( ! function_exists( 'rolling_social' ) ) {
	function rolling_social() {
		$output = '';

		$socials = cs_get_option( 'social-network' );
		if ( empty( $socials ) ) return;

		$output .= '<div class="jas-socials">';
			foreach ( $socials as $social) {
				$output .= '<a class="dib br__50 tc ' . esc_attr( str_replace( 'fa fa-', '', $social['icon'] ) ) . '" href="' . esc_url( $social['link'] ) . '" target="_blank"><i class="' . esc_attr( $social['icon'] ) . '"></i></a>';
			}
		$output .= '</div>';

		return apply_filters( 'rolling_social', $output );
	}
}

/**
 * Render author information.
 *
 * @return string
 */
if ( ! function_exists( 'rolling_author_info' ) ) {
	function rolling_author_info() {
		$author = sprintf(
			wp_kses_post( '<div class="post-author">%1$s<div class="clearfix">%2$s%3$s</div></div>', 'rolling' ),
			'<h4 class="mg__0 mb__35 pr dib tu cp head__1">' . esc_html__( 'About Author', 'rolling' ) . '</h4>',
			'<div class="fl">' . get_avatar( get_the_author_meta( 'user_email' ), '100', '' ) . '</div>',
			'<div class="oh pl__70"><a class="f__mont cb chp fwb db mb__10 mt__5" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a><p>' . get_the_author_meta( 'description' ) . '</p></div>'

		);
		echo apply_filters( 'rolling_author_info', $author );
	}
}


/**
 * custom function to use to open and display each comment
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'rolling_comments_list' ) ) {
	function rolling_comments_list( $comment, $args, $depth ) {
	// Globalize comment object
		$GLOBALS['comment'] = $comment;

		switch ( $comment->comment_type ) :

			case 'pingback'  :
			case 'trackback' :
				?>
				<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
					<p>
						<?php
							echo esc_html__( 'Pingback:', 'rolling' );
							comment_author_link();
							edit_comment_link( esc_html__( 'Edit', 'rolling' ), '<span class="edit-link">', '</span>' );
						?>
					</p>
				<?php
			break;

			default :
				global $post;
				?>
				<li <?php comment_class( 'mt__30' ); ?> id="li-comment-<?php comment_ID(); ?>">
					<article id="comment-<?php comment_ID(); ?>" class="comment_container">
						<?php echo get_avatar( $comment, 80 ); ?>

						<div class="comment-text">
							<?php if ( '0' == $comment->comment_approved ) : ?>
								<p class="comment-awaiting-moderation"><?php echo esc_html__( 'Your comment is awaiting moderation.', 'rolling' ); ?></p>
							<?php endif; ?>

							<?php
								printf(
									'<h5 class="comment-author mg__0 mb__5 tu cb">%1$s</h5>',
									get_comment_author_link(),
									( $comment->user_id == $post->post_author ) ? '<span class="author-post">' . esc_html__( 'Post author', 'rolling' ) . '</span>' : ''
								);
							?>
							<?php comment_text(); ?>

							<div class="flex">
								<?php
									printf(
										'<time class="grow f__libre">%3$s</time>',
										esc_url( get_comment_link( $comment->comment_ID ) ),
										get_comment_time( 'c' ),
										sprintf( wp_kses_post( '%1$s at %2$s', 'rolling' ), get_comment_date(), get_comment_time() )
									);
								?>
								<?php
									edit_comment_link( wp_kses_post( '<span>' . esc_html__( 'Edit', 'rolling' ) . '</span>', 'rolling' ) );
									comment_reply_link(
										array_merge(
											$args,
											array(
												'reply_text' => wp_kses_post( '<span class="ml__10">' . esc_html__( 'Reply', 'rolling' ) . '</span>', 'rolling' ),
												'depth'      => $depth,
												'max_depth'  => $args['max_depth'],
											)
										)
									);
								?>
							</div><!-- .action-link -->
						</div><!-- .comment-content -->
					</article><!-- #comment- -->
				<?php
			break;

		endswitch;
	}
}

/**
 * Render custom styles.
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'rolling_custom_css' ) ) {
	function rolling_custom_css( $css = array() ) {

		// Content width
		$content_width = cs_get_option( 'content-width' );
		if ( $content_width != '1170' ) {
			$css[] = '
				@media only screen and (min-width: 75em) {
					.jas-container {
						width: ' . esc_attr( $content_width ) . 'px;
					}
				}
			';
		}
		
		// Typography
		$body_font    = cs_get_option( 'body-font' );
		$heading_font = cs_get_option( 'heading-font' );

		$css[] = 'body {';
			// Body font family
			$css[] = 'font-family: "' . $body_font['family'] . '";';
			if ( '100italic' == $body_font['variant'] ) {
				$css[] = '
					font-weight: 100;
					font-style: italic;
				';
			} elseif ( '300italic' == $body_font['variant'] ) {
				$css[] = '
					font-weight: 300;
					font-style: italic;
				';
			} elseif ( '400italic' == $body_font['variant'] ) {
				$css[] = '
					font-weight: 400;
					font-style: italic;
				';
			} elseif ( '700italic' == $body_font['variant'] ) {
				$css[] = '
					font-weight: 700;
					font-style: italic;
				';
			} elseif ( '800italic' == $body_font['variant'] ) {
				$css[] = '
					font-weight: 700;
					font-style: italic;
				';

			} elseif ( '900italic' == $body_font['variant'] ) {
				$css[] = '
					font-weight: 900;
					font-style: italic;
				';
			} elseif ( 'regular' == $body_font['variant'] ) {
				$css[] = 'font-weight: 400;';
			} elseif ( 'italic' == $body_font['variant'] ) {
				$css[] = 'font-style: italic;';
			} else {
				$css[] = 'font-weight:' . $body_font['variant'] . ';';
			}

			// Body font size
			if ( cs_get_option( 'body-font-size' ) ) {
				$css[] = 'font-size:' . cs_get_option( 'body-font-size' ) . 'px;';
			}

			// Body color
			if ( cs_get_option( 'body-color' ) ) {
				$css[] = 'color:' . cs_get_option( 'body-color' );
			}
		$css[] = '}';

		$css[] = 'h1, h2, h3, h4, h5, h6, .f__pop {';
			$css[] = 'font-family: "' . $heading_font['family'] . '";';
			if ( '100italic' == $heading_font['variant'] ) {
				$css[] = '
					font-weight: 100;
					font-style: italic;
				';
			} elseif ( '300italic' == $heading_font['variant'] ) {
				$css[] = '
					font-weight: 300;
					font-style: italic;
				';
			} elseif ( '400italic' == $heading_font['variant'] ) {
				$css[] = '
					font-weight: 400;
					font-style: italic;
				';
			} elseif ( '500italic' == $heading_font['variant'] ) {
				$css[] = '
					font-weight: 500;
					font-style: italic;
				';
			} elseif ( '600italic' == $heading_font['variant'] ) {
				$css[] = '
					font-weight: 600;
					font-style: italic;
				';
			} elseif ( '700italic' == $heading_font['variant'] ) {
				$css[] = '
					font-weight: 700;
					font-style: italic;
				';
			} elseif ( '900italic' == $heading_font['variant'] ) {
				$css[] = '
					font-weight: 900;
					font-style: italic;
				';
			} elseif ( 'regular' == $heading_font['variant'] ) {
				$css[] = 'font-weight: 400;';
			} elseif ( 'italic' == $heading_font['variant'] ) {
				$css[] = 'font-style: italic;';
			} else {
				$css[] = 'font-weight:' . $heading_font['variant'];
			}
		$css[] = '}';
		
		if ( cs_get_option( 'heading-color' ) ) {
			$css[] = 'h1, h2, h3, h4, h5, h6 {';
				$css[] = 'color:' . cs_get_option( 'heading-color' );
			$css[] = '}';
		}

		if ( cs_get_option( 'h1-font-size' ) ) {
			$css[] = 'h1 { font-size:' . cs_get_option( 'h1-font-size' ) . 'px; }';
		}
		if ( cs_get_option( 'h2-font-size' ) ) {
			$css[] = 'h2 { font-size:' . cs_get_option( 'h2-font-size' ) . 'px; }';
		}
		if ( cs_get_option( 'h3-font-size' ) ) {
			$css[] = 'h3 { font-size:' . cs_get_option( 'h3-font-size' ) . 'px; }';
		}
		if ( cs_get_option( 'h4-font-size' ) ) {
			$css[] = 'h4 { font-size:' . cs_get_option( 'h4-font-size' ) . 'px; }';
		}
		if ( cs_get_option( 'h5-font-size' ) ) {
			$css[] = 'h5 { font-size:' . cs_get_option( 'h5-font-size' ) . 'px; }';
		}
		if ( cs_get_option( 'h6-font-size' ) ) {
			$css[] = 'h6 { font-size:' . cs_get_option( 'h6-font-size' ) . 'px; }';
		}
		// Custom css
		if ( cs_get_option( 'custom-css' ) ) {
			$css[] = cs_get_option( 'custom-css' );
		}

		return preg_replace( '/\n|\t/i', '', implode( '', $css ) );
	}
}

/**
 * Get custom data to js.
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'rolling_custom_data_js' ) ) {
	function rolling_custom_data_js() {
		$data = array();
		return $data;
	}
}



/**
 * Render google font link
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'rolling_google_font_url' ) ) {
	function rolling_google_font_url() {
		// Google font
		$fonts = $font_parse = array();

		// Font default
		$fonts['Poppins'] = array(
			'300',
			'400',
			'500',
			'600',
			'700',
		);
		$fonts['Libre Baskerville'] = array( '400italic' );

		// Body font
		$body_font    = cs_get_option( 'body-font' );
		$heading_font = cs_get_option( 'heading-font' );

		if ( $body_font ) {
			$font_family = esc_attr( $body_font['family'] );
			if ( '100italic' == $body_font['variant'] ) {
				$font_weight = array( '100' );
			} elseif ( '300italic' == $body_font['variant'] ) {
				$font_weight = array( '300' );
			} elseif ( '400italic' == $body_font['variant'] ) {
				$font_weight = array( '400' );
			} elseif ( '700italic' == $body_font['variant'] ) {
				$font_weight = array( '700' );
			} elseif ( '900italic' == $body_font['variant'] ) {
				$font_weight = array( '900' );
			} elseif ( 'regular' == $body_font['variant'] ) {
				$font_weight = array( '400' );
			} else {
				$font_weight = array( $body_font['variant'] );
			}

			// Merge array and delete values duplicated
			$fonts[$font_family] = isset( $fonts[$font_family] ) ? array_unique( array_merge( $fonts[$font_family], $font_weight ) ) : $font_weight;
		}

		if ( $heading_font ) {
			$font_family = esc_attr( $heading_font['family'] );
			if ( '100italic' == $heading_font['variant'] ) {
				$font_weight = array( '100' );
			} elseif ( '300italic' == $heading_font['variant'] ) {
				$font_weight = array( '300' );
			} elseif ( '400italic' == $heading_font['variant'] ) {
				$font_weight = array( '400' );
			} elseif ( '700italic' == $heading_font['variant'] ) {
				$font_weight = array( '700' );
			} elseif ( '900italic' == $heading_font['variant'] ) {
				$font_weight = array( '900' );
			} elseif ( 'regular' == $heading_font['variant'] ) {
				$font_weight = array( '400' );
			} else {
				$font_weight = array( $heading_font['variant'] );
			}

			// Merge array and delete values duplicated
			$fonts[$font_family] = isset( $fonts[$font_family] ) ? array_unique( array_merge( $fonts[$font_family], $font_weight ) ) : $font_weight;
		}

		// Parse array to string for url Google fonts
		foreach ( $fonts as $font_name => $font_weight ) {
			$font_parse[] = $font_name . ':'. implode( ',' , $font_weight );
		}

		$query_args = array(
			'family' => urldecode( implode( '|', $font_parse ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);

		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );

		return esc_url_raw( $fonts_url );
	}
}