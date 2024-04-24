<?php
get_header();

if (function_exists('minimal_do_slider')) {
    minimal_do_slider();
}

$title = get_the_title();

// -- Row 1 - Content -- //
$row1_rep = 'row1_rep';
$row1_image = get_field("row1_tekst_afbeelding");
// -- Row 1 - Settings -- //
$row1_slider_size = get_sub_field("row1_slider_size");

//ID configuration
$id_name = 'row1_set_id';
$id_field = get_sub_field($id_name);
$row_id = $id_field;

if ($row_id) {
	$final_row_id = 'id="' . $row_id . '"';
} else {
	$final_row_id = '';
}

$count = 0;

if (have_rows($row1_rep)) {
	while (have_rows($row1_rep)) {
		the_row();

		$count++;
	}
}

?>

<main>

    <?php while (have_posts()) : the_post(); ?>

<section class="row flex-content row1">
	<?php if ($row_id) { ?>
		<div class="scrollto" id="<?= $row_id ?>"></div>
	<?php } ?>

	<ul class="container <?php if ($count > 1) {
		echo "slick";
	} else {
		echo "no-slick";
	} ?>">
		<?php if (have_rows($row1_rep)) { ?>
			<?php while (have_rows($row1_rep)) {
				the_row();

				$image = get_sub_field('image');
				?>

				<li class="slide <?= $row1_slider_size ?>" style="background-image: url('<?= $image ?>');">
					<div class="full-row full-height">
						<div class="blocks-container">
                           <div class="block text">

						   <?= $row1_image ?>

						
						</div>
					</div>
				</li>
			<?php } ?>
		<?php } ?>
	</ul>
</section>


        <div class='row-single single row1'>

            <div class='full-row'>

                <div class='blocks-container'>

				<div class="button-group1">
				<?php $button = 'row3_recept_button1'; ?>
					   <a href="/recepten">
					   <div class="button-text">
						
                       <i class="fa-solid fa-chevron-left"></i> TERUG NAAR HET OVERZICHT
					   </div>
						</a>
				</div>

                    <div class='block-group image-content'>
                        <?php $image = get_field('row3_recept_image'); ?>
                        <div class='image' style='background-image: url(<?= $image['url'] ?>);'></div>
                    </div>

                    <div class='block-group text-group'>
                        <?php if ($title) { ?>
                            <div class='title'>
                                <h2><?= $title ?></h2>
                            </div>
                        <?php } ?>

                        <div class='text'>
                            <?php $text = get_field('row3_recept_text'); ?>
                            <p><?= $text ?></p>
                        </div>

                        <div class='button-group'>
                            <?php $button = 'row3_recept_button2' ?>
							<?php if (have_rows($button)) { ?>
                              <?= minimal_button_repeater($button); ?>
                            <?php } ?>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    <?php endwhile; ?>

</main>

<?php get_footer(); ?>
