<?php

get_header();

$flex_content = 'acf_flexible_content';
$s_icon_repeater = 's_icon_repeater';

?>

<main>

    <?php while (have_posts()):
        the_post(); ?>

        <?php if (have_rows($flex_content)) { ?>

            <?php while (have_rows($flex_content)) {
                the_row();

                $layout = get_row_layout();
                ?>

                <?php include(get_stylesheet_directory() . "/flex-content/$layout/$layout.php"); ?>

            <?php } ?>

        <?php } ?>

    <?php endwhile; // end of the loop. ?>

</main><!-- #main -->

<?php get_footer(); ?>

<?php if (have_rows($s_icon_repeater, 'option')) { ?>
    <aside class="sidebar">
        <?php while (have_rows($s_icon_repeater, 'option')) {
            the_row();

            $icon = get_sub_field('icon');
            $link = get_sub_field('link');
            ?>

            <?php if ($icon && $link['url']) { ?>
                <div class="link">
                    <a href="<?= $link['url'] ?>"><?= $icon ?></a>
                </div>
            <?php } ?>

        <?php } ?>
    </aside>
<?php } ?>