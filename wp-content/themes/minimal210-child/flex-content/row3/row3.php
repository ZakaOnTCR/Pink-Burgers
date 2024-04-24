<?php
$current_name = get_row_layout(); // Name of the row

$row3_image = get_sub_field("row3_receptem_image");
$row3_title = get_sub_field("row3_recepten_title");
$row3_button = get_sub_field("row3_recepten_link");


?>

<section class="row3 flex-content <?= $current_name ?>">
    <div class="full-row">
        <div class="blocks-container">
            <div class="block text">
                <?= $row3_title ?>
            

            <div class="block overview">
            <?= $row3_text ?>
                <?php 
                $query = new WP_Query(
                    array(
                        'post_type' => 'recepten',
                        'posts_per_page' => 2,
                    )
                );

                if ($query->have_posts()): ?>
                    <?php while ($query->have_posts()): $query->the_post(); ?>
                        <?php include(get_stylesheet_directory() . '/includes/post_type/recipe-overview-include.php'); ?>
                    <?php endwhile; ?>
                    <?php wp_reset_postdata(); ?>
                <?php else: ?>
                    <p>Op dit moment zijn er geen recepten om weer te geven.</p>
                <?php endif; ?>
            </div>
        
    </div>

    <div class="block link">
        <?php if ($row3_button) : ?>
            <a class="link" href="<?= esc_url($row3_button['url']) ?>" target="<?= esc_attr($row3_button['target']) ?>">
                <?= esc_html($row3_button['title']) ?>
            </a>
        <?php endif; ?>
    </div>
    </div>
    </div>

</section>