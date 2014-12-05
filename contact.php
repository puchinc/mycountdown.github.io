<?php
/*
  Template Name: MyCountdown Contact Page
 */
get_header();
?>
<div class="container contact">
    <div class="sidebar">
		<h1><?php echo get_logo( $options ); ?></h1>
        <div class="working"></div>
        <div class="separate"></div>
        <div class="subscription">
            <h3><?php _e('Enter your e-mail address','mycountdown')?></h3>
            <p><?php _e('To be notified about our launch','mycountdown')?></p>
            <form class="subscription_form" id="subscribe">
                <span class="border">
                    <input name="email" class="subscription_line email" type="text">
                </span>
                <input name="send" type="submit" class="subscription_button" value="SEND">
            </form>
            <div id="contactresult"></div>
            <div class="clear"></div>
        </div>
        <div class="social" style="<?php if ( ! isset( $options[ 'show_twitter' ] ) ) echo 'background : none' ?>">
			<?php if ( isset( $options[ 'show_twitter' ] ) ) : ?>
				<div class="twitt">
					<div class="twitter" data-user="<?php if ( isset( $options[ 'twitterid' ] ) ) echo $options[ 'twitterid' ]; ?>" data-posts="<?php if ( isset( $options[ 'tweets_nr' ] ) ) echo $options[ 'tweets_nr' ]; ?>"></div>
					<div class="arrow_twitt"></div>
				</div>
			<?php endif; ?>
			<?php if ( isset( $options[ 'showsocial' ] ) ) : ?>
				<ul class="social_icons">
					<?php if ( isset( $options[ 'show_twitter' ] ) ) : ?>
						<li><a href="http://twitter.com/<?php if ( isset( $options[ 'twitterid' ] ) ) echo $options[ 'twitterid' ]  ?>" class="twitter active show-tooltip" title="Twitter"></a></li>
					<?php endif; ?>
					<?php if ( isset( $options[ 'show_facebook' ] ) ) : ?>
						<li><a href="<?php if ( isset( $options[ 'fburl' ] ) ) echo $options[ 'fburl' ] ?>" class="facebook show-tooltip" title="Facebook"></a></li>
					<?php endif; ?>
					<?php if ( isset( $options[ 'show_flickr' ] ) ) : ?>
						<li><a href="<?php if ( isset( $options[ 'flickr_url' ] ) ) echo $options[ 'flickr_url' ]  ?>" class="flikr show-tooltip" title="Flikr"></a></li>
					<?php endif; ?>
					<?php if ( isset( $options[ 'show_googleplus' ] ) ) : ?>
						<li><a href="<?php if ( isset( $options[ 'googleplus_url' ] ) ) echo $options[ 'googleplus_url' ]  ?>" class="google show-tooltip" title="Google+"></a></li>
					<?php endif; ?>
				</ul>
			<?php endif; ?>
            <div class="clear"></div>
        </div>
    </div>
    <div class="content" id="contact_content">
        <h3 class="contact_1">
			<?php if ( isset( $options[ 'map_title' ] ) ) : ?>
				<?php echo $options[ 'map_title' ] ?>
			<?php endif; ?>
        </h3>

		<?php if ( isset( $options[ 'show_footer_map' ] ) ) : ?>
			<div class="google_maps">
				<?php
				if ( isset( $options[ 'footer_map' ] ) ) {
					$map = $options[ 'footer_map' ];
					$map = preg_replace( '@height="[0-9]+"@is', 'height="350"', $map );
					$map = preg_replace( '@<a(.*?)</a>@is', '', $map );
					echo preg_replace( '@width="[0-9]+"@is', 'width="100%"', $map );
				}
				?>
			</div>
		<?php endif; ?>
        <div class="column_3">
			<?php if ( isset( $options[ 'show_contact_form' ] ) ) : ?>
				<h3 class="contact_2"><?php _e('Write us:','mycountdown')?></h3>
				<form class="contact_form">
					<input class="contact_line" name="name" placeholder="Name" type="text">
					<input class="contact_line" name="email"  placeholder="E-mail" type="text">
					<textarea class="contact_area" name="message"  placeholder="Message" cols="8" rows="8"></textarea>
					<input class="contact_button" name="send" type="submit" value="Send">
					<input type="hidden" name="receiver_mail" value="<?php if ( isset( $options[ 'email' ] ) ) echo $options[ 'email' ] ?>">
				</form>
				<div id="contact_form_result"></div>
			<?php endif; ?>
        </div>
        <div class="column_2">
			<?php if ( isset( $options[ 'contact_us_title' ] ) || isset( $options[ 'email' ] ) || isset( $options[ 'phone' ] ) ) : ?>
				<?php if ( isset( $options[ 'contact_us_title' ] ) ) : ?>
					<h3 class="contact_3"><?php echo $options[ 'contact_us_title' ] ?></h3>
				<?php endif; ?>
				<div class="contact_info">
					<p class="contact_mail"><a href="mailto:<?php if ( isset( $options[ 'email' ] ) ) echo $options[ 'email' ] ?>"><?php if ( isset( $options[ 'email' ] ) ) echo $options[ 'email' ] ?></a></p>
					<p class="contact_phone"><?php if ( isset( $options[ 'phone' ] ) ) echo $options[ 'phone' ] ?></p>
				</div>
			</div>
		<?php endif; ?>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
    <div class="scroll"></div>
</div>

<?php get_footer(); ?>