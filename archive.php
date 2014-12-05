<?php
/**
 * The template for displaying Archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy

 */
get_header();
?>
<div class="container archive">
	<?php get_sidebar(); ?>
    <div class="content blog">
		<?php if ( have_posts() ): ?>
			<h3 class="archive-title"><?php
		if ( is_category() ) {
			printf( __( 'Category Archives: %s', 'mycountdown' ), '<span>' . single_cat_title( '', false ) . '</span>' );
		} elseif ( is_tag() ) {
			printf( __( 'Tag Archives: %s', 'mycountdown' ), '<span>' . single_tag_title( '', false ) . '</span>' );
		} elseif ( is_author() ) {
			/* Queue the first post, that way we know
			 * what author we're dealing with (if that is the case).
			 */
			the_post();
			printf( __( 'Author Archives: %s', 'mycountdown' ), '<span class="vcard"><a class="url fn n" href="' . get_author_posts_url( get_the_author_meta( "ID" ) ) . '" title="' . esc_attr( get_the_author() ) . '" rel="me">' . get_the_author() . '</a></span>' );
			/* Since we called the_post() above, we need to
			 * rewind the loop back to the beginning that way
			 * we can run the loop properly, in full.
			 */
			rewind_posts();
		} elseif ( is_day() ) {
			printf( __( 'Daily Archives: %s', 'mycountdown' ), '<span>' . get_the_date() . '</span>' );
		} elseif ( is_month() ) {
			printf( __( 'Monthly Archives: %s', 'mycountdown' ), '<span>' . get_the_date( 'F Y' ) . '</span>' );
		} elseif ( is_year() ) {
			printf( __( 'Yearly Archives: %s', 'mycountdown' ), '<span>' . get_the_date( 'Y' ) . '</span>' );
		} else {
			_e( 'Archives', 'mycountdown' );
		}
			?></h3>

			<?php if ( tag_description() ) : // Show an optional tag description ?>
				<div class="archive-meta"><?php echo tag_description(); ?></div>
			<?php endif; ?>

			<?php while ( have_posts() ) : the_post(); ?>
				<div class="blog_post">
					<div class="blog_post_info">
						<div class="post_date"><?php the_time( 'd <\s\p\a\n> M <\/\s\p\a\n>' ); ?></div>
						<div class="post_comm">(<?php comments_number( '0', '1', '%' ) ?>)</div>
						<div class="post_title"> <span><?php
		_e( 'by ', 'mycountdown' );
		the_author()
				?></span>
							<h2><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h2>
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
					<p>
						<?php the_excerpt() ?>
					</p>
				</div>
				<?php
			endwhile;
		endif;
		?>
	</div>
    <div class="clear"></div>
    <div class="scroll"></div>
</div>
<?php get_footer(); ?>