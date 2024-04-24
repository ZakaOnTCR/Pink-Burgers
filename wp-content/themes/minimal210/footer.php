<?php get_template_part( 'footer-templates/content', 'footer' ); ?>

</div> <!-- page-wrapper -->

<?php wp_footer(); ?>

<!-- body code theme settings -->
<?php if(get_field('setting_footer_insert','options')){ ?>

	<?php the_field('setting_footer_insert','options');?>

<?php } ?>

</body>

</html>