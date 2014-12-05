<?php
/**
 * The Template for displaying all single posts.
 *
 * @package _s
 * @since _s 1.0
 */
get_header();
?>
<div class="container">
	<?php get_sidebar(); ?>
    <div class="content blog">
		<?php if ( have_posts() ): ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<!--  =====  START POST  =====  -->
				<div <?php post_class('blog_post'); ?>>
					<div class="blog_post_info">
						<div class="post_date"><?php the_time( 'd <\s\p\a\n> M <\/\s\p\a\n>' ); ?></div>
						<div class="post_comm">(<?php comments_number( '0', '1', '%' ) ?>)</div>
						<div class="post_title"> <span>by <?php the_author() ?> in <?php the_category( ', ' ); ?></span>
							<h2><a href="#"><?php the_title() ?></a></h2>
						</div>
						<div class="clear"></div>
					</div>
					<?php if ( has_post_thumbnail() ) : ?>
						<div class="blog_post_image">
							<?php the_post_thumbnail() ?>
						</div>
					<?php endif; ?>
					<p>
						<?php the_content() ?>
					</p>
					<?php if( has_tag() ) : ?>
					<ul class="blog_post_tags">
						<li><?php _e( 'Tags: ', 'mycountdown' ); ?> </li>
						<?php the_tags( '<ul><li>', '</li><li>', '</li></ul>' ); ?>
					</ul>
					<?php endif; ?>
					<!--  =====  START PAGINATION  =====  -->
					<div class="blog_pages">
						<?php wp_link_pages(); ?>
					</div>
					<!--  =====  END PAGINATION  =====  -->
					<?php comments_template( '', true ); ?>
				</div>
				<!--  =====  END POST  =====  -->
			<?php endwhile; ?>
		<?php endif; ?>

    </div>
    <div class="clear"></div>
    <div class="scroll"></div>
</div>
<?php get_footer(); ?>