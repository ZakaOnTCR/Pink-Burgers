<?php
/**
 * @category 	Searchform
 * @author 		Wilco
 * @since 		13-4-2017
 * @version 	1.0
 */
?>

<form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
    <input type="search" class="search-field" placeholder="<?php echo __( 'Zoeken...', 'minimal210' ); ?>" value="<?php echo get_search_query() ?>" name="s" title="<?php echo __( 'Zoeken naar:', 'minimal210' ); ?>" />
    <input type="submit" class="search-submit" value="<?php echo __( 'Zoek', 'minimal210' ) ?>" />
</form>