<?php
/**
 * The template for displaying all pages.
 *
 */
get_header();
?>
<div class="container homepage">
    <div class="sidebar">
        <h1><?php echo get_logo( $options ); ?></h1>
        <div class="working"></div>
        <h3 class="available"><?php _e( 'It will be available for you:', 'mycountdown' ); ?></h3>
        <div class="arrow"></div>
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
						<li><a href="<?php if ( isset( $options[ 'fburl' ] ) ) echo $options[ 'fburl' ]  ?>" class="facebook show-tooltip" title="Facebook"></a></li>
					<?php endif; ?>
					<?php if ( isset( $options[ 'show_flickr' ] ) ) : ?>
						<li><a href="<?php if ( isset( $options[ 'flickr_url' ] ) ) echo $options[ 'flickr_url' ]  ?>" class="flikr show-tooltip" title="Flikr"></a></li>
					<?php endif; ?>
					<?php if ( isset( $options[ 'show_googleplus' ] ) ) : ?>
						<li><a href="<?php if ( isset( $options[ 'googleplus_url' ] ) ) echo $options[ 'googleplus_url' ] ?>" class="google show-tooltip" title="Google+"></a></li>
					<?php endif; ?>
				</ul>
			<?php endif; ?>
            <div class="clear"></div>
        </div>
    </div>
    <div class="content">
        <div class="top_line"></div>
        <div class="top_head"></div>
        <div class="bottle_box">
            <div id="days" class="bottle">
                <div class="bottle_section">
                    <div class="overflow">
                        <div class="fill fill_d"></div>
                        <div class="drop drop_d"></div>
                    </div>
                    <div class="bottle_bg"></div>
                </div>
                <div class="bottle_counter bottle_d">58</div>
            </div>
            <div id="hours" class="bottle">
                <div class="bottle_section">
                    <div class="overflow">
                        <div class="fill fill_h"></div>
                        <div class="drop drop_h"></div>
                    </div>
                    <div class="bottle_bg"></div>
                </div>
                <div class="bottle_counter bottle_h">17</div>
            </div>
            <div id="minutes" class="bottle">
                <div class="bottle_section">
                    <div class="overflow">
                        <div class="fill fill_m"></div>
                        <div class="drop drop_m"></div>
                    </div>
                    <div class="bottle_bg"></div>
                </div>
                <div class="bottle_counter bottle_m">44</div>
            </div>
            <div id="seconds" class="bottle_last">
                <div class="bottle_section">
                    <div class="overflow">
                        <div class="fill fill_s"></div>
                        <div class="drop drop_s"></div>
                    </div>
                    <div class="bottle_bg"></div>
                </div>
                <div class="bottle_counter bottle_s">37</div>
            </div>
            <div class="clear"></div>
        </div>
    </div>
    <div class="clear"></div>
    <div class="scroll"></div>
</div>
<?php get_footer(); ?>