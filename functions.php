<?php
/**
 * Starkers functions and definitions
 *
 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
 *
 * @package 	WordPress
 * @subpackage 	Starkers
 * @since 		Starkers 4.0
 */
/* ========================================================================================================================

  Required external files

  ======================================================================================================================== */

require_once( 'external/starkers-utilities.php' );

/* ========================================================================================================================

  Theme specific settings

  Uncomment register_nav_menus to enable a single menu with the title of "Primary Navigation" in your theme

  ======================================================================================================================== */


/* ========================================================================================================================

  Actions and Filters

  ======================================================================================================================== */

add_action( 'wp_enqueue_scripts', 'script_enqueuer' );

add_filter( 'body_class', 'add_slug_to_body_class' );

function my_theme_setup() {
	load_theme_textdomain( 'mycountdown', get_template_directory() . '/languages' );
}

add_action( 'after_setup_theme', 'my_theme_setup' );
/* ========================================================================================================================

  Custom Post Types - include custom post types and taxonimies here e.g.

  e.g. require_once( 'custom-post-types/your-custom-post-type.php' );

  ======================================================================================================================== */



/* ========================================================================================================================

  Scripts

  ======================================================================================================================== */

/**
 * Add scripts via wp_head()
 *
 * @return void
 * @author Keir Whitaker
 */
function script_enqueuer() {

	wp_register_script( 'site', get_template_directory_uri() . '/js/options.js', array( 'jquery' ) );
	wp_enqueue_script( 'site' );
	if ( is_singular() )
		wp_enqueue_script( "comment-reply" );

	wp_register_style( 'style', get_template_directory_uri() . '/css/style.css', '', '', 'screen' );
	wp_enqueue_style( 'style' );
	echo '<script type="text/javascript">var ajaxurl = \''.admin_url('admin-ajax.php').'\';</script>';
}

/* ========================================================================================================================

  Comments

  ======================================================================================================================== */

function custom_comments( $comment, $args, $depth ) {
	$GLOBALS[ 'comment' ] = $comment;
	extract( $args, EXTR_SKIP );

	if ( 'div' == $args[ 'style' ] ) {
		$tag = 'div';
		$add_below = 'comment';
	} else {
		$tag = 'li';
		$add_below = 'div-comment';
	}
	?>
	<<?php echo $tag ?> <?php comment_class( empty( $args[ 'has_children' ] ) ? '' : 'parent'  ) ?> id="comment-<?php comment_ID() ?>">
	<?php if ( 'div' != $args[ 'style' ] ) : ?>
		<div id="div-comment-<?php comment_ID() ?>" class="comment">
		<?php endif; ?>
		<div class="comment_image"><?php if ( $args[ 'avatar_size' ] != 0 ) echo get_avatar( $comment, $args[ 'avatar_size' ] ); ?></div>
		<div class="comment_title">
			<div class="comment-reply-link"><?php comment_reply_link( array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args[ 'max_depth' ] ) ) ) ?></div>
			<?php echo get_comment_author() ?>
			<span class="comment_date"><?php printf( __( '%1$s at %2$s', 'mycountdown' ), get_comment_date(), get_comment_time() ) ?></span>
		</div>
		<?php comment_text() ?>
		<?php if ( 'div' != $args[ 'style' ] ) : ?>
		</div>
	<?php endif; ?>
	<div class="clear"></div>
	<?php
}

//==========================================================================================================
//Includes
include 'shortcodes.php';
include 'widgets/archives_widget.php';
include 'widgets/categories_widget.php';

/**
 * Custom callback for outputting comments
 *
 * @return void
 * @author Keir Whitaker
 */
function starkers_comment( $comment, $args, $depth ) {
	$GLOBALS[ 'comment' ] = $comment;
	?>
	<?php if ( $comment->comment_approved == '1' ): ?>
		<li>
			<article id="comment-<?php comment_ID() ?>">
				<?php echo get_avatar( $comment ); ?>
				<h4><?php comment_author_link() ?></h4>
				<time><a href="#comment-<?php comment_ID() ?>" pubdate><?php comment_date() ?> at <?php comment_time() ?></a></time>
				<?php comment_text() ?>
			</article>
			<?php
		endif;
	}

	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	//content width
	if ( ! isset( $content_width ) )
		$content_width = 960;

	//get template name
	add_filter( 'template_include', 'var_template_include', 1000 );

	function var_template_include( $t ) {
		$GLOBALS[ 'current_theme_template' ] = basename( $t );
		return $t;
	}

	function get_current_template( $echo = false ) {
		if ( ! isset( $GLOBALS[ 'current_theme_template' ] ) )
			return false;
		if ( $echo )
			echo $GLOBALS[ 'current_theme_template' ];
		else
			return $GLOBALS[ 'current_theme_template' ];
	}

	//Blog page
	function strip_images( $content ) {
		return preg_replace( '/<img[^>]+./', '', $content );
	}

	function cut_content_small( $content, $nr_chars = '480' ) {
		$content = preg_replace( '!^(<p></p>\s*)+!', '', $content );
		$str = wordwrap( $content, $nr_chars );
		$str = explode( "\n", $str );
		$str = $str[ 0 ];
		return $str;
	}

	function cut_content_big( $content, $nr_chars = '500' ) {
		$content = preg_replace( '!^(<p></p>\s*)+!', '', $content );
		$str = wordwrap( $content, $nr_chars );
		$str = explode( "\n", $str );
		$str = $str[ 0 ] . '...';
		return $str;
	}

	function cut_shortcodes( $content ) {
		return preg_replace( '@\[.*?\]@', '', $content );
	}

	function no_slider( $content ) {
		return preg_replace( "@(<div class=\'slider\'.*?</div>\s*</div>\s*</div>)@is", ' ', $content );
	}

	function echo_first_image( $postID ) {
		$args = array(
			'numberposts' => 1,
			'order' => 'ASC',
			'post_mime_type' => 'image',
			'post_parent' => $postID,
			'post_status' => null,
			'post_type' => 'attachment'
		);

		$attachments = get_children( $args );

		//print_r($attachments);

		if ( $attachments ) {
			foreach ( $attachments as $attachment ) {
				$image_attributes = wp_get_attachment_image_src( $attachment->ID, 'thumbnail' ) ? wp_get_attachment_image_src( $attachment->ID, 'thumbnail' ) : wp_get_attachment_image_src( $attachment->ID, 'full' );

				echo '<img src="' . wp_get_attachment_thumb_url( $attachment->ID ) . '" class="current">';
			}
		}
	}

	//------comment form-----------------------------
	function comment_field( $field ) {
		return preg_replace( "@\n@is", " ", $field );
	}

	//===============================Sidebars===================================

	if ( function_exists( 'register_sidebar' ) ) {
		//========Blog sidebar==============
		register_sidebar( array(
			'name' => 'Blog Sidebar',
			'id' => 'blogsidebar',
			'before_widget' => '',
			'after_widget' => '',
		) );
	}

	//====================View count for single posts===========================
	function wpb_set_post_views( $postID ) {
		$count_key = 'wpb_post_views_count';
		$count = get_post_meta( $postID, $count_key, true );
		if ( $count == '' ) {
			$count = 0;
			delete_post_meta( $postID, $count_key );
			add_post_meta( $postID, $count_key, '0' );
		} else {
			$count ++;
			update_post_meta( $postID, $count_key, $count );
		}
	}

//To keep the count accurate, lets get rid of prefetching
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );

	function wpb_get_post_views( $postID ) {
		$count_key = 'wpb_post_views_count';
		$count = get_post_meta( $postID, $count_key, true );
		if ( $count == '' ) {
			delete_post_meta( $postID, $count_key );
			add_post_meta( $postID, $count_key, '0' );
			return "0 View";
		}
		return $count . ' Views';
	}

	//Favicon ------------
	function get_favicon( $options ) {
		$favicon = '';
		if ( @$options[ 'favicon_img_caption' ] != '' ) {
			while ( have_posts() ) : the_post();
				$args = array(
					'post_type' => 'attachment',
					'numberposts' => -1,
					'orderby' => 'menu_order',
					'order' => 'ASC',
					'post_mime_type' => 'image',
					'post_status' => null
				);

				$attachments = get_posts( $args );
				if ( $attachments ) {
					foreach ( $attachments as $attachment ) {
						if ( $attachment->post_excerpt == $options[ 'favicon_img_caption' ] ) {
							$favicon = $attachment->guid;
							break 2;
						}
					}
				}
			endwhile;
			rewind_posts();
		} elseif ( @$options[ 'favicon_img_link' ] != '' )
			$favicon = $options[ 'favicon_img_link' ];
		return $favicon;
	}

	//Logo-------------------
	function get_logo( $options ) {
		if ( $options[ 'logo_img' ] != '' ) {
			while ( have_posts() ) : the_post();
				$args = array(
					'post_type' => 'attachment',
					'numberposts' => -1,
					'orderby' => 'menu_order',
					'order' => 'ASC',
					'post_mime_type' => 'image',
					'post_status' => null
				);

				$attachments = get_posts( $args );
				if ( $attachments ) {
					foreach ( $attachments as $attachment ) {
						if ( $attachment->post_title == $options[ 'logo_img' ] ) {
							return "<img src='" . $attachment->guid . "' alt='logo'>";
							break 2;
						}
					}
				}
			endwhile;
			rewind_posts();
		} elseif ( $options[ 'logo_img_link' ] != '' )
			return "<img src=" . $options[ 'logo_img_link' ] . " alt='logo' />";
		else
			return "<a href='" . home_url() . "'>" . $options[ 'logo_text' ] . "</a>";
	}

	register_nav_menus( array(
		'side_menu' => 'Side Menu'
	) );

//==============================++++++Admin Panel++++++++=======================
	//-------Menu and pages--------------------------------
	add_action( "admin_menu", "setup_theme_admin_menus" );

	function setup_theme_admin_menus() {
		//-------adding css nad javascript to admin head--------
		if ( isset( $_GET[ 'page' ] ) && $_GET[ 'page' ] == 'custom_theme_settings' ) {
			add_action( 'admin_head', 'theme_options_page_head' );
		}
		
		add_menu_page( 'Theme settings', 'My Countdown', 'manage_options', 'custom_theme_settings', 'theme_options_do_page', get_template_directory_uri() . '/images/favicon.ico' );
	}

	//add admin bar link
	function wp_admin_bar_new_item() {
		global $wp_admin_bar;
		$wp_admin_bar->add_menu( array(
			'id' => 'wp-admin-bar-new-item',
			'title' => __( 'MyCountdown Options', 'mycountdown' ),
			'href' => site_url() . '/wp-admin/admin.php?page=custom_theme_settings'
		) );
	}

	add_action( 'wp_before_admin_bar_render', 'wp_admin_bar_new_item' );

	//change footer wp text
	function remove_footer_admin() {
		echo 'Thanks for choosing <a href="http://themeforest.net/user/RedSkyThemes">RedSkyThemes</a>.';
	}

	add_filter( 'admin_footer_text', 'remove_footer_admin' );

	function custom_admin_post_thumbnail_html( $content ) {
		return $content = str_replace( __( 'Set featured image', 'mycountdown' ), __( 'Set featured image (recommended width must be at least 630px)', 'mycountdown' ), $content );
	}

	add_filter( 'admin_post_thumbnail_html', 'custom_admin_post_thumbnail_html' );

	//-------theme settings--------------------------------
	function theme_options_init() {
		register_setting( 'the_theme_options', 'theme_options' );
	}

	add_action( 'admin_init', 'theme_options_init' );

	function theme_options_page_head() {
		wp_enqueue_script( 'admin_bootstrap_js', get_template_directory_uri() . '/js/bootstrap.js', array( 'jquery' ), '2.2', FALSE );
		wp_enqueue_script( 'admin_js', get_template_directory_uri() . '/js/js_admin.js', array( 'jquery-ui-datepicker' ) );
		wp_enqueue_style( 'admin_bootstrap_css', get_template_directory_uri() . '/css/bootstrap.css' );
		wp_enqueue_style( 'admin_css', get_template_directory_uri() . '/css/style_admin.css' );
		wp_enqueue_style( 'jquery-style', 'http://code.jquery.com/ui/1.10.0/themes/base/jquery-ui.css' );
	}

	function theme_options_do_page() {
		global $select_options;
		if ( ! isset( $_REQUEST[ 'settings-updated' ] ) )
			$_REQUEST[ 'settings-updated' ] = false;
		$options = get_option( 'theme_options' );
		if ( isset( $_POST[ "import_code" ] ) ) {
			$import_code = $_POST[ 'import_code' ];
			$import_code = base64_decode( $import_code );
			$options = unserialize( $import_code );
		}
		if(!tt_security_check())
            return;
		?>
		<div class="wrap">
			<div style="margin-top: 20px;">
				<img style="float:left;margin-right: 20px;" src="<?php echo get_template_directory_uri() ?>/images/icon.png">
				<h1 id="theme_options_title">
					MyCountdown
				</h1>
			</div>
			<?php if ( false !== $_REQUEST[ 'settings-updated' ] ) : ?>
				<div id="message" class="updated"><?php _e( 'Options successfully saved', 'mycountdown' ); ?></div>
			<?php endif; ?>
			<form method="post" action="options.php">
				<?php settings_fields( 'the_theme_options' ); ?>
				<div class="row">
					<div class="span2">
						<h4>Theme Options</h4>
					</div>
					<div class="span9">
						<input class="btn btn-success" type="submit" value="<?php _e( 'Save Options', 'mycountdown' ); ?>" />
					</div>
				</div>
				<hr />
				<div class="row" id="admin_tabs">
					<div class="span2">
						<div class="tabbable tabs-left">
							<ul id="myTab" class="nav nav-tabs">
								<li class="active first"><a href="#header" data-toggle="tab"><?php _e( 'Main', 'mycountdown' ); ?></a></li>
								<li class=""><a href="#footer" data-toggle="tab"><?php _e( 'Footer', 'mycountdown' ); ?></a></li>
								<li class=""><a href="#subscription" data-toggle="tab"><?php _e( 'Subscription', 'mycountdown' ); ?></a></li>
							</ul>
						</div>
					</div>
					<div class="span12">
						<div id="myTabContent" class="tab-content">
							<!--================================HEADER===================================-->
							<div class="tab-pane fade active in" id="header">
								<div class="row">
									<div class="span2">
										<b><?php _e( 'Website Logo', 'mycountdown' ); ?></b>
									</div>
									<div class="span10">
										<input class="input-xlarge logo_field" id="theme_options[logo_text]" type="text" name="theme_options[logo_text]" value="<?php if ( ! empty( $options[ 'logo_text' ] ) ) printf( esc_attr( '%s', 'mycountdown' ), $options[ 'logo_text' ] ); ?>" >
										<label for="theme_options[logo_text]"><?php _e( 'Enter your website logo here', 'mycountdown' ); ?></label>
									</div>
								</div>
								<div class="row">
									<div class="span10 offset2">
										<input class="input-xlarge logo_field" id="theme_options[logo_img_link]" type="text" name="theme_options[logo_img_link]" value="<?php if ( ! empty( $options[ 'logo_img_link' ] ) ) printf( esc_attr( '%s', 'mycountdown' ), $options[ 'logo_img_link' ] ); ?>" />
										<label for="theme_options[logo_img_link]"><?php _e( 'Or link of image logo here', 'mycountdown' ); ?></label>
									</div>
								</div>
								<div class="row">
									<div class="span10 offset2">
										<input class="input-xlarge logo_field" id="theme_options[logo_img]" type="text" name="theme_options[logo_img]" value="<?php if ( ! empty( $options[ 'logo_img' ] ) ) printf( esc_attr( '%s', 'mycountdown' ), $options[ 'logo_img' ] ); ?>" />
										<label for="theme_options[logo_img]"><?php _e( 'Or caption of image logo here (See documentation)', 'mycountdown' ); ?></label>
									</div>
								</div>
								<div class="row">
									<div class="span12">
										<span class="label label-info"><?php _e( 'Note :', 'mycountdown' ); ?></span><?php _e( 'If you entered the caption, it will be taken as logo ignoring the first two fields. If you entered the link, the first field will be ignored.', 'mycountdown' ); ?>
									</div>
								</div>
								<hr>
								<div class="row">
									<div class="span2">
										<b><?php _e( 'Website favicon', 'mycountdown' ); ?></b>
									</div>
									<div class="span10">
										<input class="input-xlarge favicon_field" id="theme_options[favicon_img_link]" type="text" name="theme_options[favicon_img_link]" value="<?php if ( ! empty( $options[ 'favicon_img_link' ] ) ) printf( esc_attr( '%s', 'mycountdown' ), $options[ 'favicon_img_link' ] ); ?>" />
										<label for="theme_options[favicon_img_link]"><?php _e( 'Link to the favicon here', 'mycountdown' ); ?></label>
									</div>
								</div>
								<div class="row">
									<div class="span10 offset2">
										<input class="input-xlarge favicon_field" id="theme_options[favicon_img_caption]" type="text" name="theme_options[favicon_img_caption]" value="<?php if ( ! empty( $options[ 'favicon_img_caption' ] ) ) printf( esc_attr( '%s', 'mycountdown' ), $options[ 'favicon_img_caption' ] ); ?>" />
										<label for="theme_options[favicon_img_caption]"><?php _e( 'Or caption of the uploaded favicon here (See documentation)', 'mycountdown' ); ?></label>
									</div>
								</div>
								<div class="row">
									<div class="span12">
										<span class="label label-info"><?php _e( 'Note :', 'mycountdown' ); ?></span><?php _e( ' If you entered the caption, it will be taken as favicon ignoring the first field.', 'mycountdown' ); ?>
									</div>
								</div>
								<hr>
								<div class="row">
									<div class="span2">
										<b><?php _e( 'Date From', 'mycountdown' ); ?></b>
									</div>
									<div class="span10">
										<input class="input-xlarge logo_field datepicker" id="theme_options[date_from]" type="text" name="theme_options[date_from]" value="<?php if ( ! empty( $options[ 'date_from' ] ) ) printf( esc_attr( '%s', 'mycountdown' ), $options[ 'date_from' ] ); ?>" >
										<label for="theme_options[date_from]"><?php _e( 'Enter the date from which the counter starts counting.', 'mycountdown' ); ?></label>
									</div>
								</div>
								<div class="row">
									<div class="span2">
										<b><?php _e( 'Date To', 'mycountdown' ); ?></b>
									</div>
									<div class="span10">
										<input class="input-xlarge logo_field datepicker" id="theme_options[date_to]" type="text" name="theme_options[date_to]" value="<?php if ( ! empty( $options[ 'date_to' ] ) ) printf( esc_attr( '%s', 'mycountdown' ), $options[ 'date_to' ] ); ?>" >
										<label for="theme_options[date_to]"><?php _e( 'Enter the date at which the counter stops counting.', 'mycountdown' ); ?></label>
									</div>
								</div>
								<div class="row">
									<div class="span2">
										<b><?php _e( 'Display Social Bar', 'mycountdown' ); ?></b>
									</div>
									<div class="span10">
										<input id="theme_options[showsocial]" name="theme_options[showsocial]" type="checkbox" value="1"
											   <?php if ( ! empty( $options[ 'showsocial' ] ) ) checked( '1', $options[ 'showsocial' ] ); ?> />
									</div>
								</div>
								<div class="row">
									<div class="span2">
										<b><?php _e( 'Show facebook social icon', 'mycountdown' ); ?></b>
									</div>
									<div class="span10">
										<input id="theme_options[show_facebook]" name="theme_options[show_facebook]" type="checkbox" value="1"
											   <?php if ( ! empty( $options[ 'show_facebook' ] ) ) checked( '1', $options[ 'show_facebook' ] ); ?> />
									</div>
								</div>
								<div class="row">
									<div class="span2">
										<b><?php _e( 'Facebook URL', 'mycountdown' ); ?></b>
									</div>
									<div class="span10">
										<input id="theme_options[fburl]" type="text" name="theme_options[fburl]" value="<?php if ( ! empty( $options[ 'fburl' ] ) ) printf( esc_attr( '%s', 'mycountdown' ), $options[ 'fburl' ] ); ?>" />
										<label for="theme_options[fburl]"><?php _e( 'Enter yout facebook profile url here http://facebook.com/yourprofileurl', 'mycountdown' ); ?></label>
									</div>
								</div>
								<div class="row">
									<div class="span2">
										<b><?php _e( 'Show googleplus social icon', 'mycountdown' ); ?></b>
									</div>
									<div class="span10">
										<input id="theme_options[show_googleplus]" name="theme_options[show_googleplus]" type="checkbox" value="1"
											   <?php if ( ! empty( $options[ 'show_googleplus' ] ) ) checked( '1', $options[ 'show_googleplus' ] ); ?> />
									</div>
								</div>
								<div class="row">
									<div class="span2">
										<b><?php _e( 'GooglePlus URL', 'mycountdown' ); ?></b>
									</div>
									<div class="span10">
										<input id="theme_options[googleplus_url]" type="text" name="theme_options[googleplus_url]" value="<?php if ( isset( $options[ 'googleplus_url' ] ) ) printf( esc_attr( '%s', 'mycountdown' ), $options[ 'googleplus_url' ] ); ?>" />
										<label for="theme_options[googleplus_url]"><?php _e( 'Enter your googleplus url here', 'mycountdown' ); ?></label>
									</div>
								</div>
								<div class="row">
									<div class="span2">
										<b><?php _e( 'Show twitter social icon', 'mycountdown' ); ?></b>
									</div>
									<div class="span10">
										<input id="theme_options[show_twitter]" name="theme_options[show_twitter]" type="checkbox" value="1"
											   <?php if ( ! empty( $options[ 'show_twitter' ] ) ) checked( '1', $options[ 'show_twitter' ] ); ?> />
									</div>
								</div>
								<hr>
								<div class="row">
									<div class="span2">
										<b><?php _e( 'Twitter', 'mycountdown' ); ?></b>
									</div>
									<div class="span5">
										<label>
											<input id="theme_options[twitterid]" type="text" name="theme_options[twitterid]" value="<?php if ( ! empty( $options[ 'twitterid' ] ) ) echo $options[ 'twitterid' ] ; ?>" />
											Twitter ID</label>
									</div>
									<div class="span5">
										<select id="theme_options[tweets_nr]" type="select" name="theme_options[tweets_nr]">
											<?php if ( empty( $options[ 'tweets_nr' ] ) ) $options[ 'tweets_nr' ] = 1 ?>
											<?php for ( $i = 1; $i <= 20; $i ++  ) : ?>
												<option value="<?php echo $i ?>"<?php if ( $i == $options[ 'tweets_nr' ] ) esc_attr_e( ' selected="selected"', 'mycountdown' ) ?>><?php echo $i ?></option>
											<?php endfor; ?>
										</select>
										<label for="theme_options[tweets_nr]"><?php _e( 'Number of latest tweets', 'mycountdown' ) ?></label>
									</div>
								</div>
								<div class="row">
									<div class="span10 offset2">
										<?php _e( "Visit <a href='https://dev.twitter.com/apps/new' target='_blank'>Twitter Apps</a> , create your App , press 'Generate Access token at the bottom', insert the following from the 'Oauth' tab." ,'mycountdown' ); ?>
									</div>
								</div>
								
								<div class="row">
									<div class="span10 offset2">
										<input class="input-xlarge logo_field" id="theme_options[twitter_consumer_key]" type="text" name="theme_options[twitter_consumer_key]" value="<?php if ( ! empty( $options[ 'twitter_consumer_key' ] ) ) echo $options[ 'twitter_consumer_key' ] ; ?>" />
										<label for="theme_options[twitter_consumer_key]"><?php _e( 'Twitter Consumer key', 'mycountdown' ); ?></label>
									</div>
								</div>
								<div class="row">
									<div class="span10 offset2">
										<input class="input-xlarge logo_field" id="theme_options[twitter_consumer_secret]" type="text" name="theme_options[twitter_consumer_secret]" value="<?php if ( ! empty( $options[ 'twitter_consumer_secret' ] ) ) echo $options[ 'twitter_consumer_secret' ] ; ?>" />
										<label for="theme_options[twitter_consumer_secret]"><?php _e( 'Twitter Consumer secret', 'mycountdown' ); ?></label>
									</div>
								</div>
								<div class="row">
									<div class="span10 offset2">
										<input class="input-xlarge logo_field" id="theme_options[twitter_access_token]" type="text" name="theme_options[twitter_access_token]" value="<?php if ( ! empty( $options[ 'twitter_access_token' ] ) ) echo $options[ 'twitter_access_token' ] ; ?>" />
										<label for="theme_options[twitter_access_token]"><?php _e( 'Twitter Access Token', 'mycountdown' ); ?></label>
									</div>
								</div>
								<div class="row">
									<div class="span10 offset2">
										<input class="input-xlarge logo_field" id="theme_options[twitter_access_tokensecret]" type="text" name="theme_options[twitter_access_tokensecret]" value="<?php if ( ! empty( $options[ 'twitter_access_tokensecret' ] ) ) echo $options[ 'twitter_access_tokensecret' ] ; ?>" />
										<label for="theme_options[twitter_access_tokensecret]"><?php _e( 'Twitter Access Token Secret', 'mycountdown' ); ?></label>
									</div>
								</div>
								<hr>
								<div class="row">
									<div class="span2">
										<b><?php _e( 'Show Flickr social icon', 'mycountdown' ); ?></b>
									</div>
									<div class="span10">
										<input id="theme_options[show_flickr]" name="theme_options[show_flickr]" type="checkbox" value="1"
											   <?php if ( ! empty( $options[ 'show_flickr' ] ) ) checked( '1', $options[ 'show_flickr' ] ); ?> />
									</div>
								</div>
								<div class="row">
									<div class="span2">
										<b><?php _e( 'Flickr URL', 'mycountdown' ); ?></b>
									</div>
									<div class="span10">
										<input id="theme_options[flickr_url]" type="text" name="theme_options[flickr_url]" value="<?php if ( ! empty( $options[ 'flickr_url' ] ) ) echo $options[ 'flickr_url' ] ; ?>" />
										<label for="theme_options[flickr_url]"><?php _e( 'Enter your dribble nickname here', 'mycountdown' ); ?></label>
									</div>
								</div>
							</div>

							<!--================================FOOTER===================================-->
							<div class="tab-pane fade" id="footer">
								<div class="row">
									<div class="span2">
										<b><?php _e( 'Enable Paralax Footer', 'mycountdown' ); ?></b>
									</div>
									<div class="span10">
										<input id="theme_options[show_footer]" name="theme_options[show_footer]" type="checkbox" value="1"
											   <?php if ( ! empty( $options[ 'show_footer' ] ) ) checked( '1', $options[ 'show_footer' ] ); ?> />
									</div>
								</div>
								<div class="row">
									<div class="span2">
										<b><?php _e( 'Show Copyright', 'mycountdown' ); ?></b>
									</div>
									<div class="span10">
										<input id="theme_options[show_copyright]" name="theme_options[show_copyright]" type="checkbox" value="1"
											   <?php if ( ! empty( $options[ 'show_copyright' ] ) ) checked( '1', $options[ 'show_copyright' ] ); ?> />
									</div>
								</div>
								<div class="row">
									<div class="span2">
										<b><?php _e( 'Copyright Text', 'mycountdown' ); ?></b>
									</div>
									<div class="span10">
										<input id="theme_options[copyright_text]" type="text" name="theme_options[copyright_text]" value="<?php if ( ! empty( $options[ 'copyright_text' ] ) ) printf( esc_attr( '%s', 'mycountdown' ), $options[ 'copyright_text' ] ); ?>" />
										<label for="theme_options[copyright_text]"><?php _e( 'Enter your copyright text here', 'mycountdown' ); ?></label>
									</div>
								</div>
								<hr>
								<div class="row">
									<div class="span2">
										<b><?php _e( 'About Us Title', 'mycountdown' ); ?></b>
									</div>
									<div class="span10">
										<input id="theme_options[about_us_title]" type="text" name="theme_options[about_us_title]" value="<?php if ( ! empty( $options[ 'about_us_title' ] ) ) printf( esc_attr( '%s', 'mycountdown' ), $options[ 'about_us_title' ] ); ?>" />
										<label for="theme_options[about_us_title]"><?php _e( 'Enter the about us section title here', 'mycountdown' ); ?></label>
									</div>
								</div>
								<div class="row">
									<div class="span2">
										<b><?php _e( 'About Us Text', 'mycountdown' ); ?></b>
									</div>
									<div class="span10">
										<textarea id="theme_options[about_us_text]"
												  class="large-text" cols="50" rows="10" name="theme_options[about_us_text]"><?php if ( ! empty( $options[ 'about_us_text' ] ) ) echo esc_textarea( $options[ 'about_us_text' ] ); ?></textarea>
										<label for="theme_options[about_us_text]"><?php _e( 'Insert about us content here.', 'mycountdown' ); ?></label>
									</div>
								</div>
								<hr>
								<div class="row">
									<div class="span2">
										<b><?php _e( 'Contact Us Title', 'mycountdown' ); ?></b>
									</div>
									<div class="span10">
										<input id="theme_options[contact_us_title]" type="text" name="theme_options[contact_us_title]" value="<?php if ( ! empty( $options[ 'contact_us_title' ] ) ) printf( esc_attr( '%s', 'mycountdown' ), $options[ 'contact_us_title' ] ); ?>" />
										<label for="theme_options[contact_us_title]"><?php _e( 'Enter the about us section title here', 'mycountdown' ); ?></label>
									</div>
								</div>
								<div class="row">
									<div class="span2">
										<b><?php _e( 'Contact Us E-Mail', 'mycountdown' ); ?></b>
									</div>
									<div class="span10">
										<input id="theme_options[email]" type="text" name="theme_options[email]" value="<?php if ( ! empty( $options[ 'email' ] ) ) printf( esc_attr( '%s', 'mycountdown' ), $options[ 'email' ] ); ?>" />
										<label for="theme_options[email]"><?php _e( 'Enter your email here', 'mycountdown' ); ?></label>
									</div>
								</div>
								<div class="row">
									<div class="span2">
										<b><?php _e( 'Contact Us Phone', 'mycountdown' ); ?></b>
									</div>
									<div class="span10">
										<input id="theme_options[phone]" type="text" name="theme_options[phone]" value="<?php if ( ! empty( $options[ 'phone' ] ) ) printf( esc_attr( '%s', 'mycountdown' ), $options[ 'phone' ] ); ?>" />
										<label for="theme_options[phone]"><?php _e( 'Enter your phone number here', 'mycountdown' ); ?></label>
									</div>
								</div>
								<div class="row">
									<div class="span2">
										<b><?php _e( 'Show Contact Form', 'mycountdown' ); ?></b>
									</div>
									<div class="span10">
										<input id="theme_options[show_contact_form]" name="theme_options[show_contact_form]" type="checkbox" value="1"
											   <?php if ( ! empty( $options[ 'show_contact_form' ] ) ) checked( '1', $options[ 'show_contact_form' ] ); ?> />
									</div>
								</div>
								<hr>
								<div class="row">
									<div class="span2">
										<b><?php _e( 'Map Title', 'mycountdown' ); ?></b>
									</div>
									<div class="span10">
										<input id="theme_options[map_title]" type="text" name="theme_options[map_title]" value="<?php if ( ! empty( $options[ 'map_title' ] ) ) printf( esc_attr( '%s', 'mycountdown' ), $options[ 'map_title' ] ); ?>" />
										<label for="theme_options[map_title]"><?php _e( 'Enter your phone number here', 'mycountdown' ); ?></label>
									</div>
								</div>
								<div class="row">
									<div class="span2">
										<b><?php _e( 'Show Google Map', 'mycountdown' ); ?></b>
									</div>
									<div class="span10">
										<input id="theme_options[show_footer_map]" name="theme_options[show_footer_map]" type="checkbox" value="1"
											   <?php if ( ! empty( $options[ 'show_footer_map' ] ) ) checked( '1', $options[ 'show_footer_map' ] ); ?> />
									</div>
								</div>
								<div class="row">
									<div class="span2">
										<b><?php _e( 'Google Map Code', 'mycountdown' ); ?></b>
									</div>
									<div class="span10">
										<textarea id="theme_options[footer_map]"
												  class="large-text" cols="50" rows="10" name="theme_options[footer_map]"><?php if ( ! empty( $options[ 'footer_map' ] ) ) echo esc_textarea( $options[ 'footer_map' ] ); ?></textarea>
										<label for="theme_options[footer_map]"><?php _e( 'Insert google map code content here (See documentation for help).', 'mycountdown' ); ?></label>
									</div>
								</div>
								<div class="row">
									<div class="span2">
										<b><?php _e( 'Show Address', 'mycountdown' ); ?></b>
									</div>
									<div class="span10">
										<input id="theme_options[show_address]" name="theme_options[show_address]" type="checkbox" value="1"
											   <?php if ( ! empty( $options[ 'show_address' ] ) ) checked( '1', $options[ 'show_address' ] ); ?> />
									</div>
								</div>
								<div class="row">
									<div class="span2">
										<b><?php _e( 'Address', 'mycountdown' ); ?></b>
									</div>
									<div class="span10">
										<textarea id="theme_options[address]"
												  class="large-text" cols="30" rows="10" name="theme_options[address]"><?php if ( ! empty( $options[ 'address' ] ) ) echo esc_textarea( $options[ 'address' ] ); ?></textarea>
										<label for="theme_options[address]"><?php _e( 'Address that will be displayed in the footer.', 'mycountdown' ); ?></label>
									</div>
								</div>
							</div>
							<!--================================Subscriptions===================================-->
							<div class="tab-pane fade" id="subscription">
								<div class="row">
									<div class="span4">
										<b><?php _e( 'Subscriber e-mail', 'mycountdown' ); ?></b>
									</div>
									<div class="span8">
										<b><?php _e( 'Subscribtion Date', 'mycountdown' ); ?></b>
									</div>
								</div>

								<?php
								$file = file_get_contents( 'subscriptions.txt', FILE_USE_INCLUDE_PATH );
								$subscriptions = explode( "\n", $file );
								?>
								<?php foreach ( $subscriptions as $subscription ) : ?>
									<div class="row">
										<div class="span12">
											<p><?php echo $subscription ?></p>
										</div>
									</div>
								<?php endforeach; ?>
							</div>
							<div class="row">
								<div class="span12">
									<input class="btn btn-success btn-large" type="submit" value="<?php _e( 'Save Options', 'mycountdown' ); ?>" />
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
			<form method="post" action="admin.php?page=custom_theme_settings">
				<div class="form-actions">
					<div class="row">
						<div class="span6">
							<input type="submit" id="import_button" value="Import default demo options" class="btn btn-info btn-large">
						</div>
					</div>
					<input class="input-xlarge" id="import_code" name="import_code" type="hidden" placeholder="Import Code" value="YTozMDp7czo5OiJsb2dvX3RleHQiO3M6MTE6
						   Ik15Q291bnRkb3duIjtzOjEzOiJsb2dvX2ltZ19saW5rIjtzOjA6IiI7czo4OiJsb2dvX2ltZyI7czowOiIiO3M6MTY6ImZhdmljb25faW1nX2xpbmsiO3M6MDoiIjtzOjE5OiJmYXZp
						   Y29uX2ltZ19jYXB0aW9uIjtzOjc6ImZhdmljb24iO3M6OToiZGF0ZV9mcm9tIjtzOjEwOiIwMS8wMS8yMDEzIjtzOjc6ImRhdGVfdG8iO3M6MTA6IjA5LzAxLzIwMTMiO3M6MTA6InNo
						   b3dzb2NpYWwiO3M6MToiMSI7czoxMzoic2hvd19mYWNlYm9vayI7czoxOiIxIjtzOjU6ImZidXJsIjtzOjM0OiJodHRwOi8vd3d3LmZhY2Vib29rLmNvbS9XaW5pVGhlbWVzIjtzOjE1
						   OiJzaG93X2dvb2dsZXBsdXMiO3M6MToiMSI7czoxNDoiZ29vZ2xlcGx1c191cmwiO3M6NDU6Imh0dHBzOi8vcGx1cy5nb29nbGUuY29tLzEwMDA2MDE2Mzc2NjY0MjAzMjczMyI7czox
						   Mjoic2hvd190d2l0dGVyIjtzOjE6IjEiO3M6OToidHdpdHRlcmlkIjtzOjEwOiJ3aW5pdGhlbWVzIjtzOjk6InR3ZWV0c19uciI7czoxOiIyIjtzOjExOiJzaG93X2ZsaWNrciI7czox
						   OiIxIjtzOjEwOiJmbGlja3JfdXJsIjtzOjQzOiJodHRwOi8vd3d3LmZsaWNrci5jb20vcGhvdG9zL2dyZWVucGVhY2UtbnovIjtzOjE0OiJzaG93X2NvcHlyaWdodCI7czoxOiIxIjtz
						   OjE0OiJjb3B5cmlnaHRfdGV4dCI7czozNzoiwqkgMjAxMiBDT1VOVERPV04gLSBERVNJR04gQlkgUkVEIFNLWSI7czoxNDoiYWJvdXRfdXNfdGl0bGUiO3M6ODoiQWJvdXQgVXMiO3M6
						   MTM6ImFib3V0X3VzX3RleHQiO3M6MTYzOiJMb3JlbSBpcHN1bSBkb2xvciBzaXQgYW1ldCwgY29uc2VjdGV0dXIgYWRpcGlzY2luZyBlbGl0LiBTZWQgaXBzdW0gc2VtLCBlZ2VzdGFz
						   IGF0IGNvbmRpbWVudHVtLiBDb25zZWN0ZXR1ciBhZGlwaXNjaW5nIGVsaXQsIHNlZCBpcHN1bSBzZW0sIGVnZXN0YXMgYXQgY29uZGltZW50dW0uIjtzOjE2OiJjb250YWN0X3VzX3Rp
						   dGxlIjtzOjEwOiJDb250YWN0IFVzIjtzOjU6ImVtYWlsIjtzOjEzOiJ3cEByZWQtc2t5LnBsIjtzOjU6InBob25lIjtzOjE3OiIoMTIzKSA0NTYgNzg5IDMzMyI7czoxNzoic2hvd19j
						   b250YWN0X2Zvcm0iO3M6MToiMSI7czo5OiJtYXBfdGl0bGUiO3M6ODoiTG9jYXRpb24iO3M6MTU6InNob3dfZm9vdGVyX21hcCI7czoxOiIxIjtzOjEwOiJmb290ZXJfbWFwIjtzOjc2
						   NToiPGlmcmFtZSB3aWR0aD0iNDI1IiBoZWlnaHQ9IjM1MCIgZnJhbWVib3JkZXI9IjAiIHNjcm9sbGluZz0ibm8iIG1hcmdpbmhlaWdodD0iMCIgbWFyZ2lud2lkdGg9IjAiIHNyYz0i
						   aHR0cHM6Ly9tYXBzLmdvb2dsZS5jb20vbWFwcz9mPXEmYW1wO3NvdXJjZT1zX3EmYW1wO2hsPWVuJmFtcDtnZW9jb2RlPSZhbXA7cT1tYW5oYXR0YW4mYW1wO2FxPSZhbXA7c2xsPTM3
						   LjA2MjUsLTk1LjY3NzA2OCZhbXA7c3Nwbj01Ny41MTA3MjMsMTM1LjI2MzY3MiZhbXA7aWU9VVRGOCZhbXA7aHE9JmFtcDtobmVhcj1NYW5oYXR0YW4sK05ldytZb3JrJmFtcDtsbD00
						   MC43OTAyNzgsLTczLjk1OTcyMiZhbXA7c3BuPTAuMDI3MjYxLDAuMDY2MDQ3JmFtcDt0PW0mYW1wO3o9MTQmYW1wO291dHB1dD1lbWJlZCI+PC9pZnJhbWU+PGJyIC8+PHNtYWxsPjxh
						   IGhyZWY9Imh0dHBzOi8vbWFwcy5nb29nbGUuY29tL21hcHM/Zj1xJmFtcDtzb3VyY2U9ZW1iZWQmYW1wO2hsPWVuJmFtcDtnZW9jb2RlPSZhbXA7cT1tYW5oYXR0YW4mYW1wO2FxPSZh
						   bXA7c2xsPTM3LjA2MjUsLTk1LjY3NzA2OCZhbXA7c3Nwbj01Ny41MTA3MjMsMTM1LjI2MzY3MiZhbXA7aWU9VVRGOCZhbXA7aHE9JmFtcDtobmVhcj1NYW5oYXR0YW4sK05ldytZb3Jr
						   JmFtcDtsbD00MC43OTAyNzgsLTczLjk1OTcyMiZhbXA7c3BuPTAuMDI3MjYxLDAuMDY2MDQ3JmFtcDt0PW0mYW1wO3o9MTQiIHN0eWxlPSJjb2xvcjojMDAwMEZGO3RleHQtYWxpZ246
						   bGVmdCI+VmlldyBMYXJnZXIgTWFwPC9hPjwvc21hbGw+IjtzOjEyOiJzaG93X2FkZHJlc3MiO3M6MToiMSI7czo3OiJhZGRyZXNzIjtzOjMzOiI1MDAgUGFjaWZpYyBBdmVudWUsIE5l
						   dyBZb3JrLCBVU0EiO30=" />
					<div class="row">
						<div class="span12">
							<span class="label label-info"><?php _e( 'Note :', 'mycountdown' ); ?></span><?php _e( ' If you pressed the "Import default demo options" button accidently just reload the page without saving the options.', 'mycountdown' ); ?>
						</div>
					</div>
				</div>
			</form>
		</div>
		<?php
	}

//=======Customizer=========
	function theme_customize_register( $wp_customize ) {

		//Settings--------------------
		$wp_customize->add_setting( 'site_color', array(
			'default' => 'black',
			'transport' => 'refresh',
		) );


		//Sections-------------------
		$wp_customize->add_section( 'site_color', array(
			'title' => __( 'Color', 'theme' ),
			'priority' => 40,
		) );


		//Controls-------------------

		$wp_customize->add_control( 'font', array(
			'label' => __( 'Site Color', 'theme' ),
			'section' => 'site_color',
			'settings' => 'site_color',
			'type' => 'radio',
			'choices' => array(
				"black" => "Black",
				"azure" => "Azure",
				"cherry" => "Cherry",
				"beige" => "Beige",
				"brown" => "Brown",
				"green" => "Green",
				"purple" => "Purple",
			),
		) );
	}

	add_action( 'customize_register', 'theme_customize_register' );

	function theme_customize_css() {
		wp_enqueue_style( 'countdown_color_css', get_template_directory_uri() . '/colors/' . get_theme_mod( 'site_color' ) . '/css/style.css' );
	}

	add_action( 'wp_enqueue_scripts', 'theme_customize_css' );

//===========================+++++Breadcrumbs+++++++========================
	function dimox_breadcrumbs() {

		$showOnHome = 1; // 1 - show breadcrumbs on the homepage, 0 - don't show
		$delimiter = '/'; // delimiter between crumbs
		$home = 'Home'; // text for the 'Home' link
		$showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
		$before = '<a class="active">'; // tag before the current crumb
		$after = '</a>'; // tag after the current crumb

		global $post;
		$homeLink = home_url( 'url' );

		if ( is_home() || is_front_page() ) {

			if ( $showOnHome == 1 )
				echo '<a href="' . $homeLink . '">' . $home . '</a></div>';
		} else {

			echo '<a href="' . $homeLink . '">' . $home . '</a> ' . $delimiter . ' ';

			if ( is_category() ) {
				$thisCat = get_category( get_query_var( 'cat' ), false );
				if ( $thisCat->parent != 0 )
					echo get_category_parents( $thisCat->parent, TRUE, ' ' . $delimiter . ' ' );
				echo $before . 'Archive by category "' . single_cat_title( '', false ) . '"' . $after;
			} elseif ( is_search() ) {
				echo $before . 'Search results for "' . get_search_query() . '"' . $after;
			} elseif ( is_day() ) {
				echo '<a href="' . get_year_link( get_the_time( 'Y' ) ) . '">' . get_the_time( 'Y' ) . '</a> ' . $delimiter . ' ';
				echo '<a href="' . get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ) . '">' . get_the_time( 'F' ) . '</a> ' . $delimiter . ' ';
				echo $before . get_the_time( 'd' ) . $after;
			} elseif ( is_month() ) {
				echo '<a href="' . get_year_link( get_the_time( 'Y' ) ) . '">' . get_the_time( 'Y' ) . '</a> ' . $delimiter . ' ';
				echo $before . get_the_time( 'F' ) . $after;
			} elseif ( is_year() ) {
				echo $before . get_the_time( 'Y' ) . $after;
			} elseif ( is_single() && ! is_attachment() ) {
				if ( get_post_type() != 'post' ) {
					$post_type = get_post_type_object( get_post_type() );
					$slug = $post_type->rewrite;
					echo '<a href="' . $homeLink . '/' . $slug[ 'slug' ] . '/">' . $post_type->labels->singular_name . '</a>';
					if ( $showCurrent == 1 )
						echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;
				} else {
					$cat = get_the_category();
					$cat = $cat[ 0 ];
					$cats = get_category_parents( $cat, TRUE, ' ' . $delimiter . ' ' );
					if ( $showCurrent == 0 )
						$cats = preg_replace( "#^(.+)\s$delimiter\s$#", "$1", $cats );
					echo $cats;
					if ( $showCurrent == 1 )
						echo $before . get_the_title() . $after;
				}
			} elseif ( ! is_single() && ! is_page() && get_post_type() != 'post' && ! is_404() ) {
				$post_type = get_post_type_object( get_post_type() );
				echo $before . $post_type->labels->singular_name . $after;
			} elseif ( is_attachment() ) {
				$parent = get_post( $post->post_parent );
				$cat = get_the_category( $parent->ID );
				$cat = $cat[ 0 ];
				echo get_category_parents( $cat, TRUE, ' ' . $delimiter . ' ' );
				echo '<a href="' . get_permalink( $parent ) . '">' . $parent->post_title . '</a>';
				if ( $showCurrent == 1 )
					echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;
			} elseif ( is_page() && ! $post->post_parent ) {
				if ( $showCurrent == 1 )
					echo $before . get_the_title() . $after;
			} elseif ( is_page() && $post->post_parent ) {
				$parent_id = $post->post_parent;
				$breadcrumbs = array( );
				while ( $parent_id ) {
					$page = get_page( $parent_id );
					$breadcrumbs[ ] = '<a href="' . get_permalink( $page->ID ) . '">' . get_the_title( $page->ID ) . '</a>';
					$parent_id = $page->post_parent;
				}
				$breadcrumbs = array_reverse( $breadcrumbs );
				for ( $i = 0; $i < count( $breadcrumbs ); $i ++  ) {
					echo $breadcrumbs[ $i ];
					if ( $i != count( $breadcrumbs ) - 1 )
						echo ' ' . $delimiter . ' ';
				}
				if ( $showCurrent == 1 )
					echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;
			} elseif ( is_tag() ) {
				echo $before . 'Posts tagged "' . single_tag_title( '', false ) . '"' . $after;
			} elseif ( is_author() ) {
				global $author;
				$userdata = get_userdata( $author );
				echo $before . 'Articles posted by ' . $userdata->display_name . $after;
			} elseif ( is_404() ) {
				echo $before . 'Error 404' . $after;
			}

			if ( get_query_var( 'paged' ) ) {
				if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() )
					echo ' (';
				echo __( 'Page', 'theme' ) . ' ' . get_query_var( 'paged' );
				if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() )
					echo ')';
			}
		}
	}

// end dimox_breadcrumbs()

//=======================Twitter==========================
require_once 'php/twitter.php';

///===================================TeslaSecurity Check==================================
function tt_get_username(){
    if(file_exists(get_template_directory() . '/theme_config/tt_license.txt'))
        if($username = file_get_contents(get_template_directory() . '/theme_config/tt_license.txt'))
            return base64_decode($username);
    return NULL;
}

function tt_check_username(){
    $state='';
    $username = tt_get_username();
    if ($username){
        $result = get_transient( 'security_api_result' );
        if(!$result){
    			if(ini_get('allow_url_fopen')){
					$api = file_get_contents( 'http://teslathemes.com/amember/api/check-access/by-login?_key=n7RYtMjOm9qjzmiWQlta&login=' . $username);
				}
				if(empty($api) && function_exists('curl_init')){
					$api = curl_get_file_contents('http://teslathemes.com/amember/api/check-access/by-login?_key=n7RYtMjOm9qjzmiWQlta&login=' . $username);
				}
				if(!empty($api)){
					$result = json_decode($api);
					set_transient( 'security_api_result', $result, 30 * MINUTE_IN_SECONDS );
				}else{
					$this->state = 'no data' ;
				}
		}

        if ( !(empty($result->ok)) ){  //if username exists
            if (!empty($result->subscriptions)){    //if any active subscriptions or blocked product active
                if ( !empty($result->subscriptions->{28}) ){    //if any blocking product active
                    $state = 'blocked' ;
                }elseif(!empty($result->subscriptions->{34})){  //if any warning product active
                    $state = 'warning' ;
                }
            }
        }elseif( !in_array( $username, array( 'tt_general_user','tt_other_marketplaces_user' ) ) )
            $state = 'corrupt';

    }else
        $state = 'corrupt';
    return $state;
}

function curl_get_file_contents($URL){
    $c = curl_init();
    curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($c, CURLOPT_URL, $URL);
    $contents = curl_exec($c);
    curl_close($c);

    if ($contents) 
    	return $contents;
    else 
    	return FALSE;
}

function tt_security_check(){ // call this function somewhere in the page code to block it if account disabled on TT
    $state = tt_check_username();
    return tt_throw_errors($state);
}

function tt_throw_errors($state){
    switch ($state) {
        case 'active':
            break;
        case 'warning' :
            tt_error_message($state,true);
            break;
        case 'no data':
            tt_error_message($state,true);
            break;
        case 'blocked':
            tt_error_message($state);
            return FALSE;
        case 'corrupt':
            tt_error_message($state, NULL, "<span>Note :</span> Don't change the code or license file contents please.");
            return FALSE;
    }
    return TRUE;
}

function tt_error_message($state,$just_warning=NULL,$custom=NULL){
    echo "<div id='result_content'><div id='tt_import_alert'>";
    if ( $custom )
        echo $custom;
    if ( $just_warning )
        echo '<span>WARNING :</span> We noticed some fraudulous activity with our theme or couldn\'t connect to our servers for some reasons. Please contact us in 5 days to fix this or framework page will be blocked.<br> <span>State : ' . $state . '</span>';
    else
        echo 'The options page is <span>blocked</span> by TeslaThemes due to some <span>fraudulous action</span>.<br> Please contact us at hi@teslathemes.com or click the link below to correct your license if you think that this is a mistake. <br><span>State : ' . $state . '</span>';
    echo "</div><a href='http://teslathemes.com/contact/' class='btn'>Contact TeslaThemes</a></div>";
    return;
}