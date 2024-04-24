<?php
/**
 * @category 	Default index
 * @author 		Wilco
 * @since 		11-4
 * @version 	1.0
 */

get_header(); ?>

<?php if(function_exists('minimal_do_slider') ) minimal_do_slider(); ?>

<main>

	<?php while ( have_posts() ) : the_post(); ?>

		<div class='row'>

			<div class='full-row'>

				<div class='blocks-container'>

					<div class='block title'>

						<h1><?php echo get_the_title(); ?></h1>

					</div>

					<div class='block text'>
						
						<?php the_content(); ?>
						
					</div>

				</div> <!-- blocks-container -->

			</div> <!-- full-row -->

		</div> <!-- row -->
			
	<?php endwhile; // end of the loop. ?>

</main><!-- #main -->

<?php get_footer(); ?>