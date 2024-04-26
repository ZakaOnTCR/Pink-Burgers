<?php

$current_name = get_row_layout(); // Name of the row

$row7_iframe = get_sub_field("row7_iframe_contact");
$row7_text = get_sub_field("row7_wysiwyg_contact");
$row7_text2 = get_sub_field("row7_wysiwyg2_contact");

?>

<section class="row7  flex-content <?= $current_name ?>">
    <div class="full-row">
        <div class="blocks-container">
            <div class="block left">
                <?= $row7_text ?>
            </div>
            <div class="block right">
                <?php echo do_shortcode('[ninja_form id=1]'); ?>
                <div class="block text">
                    <div class="block link">
                        <?= $row7_text2 ?>
                    </div>
                    <?= $row7_iframe ?>
                </div>
            </div>


        </div>
    </div>
</section>