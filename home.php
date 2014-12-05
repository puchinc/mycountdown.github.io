<?php
/**
 * The template for displaying blog page.
 */
get_header();
?>
<div class="container">
	<?php get_sidebar(); ?>
    <div class="content blog">
		<?php if ( have_posts() ): ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<!--  =====  START POST  =====  -->
				<div class="blog_post">
					<div class="blog_post_info">
						<div class="post_date"><?php the_time( 'd <\s\p\a\n> M <\/\s\p\a\n>' ); ?></div>
						<div class="post_comm">(<?php comments_number( '0', '1', '%' ) ?>)</div>
						<div class="post_title"> <span>by <?php the_author() ?></span>
							<h2><a href="<?php the_permalink(); ?>"><?php the_title() ?></a></h2>
						</div>
						<div class="clear"></div>
					</div>
					<?php if ( has_post_thumbnail() ) : ?>
						<div class="blog_post_image">
							<a href="<?php the_permalink(); ?>">
								<span class="post_image_read">
									<span><?php _e( 'read ', 'mycountdown' ); ?><br/>
									<?php _e( 'more ', 'mycountdown' ); ?></span>
								</span>
							</a>
							<?php the_post_thumbnail() ?>
						</div>
					<?php endif; ?>
					<p><?php the_content() ?></p>
				</div>
				<!--  =====  END POST  =====  -->
			<?php endwhile; ?>
		<?php else: ?>
			<h2><?php _e( 'No posts to display', 'mycountdown' ); ?></h2>
		<?php endif; ?>
        <!--  =====  START PAGINATION  =====  -->
        <div class="blog_pages">
			<?php
			global $wp_query;
			$big = 999999999; // need an unlikely integer
			$total_pages = $wp_query->max_num_pages;
			if ( $total_pages > 1 ) {
				$current_page = max( 1, get_query_var( 'paged' ) );
				echo paginate_links( array(
					'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
					'format' => '/page/%#%',
					'current' => $current_page,
					'total' => $total_pages,
					'type' => 'plain',
					'next_text' => __( 'Next', 'mycountdown' ),
					'prev_text' => __( 'Prev', 'mycountdown' ),
				) );
			}
			?>
        </div>
        <!--  =====  END PAGINATION  =====  -->
    </div>
    <div class="clear"></div>
    <div class="scroll"></div>
</div>
<?php get_footer(); ?>