<?php
/**
 * @category 	Header
 * @author 		Wilco
 * @since 		2-3-2017
 * @version 	1.1
 */

// Retrieve settings from settings page
$sticky_menu = get_field('setting_sticky_header_name','option');

if($sticky_menu){

	$sticky_class = 'sticky-menu';
}else{

	$sticky_class = '';
}

?>

<div class='row <?php echo $sticky_class; ?>'>

	<div class='full-row'>

		<div class='blocks-container '>

			<?php minimal210_menu(); ?>

			<?php minimal210_search_icon(); ?>

		</div> <!-- blocks-container -->

	</div> <!-- full-row -->

</div> <!-- row -->