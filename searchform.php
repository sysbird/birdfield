<?php
/**
 * The template for displaying search form.
 *
 * @package WordPress
 * @subpackage BirdFILED
 * @since BirdFILED 1.0
 */
?>
<form role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
    <input type="text" value="<?php echo esc_attr( get_search_query() ); ?>" name="s" id="s" placeholder="<?php _e('Search...', 'birdfield') ?>">
    <button type="submit" value="Search" id="searchsubmit" class="submit"><span class="screen-reader-text"><?php _e('Search...', 'birdfield') ?></span></button>
</form>