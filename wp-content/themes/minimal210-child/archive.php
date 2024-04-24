<?php get_header(); ?>

<main>

	<section class='row'>
		
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

	</section> <!-- row -->

	<section class='row archive-row'>
		
		<div class='full-row'>
			
			<div class='blocks-container'>
				
				<div class='block'>

				<?php if( have_posts() ) { ?>
								
					<?php while( have_posts() ) { the_post(); ?>

						<!-- Insert get template part here -->

					<?php } ?>

					<?php minimal_pagination() ?>

				<?php } ?>

				</div>

			</div> <!-- blocks-container -->

		</div> <!-- full-row -->

	</section> <!-- row -->

</main>

<?php get_footer(); ?>