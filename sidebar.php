<?php
/**
 * The Sidebar containing the main widget areas.
 */
$options = get_option( 'theme_options' );
?>
<div class="sidebar">
	<h1><?php echo get_logo( $options ); ?></h1>
	<?php dynamic_sidebar( "blogsidebar" ); ?>
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
					<li><a href="<?php if ( isset( $options[ 'googleplus_url' ] ) ) echo $options[ 'googleplus_url' ]  ?>" class="google show-tooltip" title="Google+"></a></li>
				<?php endif; ?>
			</ul>
		<?php endif; ?>
		<div class="clear"></div>
	</div>
</div>