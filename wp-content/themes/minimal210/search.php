<?php

/**
 * @category 	Default search pagina
 * @author 		Wilco
 * @since 		13-4-2017
 * @version 	1.0
 */

get_header(); ?>

<?php echo do_shortcode('[slider slug="multiple-slideshows"]'); ?>

<main>

	<?php if ( have_posts() ) { ?>

	<div class='row'>
		
		<div class='full-row'>
			
			<div class='blocks-container'>
				
				<div class='block page-title'>
					
					<h1><?php printf( esc_html__( 'Search Results for: %s', 'minimal210' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
					
				</div>

			</div> <!-- blocks-container -->

		</div> <!-- full-row -->

	</div> <!-- row -->

	<div class='row search-results'>
		
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