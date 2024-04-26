<?php

$current_name = get_row_layout(); // Name of the row

$row6_button = get_sub_field("row6_button_link");
$row6_text = get_sub_field("row6_text");
$row6_image = "row6_afbeelding";

// settings

$row6_layout = get_sub_field("row6_layout");
$row6_layout2 = get_sub_field ("row6_layout_2");
$row6_padding = get_sub_field("row6_set_padding");

?>


<section class="row flex-content <?= $current_name ?> padding-<?= $row6_padding ?> bg-<?= $row6_layout2 ?>">


    <?php if ($row6_text || $row6_button): ?>
        <div class="full-row" >
            <div class="blocks-container <?php if ($row6_layout){?>reverse<?php } ?> ">
                <?php if ($row6_text): ?>
                    <div class="block text-image">
                        <div class="text">
                        <?= $row6_text ?>
                        <?php if ($row6_button): ?>
                            <div class="block link" >
                                <?php
                                $link_url = esc_url($row6_button['url']);
                                $link_title = esc_html($row6_button['title']);
                                ?>
                                <a class="button" href="<?= $link_url ?>" target="<?= $link_target ?>">
                                    <?= $link_title ?>
                                </a>
                            </div>
                        <?php endif; ?>
                        </div>
                    
                   
                    <div class="image-content">
                        <?php if (have_rows($row6_image)) { ?>
                        <?php while (have_rows($row6_image)) {
                            the_row();

                            $image = get_sub_field('row6_photo_acties');
                            ?>
                            <div class="block image">
                                <img src="<?= $image['url'] ?>" alt="Beschrijvende tekst">
                            </div>
                            <?php } ?> 
                        <?php } ?>
                    </div>


                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
</section>
