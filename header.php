<!DOCTYPE HTML>
<html class="no-js" <?php language_attributes(); ?>>
    <head>
		<?php
		//=======get theme options from admin panel
		global $options;
		$options = get_option( 'theme_options' );
		?>
        <title><?php bloginfo( 'name' ); ?><?php wp_title( '|' ); ?></title>
        <meta charset="<?php bloginfo( 'charset' ); ?>" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="keywords" content="themes, wordpress, responsive, premium, drops, under construction">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"><!-- Remove if you're not building a responsive site. (But then why would you do such a thing?) -->
        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
        <link rel="shortcut icon" href="<?php echo get_favicon( $options ) ?>"/>
		<!--    get the template directory for javascript use later    -->
        <script type="text/javascript">
            var templateDir = "<?php echo get_template_directory_uri() ?>";
        </script>
		<?php wp_head(); ?>
    </head>
    <body <?php body_class(); ?>>
        <div id="site_menu_hide">
			<?php
			$arguments = array(
				'theme_location' => 'side_menu',
				'menu' => '',
				'container' => '',
				'container_class' => '',
				'container_id' => '',
				'menu_class' => 'site_menu',
				'menu_id' => '',
				'echo' => true,
				'fallback_cb' => 'wp_page_menu',
				'before' => '',
				'after' => '',
				'link_before' => '<span>',
				'link_after' => '</span><span class="site_menu_nr"></span>',
				'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
				'depth' => 0,
				'walker' => ''
			);

			wp_nav_menu( $arguments );
			?>
        </div>