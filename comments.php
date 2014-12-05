<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form. The actual display of comments is
 * handled by a callback to starkers_comment() which is
 * located in the functions.php file.
 *
 * @package 	WordPress
 * @subpackage 	Starkers
 * @since 		Starkers 4.0
 */
?>
<?php
$args = array(
	'fields' => apply_filters( 'comment_form_default_fields', array(
		'author' => '<input id="author" class="line1 mr" name="author" type="text" value="' . esc_attr( $commenter[ 'comment_author' ] ) . '" size="30" placeholder="Name" />',
		'email' => '<input id="email" class="line1" name="email" type="text" value="' . esc_attr( $commenter[ 'comment_author_email' ] ) . '" size="30" placeholder="E-mail" />',
		'url' => '<input id="url" class="line2" name="url" type="text" value="' . esc_attr( $commenter[ 'comment_author_url' ] ) . '" size="30" placeholder="WebSite" />'
			)
	),
	'comment_notes_after' => '',
	'comment_notes_before' => '',
	'title_reply' => '',
	'comment_field' => '<textarea class="line2 area" name="comment" cols="10" rows="10" placeholder="Message"></textarea>',
	'label_submit' => 'Send'
);
?>
<div class="comment_form">
    <div class="comment_form_title"><?php _e( 'Leave a reply ', 'mycountdown' ); ?></div>
	<?php
	comment_form( $args );
	?>
</div>
<div class="comments_area">
	<?php if ( post_password_required() ) : ?>
		<p><?php _e( 'This post is password protected. Enter the password to view any comments ', 'mycountdown' ); ?></p>
	</div>

	<?php
	/* Stop the rest of comments.php from being processed,
	 * but don't kill the script entirely -- we still have
	 * to fully load the template.
	 */
	return;
endif;
?>

<?php if ( have_comments() ) : ?>
	<?php wp_list_comments( array( 'style' => 'div', 'callback' => 'custom_comments' ) ); ?>
	<?php
/* If there are no comments and comments are closed, let's leave a little note, shall we?
 * But we don't want the note on pages or post types that do not support comments.
 */
elseif ( ! comments_open() && ! is_page() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>

	<p><?php _e( 'Comments are closed', 'mycountdown' ); ?></p>

<?php endif; ?>
<div class="navigation">
	<?php paginate_comments_links(); ?>
</div>
</div>
<!-- #comments -->