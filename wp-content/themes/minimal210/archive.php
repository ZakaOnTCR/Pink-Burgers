<?php
/**
 * @category 	Default archief pagina
 * @author 		Wilco
 * @since 		13-4-2017
 * @version 	1.0
 */

get_header(); ?>

<?php // echo do_shortcode('[slider slug="xxx"]'); ?>

<main>

	<?php if( have_posts() ) { ?>

		<div class='row'>
			
			<div class='full-row'>
				
				<div class='blocks-container'>
					
					<div class='block page-title'>
						
						<h1><?php the_archive_title(); ?></h1>
						
					</div>

					<div class='block archive-description'>
						
						<?php the_archive_description(); ?>

					</div>

				</div> <!-- blocks-container -->

			</div> <!-- full-row -->

		</div> <!-- row -->

		<div class='row archive-row'>
			
			<div class='full-row'>
				
				<div class='blocks-container'>
					
					<div class='block'>
									
						<?php while( have_posts() ) { the_post(); ?>

							<!-- Insert get template part here -->

						<?php } ?>

						<?php minimal_pagination() ?>

					</div>

				</div> <!-- blocks-container -->

			</div> <!-- full-row -->

		</div> <!-- row -->

	<?php } ?>

</main>

<?php get_footer(); ?>