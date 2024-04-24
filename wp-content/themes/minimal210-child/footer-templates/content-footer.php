<?php

//Top footer
$f_text = get_field('f_text', 'option');
$f_text2 = get_field('f_text2', 'option');
$f_text3 = get_field('f_text3', 'option');

$f_icon_title = get_field('f_icon_title', 'option');
$f_repeater = 'f_repeater';

//Bottom footer
$f_copyright = get_field('f_copyright', 'option');
$f_buro210 = get_field('f_buro210', 'option');


?>

<footer id='main-footer'>

    <?php if ($f_text || $f_text2 || $f_text3) { ?>

        <div class='row footer top'>

            <div class='full-row'>

                <div class='blocks-container'>

                    <?php if ($f_text) { ?>

                        <div class="block left">

                            <div class="inner-block text">

                                <?= $f_text ?>

                            </div>

                        </div>

                    <?php } ?>

                    <?php if ($f_text2) { ?>

                        <div class="block mid">

                            <div class="inner-block text">

                                <?= $f_text2 ?>

                            </div>

                        </div>

                    <?php } ?>

                    <?php if ($f_text3) { ?>

                        <div class="block right">
                        <?php if ($f_icon_title || have_rows($f_repeater, 'option')) { ?>
                        
                            <?php if ($f_icon_title) { ?>
                                <div class="inner-block title">
                                <p><strong><?= $f_icon_title ?></strong></p>
                                </div>
                            <?php } ?>
                            

                            <?php if (have_rows($f_repeater, 'option')) { ?>

                                <div class="inner-block repeater">

                                    <?php while (have_rows($f_repeater, 'option')) {
                                        the_row();

                                        $icon = get_sub_field('icon');
                                        $url = get_sub_field('url');
                                        ?>
                                        

                                        <div class="icon">

                                            <a target="_blank" href="<?= $url ?>">

                                                <?= $icon ?>

                                            </a>

                                        </div>

                                    <?php } ?>
                                    </div>
                                    <?php if ($f_text3) { ?>

                                    <div class="inner-block text">

                                        <?= $f_text3 ?>

                                    </div>

                                    <?php } ?>

                               

                            <?php } ?>
                        </div>
                    <?php } ?>

                           

                        </div>

                    <?php } ?>

                    

                </div>

            </div>

        </div>

    <?php } ?>

    <?php if ($f_copyright || $f_buro210) { ?>

        <div class='row footer bottom'>

            <div class='full-row'>

                <div class='blocks-container'>

                    <?php if ($f_copyright) { ?>

                        <div class="block left">

                            <div class="inner-block text">

                                <?= $f_copyright ?>

                            </div>

                        </div>

                    <?php } ?>

                    <?php if ($f_buro210) { ?>

                        <div class="block right">

                            <a href="https://www.buro210.nl/" target="_blank">

                                <span class="linkwrap">

                                    Ontwikkeld door <strong class="black"><span class="black">BURO</span><span
                                            class="pink">210</span>.</strong>

                                </span>

                            </a>

                        </div>

                    <?php } ?>

                </div>

            </div>

        </div>

    <?php } ?>

</footer>

<?php min_responsive_menu('Hoofdmenu'); ?>