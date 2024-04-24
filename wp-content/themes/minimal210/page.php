<?php
/**
 * @category 	Default page
 * @author 		Wilco
 * @since 		11-4
 * @version 	1.0
 */

get_header(); ?>

<main>

	<?php while ( have_posts() ) : the_post(); ?>

		<div class='row'>

			<div class='full-row'>

				<div class='blocks-container'>

					<div class='block'>

						<?php the_content(); ?>

					</div>

				</div> <!-- blocks-container -->

			</div> <!-- full-row -->

		</div> <!-- row -->

	<?php endwhile; // end of the loop. ?>

</main><!-- #main -->

<?php get_footer(); ?>
