<?php
$current_name = get_row_layout(); // Name of the row

$row5_image = get_sub_field("row5_receptem_image");
$row5_title = get_sub_field("row5_recepten_title");
$row5_button = get_sub_field("row5_recepten_link");
$row5_text_under = get_sub_field("row5_text_under");
?>

<section class="row5 flex-content <?= $current_name ?>">
    <div class="full-row">
        <div class="blocks-container">
            <div class="block text">
                <?= $row5_title ?>
                <div class="block overview">
                    <?= $row5_text ?>
                    <?php 
                    $query = new WP_Query(
                        array(
                            'post_type' => 'recepten',
                            'posts_per_page' => 2,
                            'paged' => $paged,
                            'facetwp' => true,
                        )
                    );

                    if ($query->have_posts()): ?>
                        <?php while ($query->have_posts()): $query->the_post(); ?>
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

                        <?php endwhile; ?>
                        <?php wp_reset_postdata(); ?>


                    <?php else: ?>
                        <p>Op dit moment zijn er geen recepten om weer te geven.</p>
                    <?php endif; ?>
                </div>
            </div>


        <div class="pagination">
            <?php if (do_shortcode('[facetwp facet="paginatie"]')) : ?>
                <?php echo do_shortcode('[facetwp facet="paginatie"]'); ?>
            <?php else : ?>
                <?php echo minimal_pagination($query->max_num_pages, "", $paged); ?>
            <?php endif; ?>
        </div>

        <div class="block-under">
            <div class="text">
               <?= $row5_text_under ?> 
            </div>
            <div class="block link">
            <?php if ($row5_button) : ?>
                <a class="button" href="<?= esc_url($row5_button['url']) ?>" target="<?= esc_attr($row5_button['target']) ?>">
                    <?= esc_html($row5_button['title']) ?>
                </a>
            <?php endif; ?>
        </div>

    </div>
        </div>


</section>
