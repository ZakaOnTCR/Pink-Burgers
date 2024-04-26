<?php

$top_header = get_field ("header_top" , 'option');

//r row bottom header
$h_logo           = get_field('h_logo', 'option');

// Retrieve settings from settings page
$sticky_menu = get_field('setting_sticky_header_name', 'option');

if ($sticky_menu) {

	$sticky_class = 'sticky-menu';
} else {

	$sticky_class = '';
}

?>



<div class='row header top-header'>

    <div class='full-row'>

        <div class='blocks-container'>
                <div class="block text">
                    <?= $top_header ?>
                    </div>

     <div class="blocks-group logo-group">
                <div class="block image">
                   
                </div>
                        
            </div>

            <div class="blocks-group menu-group">
                <!-- Hier komt je menu-inhoud -->
            </div>

        </div>

    </div>

</div>


<div class='row header bottom-header <?= $sticky_class; ?>'>

	<div class='full-row'>

		<div class='blocks-container'>

			

			<div class="blocks-group menu-group">
            <?php if ($h_logo) { ?>
				<div class="blocks-group logo-group">
					<div class="block image">
						<a href="/"><img src="<?= $h_logo ?>" alt=""></a>
					</div>
				</div>
			<?php } ?>

				<?php minimal210_menu(); ?>

				<div class="header-wrap">
					<?php minimal210_search_icon(); ?>

					<?php min_responsive_menu_button('Hoofdmenu'); ?>

					<?php if (have_rows($h_button_repeater, 'option')) { ?>
						<?= minimal_button_repeater($h_button_repeater); ?>
					<?php } ?>
				</div>

			</div>

		</div>

	</div>

	<?php min_responsive_menu('Hoofdmenu'); ?>

</div>
