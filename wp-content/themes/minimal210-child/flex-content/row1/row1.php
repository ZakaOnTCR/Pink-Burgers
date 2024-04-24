<?php
$current_name = get_row_layout(); // Name of the row


// -- Row 1 - Content -- //
$row1_rep = 'row1_rep';
$row1_image = get_sub_field("row1_tekst_afbeelding");
// -- Row 1 - Settings -- //
$row1_slider_size = get_sub_field("row1_slider_size");

//Padding configuration
$padding_name = $current_name . '_set_padding';
$padding_field = get_sub_field($padding_name);
$row_padding = $padding_field;

//ID configuration
$id_name = $current_name . '_set_id';
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

<section class="row flex-content <?= $current_name ?> <?= $row1_slider_size ?>">
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