<?php
/**
 * The template for displaying search forms
 */
?>
<form method="get" class="search_bar" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
    <input type="text" class="search_bar_line" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" id="s" placeholder="<?php esc_attr_e( 'Search', 'mycountdown' ); ?>" />
    <input type="submit" class="search_bar_button" name="submit" id="searchsubmit" value="" />
</form>
