<?php
/**
 * Search results page
 *
 * Please see /external/starkers-utilities.php for info on get_template_parts()
 *
 * @package 	WordPress
 * @subpackage 	Starkers
 * @since 		Starkers 4.0
 */
?>
<?php get_header(); ?>

<div class="container">
	<?php get_sidebar(); ?>
    <div class="content blog">
		<?php if ( have_posts() ): ?>
			<h3><?php _e( 'Search Results for : ', 'mycountdown' ); ?>'<?php echo get_search_query(); ?>'</h3>
			<ol>
				<?php while ( have_posts() ) : the_post(); ?>
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
						<p><?php the_excerpt() ?></p>
					</div>
				<?php endwhile; ?>
			</ol>
		<?php else: ?>
			<h2><?php _e( 'No results found for ', 'mycountdown' ); ?> '<?php echo get_search_query(); ?>'</h2>
		<?php endif; ?>
    </div>
</div>
<?php get_footer(); ?>