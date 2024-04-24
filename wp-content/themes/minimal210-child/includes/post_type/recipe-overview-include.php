<?php 
$title = get_the_title();
$image = get_field('row3_recept_image');
$text = get_field('row3_recept_text');
$button = 'row3_recept_button';
$row5_color = get_sub_field("row5_recept_color");
?>


<div class="one-recipe one-item ">
    <div class="block-group top">
        <?php if ($image): ?>
            <div class="block image" style="background-image: url(<?= $image['url'] ?>);"></div>
        <?php endif; ?>
    </div>

    <div class="block-group bottom bg-<?= $row5_color ?>">
        <div class="block title-recept">
            <h4><?= $title ?></h4>
        </div>

        <?php if ($text): ?>
            <div class="block text-recept">
                <p><?= $text ?></p>
            </div>
        <?php endif; ?>

        <div class="block button-recept ">
            <?php if (have_rows($button)) { ?>
                <?= minimal_button_repeater($button); ?>
            <?php } ?>
        </div>
    </div>
</div>
