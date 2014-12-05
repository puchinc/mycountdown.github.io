<?php
//=======get theme options from admin panel
global $options;
$options = get_option( 'theme_options' );
?>
<!-- ===== START FOOTER ===== -->

<div id="footer">
	<?php if ( isset( $options[ 'show_footer' ] ) ) : ?>
		<div class="tabs_select">
			<ul class="center_align">
				<li class="news_tab active"><?php _e('News','mycountdown')?></li>
				<li class="contact_tab"><?php _e('Contact','mycountdown')?></li>
			</ul>
			<div class="clear"></div>
		</div>
		<div class="wrapper">
			<div class="container">
				<div class="tab_news">
					<div class="sidebar_left">
						<h4><?php _e('Latest news :','mycountdown')?></h4>
						<div class="news_tab_selection">
							<?php
							query_posts( "posts_per_page=3" );
							if ( have_posts() ) : while ( have_posts() ) : the_post();
									?>
									<div class="news_tabs" id="<?php the_ID(); ?>">
										<div class="news_img">
											<?php
											if ( has_post_thumbnail() ) {
												the_post_thumbnail( array( 60, 86 ) );
											}else
												echo "<img src='" . get_template_directory_uri() . "/images/comment_author.png' alt='thumb'>"
												?>
										</div>
										<h5><?php the_title(); ?></h5>
										<span class="time"><?php echo get_the_date( 'j.m.Y' ); ?></span>
										<?php
										the_excerpt();
										?>
									</div>
								<?php endwhile; ?>
							<?php else: ?>
								<h2><?php _e('No News...','mycountdown')?></h2>
							<?php endif; ?>
						</div>
					</div>
					<div class="content_right">
						<h4><?php _e('Full description :','mycountdown')?></h4>
						<?php if ( have_posts() ): ?>
							<?php while ( have_posts() ) : the_post(); ?>
								<div class="news_content" id="post-content-<?php the_ID() ?>">
									<?php if ( has_post_thumbnail() ) : ?>
										<div class="news_content_img">
											<?php the_post_thumbnail( array( 161, 230 ) ) ?>
										</div>
									<?php endif; ?>
									<h5><?php the_title(); ?></h5>
									<span class="time"><?php echo get_the_date( 'j.m.Y' ); ?></span>
									<?php
									add_filter( 'the_content', 'strip_images' );
									add_filter( 'the_content', 'cut_content_small' );
									the_content();
									?>
									<div class="clear"></div>
								</div>
							<?php endwhile; ?>
						<?php else: ?>
							<h2><?php _e('No posts to display','mycountdown')?></h2>
						<?php endif; ?>
					</div>
					<div class="clear"></div>
				</div>
				<div class="tab_contact">
					<div class="row">
						<div class="column">
							<?php if ( isset( $options[ 'about_us_title' ] ) || isset( $options[ 'about_us_text' ] ) ) : ?>
								<h4>
									<?php if ( isset( $options[ 'about_us_title' ] ) ) : ?>
										<?php echo $options[ 'about_us_title' ] ?>
									<?php endif; ?>
								</h4>
								<p class="acolad">
									<?php if ( isset( $options[ 'about_us_text' ] ) ) : ?>
										<?php echo $options[ 'about_us_text' ] ?>
									<?php endif; ?>
								</p>
							<?php endif; ?>
						</div>
						<div class="column">
							<?php if ( isset( $options[ 'contact_us_title' ] ) || isset( $options[ 'email' ] ) || isset( $options[ 'phone' ] ) || isset( $options[ 'show_contact_form' ] ) ) : ?>
								<h4>
									<?php if ( isset( $options[ 'contact_us_title' ] ) ) : ?>
										<?php echo $options[ 'contact_us_title' ] ?>
									<?php endif; ?>
								</h4>
								<div class="acolad">
									<p class="email"><a href="mailto:<?php if ( isset( $options[ 'email' ] ) ) echo $options[ 'email' ] ?>"><?php if ( isset( $options[ 'email' ] ) ) echo $options[ 'email' ] ?></a></p>
									<p class="telephone"><?php if ( isset( $options[ 'phone' ] ) ) echo $options[ 'phone' ] ?></p>
								</div>
								<?php if ( isset( $options[ 'show_contact_form' ] ) ) : ?>
									<form class="contact_form">
										<input class="line" name="name" placeholder="Name" type="text">
										<input class="line" name="email"  placeholder="E-mail" type="text">
										<textarea class="linearea" name="message"  placeholder="Message" cols="8" rows="8"></textarea>
										<input class="send" name="send" type="submit" value="SEND">
										<input type="hidden" name="receiver_mail" value="<?php if ( isset( $options[ 'email' ] ) ) echo $options[ 'email' ] ?>">
									</form>
									<div id="contact_form_result"></div>
								<?php endif; ?>
							<?php endif; ?>
						</div>
						<?php if ( isset( $options[ 'show_footer_map' ] ) || isset( $options[ 'show_address' ] ) || isset( $options[ 'map_title' ] ) ) : ?>
							<div class="column">
								<h4>
									<?php if ( isset( $options[ 'map_title' ] ) ) : ?>
										<?php echo $options[ 'map_title' ] ?>
									<?php endif; ?>
								</h4>

								<?php if ( isset( $options[ 'show_footer_map' ] ) ) : ?>
									<div class="google_maps">
										<?php
										if ( isset( $options[ 'footer_map' ] ) ) {
											$map = $options[ 'footer_map' ];
											$map = preg_replace( '@height="[0-9]+"@is', 'height="200"', $map );
											$map = preg_replace( '@<a(.*?)</a>@is', '', $map );
											echo preg_replace( '@width="[0-9]+"@is', 'width="100%"', $map );
										}
										?>
									</div>
								<?php endif; ?>
								<?php if ( isset( $options[ 'show_address' ] ) ) : ?>
									<p class="location">
										<?php if ( isset( $options[ 'address' ] ) ) echo $options[ 'address' ] ?>
									</p>
								<?php endif; ?>
							</div>
						<?php endif; ?>
						<div class="clear"></div>
					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>


<div class="container copyright">
	<?php if ( isset( $options[ 'show_copyright' ] ) ) : ?>
		<?php if ( isset( $options[ 'copyright_text' ] ) ) echo $options[ 'copyright_text' ] ?>
	<?php endif; ?>
</div>
	</div>
<div id="show_footer" style="display: none"><?php if ( isset( $options[ 'show_footer' ] ) ) echo $options[ 'show_footer' ]; else echo '0' ?></div>
<div id="date_from" style="display: none"><?php if ( isset( $options[ 'date_from' ] ) ) echo $options[ 'date_from' ] ?></div>
<div id="date_to" style="display: none"><?php if ( isset( $options[ 'date_to' ] ) ) echo $options[ 'date_to' ] ?></div>
<!-- ===== END FOOTER ===== -->
<?php wp_footer(); ?>
</body>
</html>