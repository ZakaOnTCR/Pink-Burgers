<?php
/**
 * Template Name: Pagina-templates
**/


get_header(); ?>

<main>

	<?php while ( have_posts() ) : the_post(); ?>

		<section class='row default-page-template row1' >

			<div class='full-row'>

				<div class='blocks-container'>


				</div>

			</div>

		</section>

	<?php endwhile; ?>

</main>

<?php get_footer(); ?>
