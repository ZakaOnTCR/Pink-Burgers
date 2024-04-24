<?php

$current_name = get_row_layout(); // Name of the row

$row4_button = get_sub_field("row4_button_link");
$row4_text = get_sub_field("row4_text");
$row4_image = get_sub_field("row4_afbeelding");
$row4_layout = get_sub_field("row4_layout");
$row4_layout2 = get_sub_field ("row4_layout_2");
?>


<section class="row flex-content <?= $current_name ?> bg-<?= $row4_layout2 ?>">
    <?php if ($row4_image): ?>
        <div class="block image <?php if ($row4_layout){?>reverse<?php } ?>" style="background-image: url(<?= $row4_image['url'] ?>);"></div>
    <?php endif; ?>

    <?php if ($row4_text || $row4_button): ?>
        <div class="full-row" >
            <div class="blocks-container <?php if ($row4_layout){?>reverse<?php } ?> ">
                <?php if ($row4_text): ?>
                    <div class="block text">
                        <?= $row4_text ?>
                        <?php if ($row4_button): ?>
                    <div class="block link" >
                        <?php
                        $link_url = esc_url($row4_button['url']);
                        $link_title = esc_html($row4_button['title']);
                        ?>
                        <a class="button" href="<?= $link_url ?>" target="<?= $link_target ?>">
                            <?= $link_title ?>
                        </a>
                    </div>
                <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
</section>
