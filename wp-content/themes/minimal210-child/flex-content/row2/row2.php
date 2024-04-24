<?php

$current_name = get_row_layout(); // Name of the row

$row2_button = get_sub_field("row2_button_link");
$row2_text = get_sub_field("row2_title_text");
$row2_image= get_sub_field("row2_afbeelding");

?>

<section class="row  flex-content <?= $current_name ?>">
    <?php if ($row2_image): ?>
        <div class="block image" style="background-image: url(<?= $row2_image['url'] ?>);"></div>
    <?php endif; ?>
    <div class="full-row">
        <div class="blocks-container">
            <div class="block text">
                <?= $row2_text ?>  
                <div class="block link">
                    <?php if ($row2_button) :
                        $link_url = esc_url($row2_button['url']);
                        $link_title = esc_html($row2_button['title']);?> 

                        <a class="button" href="<?= $link_url ?>" target="<?= $link_target ?>">
                            <?= $link_title ?>
                                    </a>
                    <?php endif; ?>
                </div>
            </div>
            
        </div>
    </div>
</section>
