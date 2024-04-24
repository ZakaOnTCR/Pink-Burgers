<?php get_header(); ?>

<main>

	<div class='row search row1'>

		<div class='full-row'>

			<div class='blocks-container'>

				<div class='block page-title'>

					<h2><?php printf( esc_html__( 'Zoekresultaten voor: %s', 'minimal210' ), '<span>' . get_search_query() . '</span>' ); ?></h2>

				</div>

				<div class='block content'>

				<?php if ( have_posts() ) { ?>

					<?php while( have_posts() ) { the_post();

						$url 			= get_the_permalink();
						$title 			= get_the_title();

						$search_text 	= get_field('search_text');

						?>

						<article>

							<a href="<?php echo $url; ?>">

								<div class='search-title'>

									<h4><?php echo $title; ?></h4>

									<p><?= $search_text ?></p>

								</div>

							</a>

						</article>

					<?php }

					minimal_pagination(); ?>

				<?php } else { ?>

					<p><?php echo __( 'Geen resultaten','minimal210' ); ?></p>

				<?php } ?>

				</div>

			</div>

		</div>

	</div>

</main>

<?php get_footer(); ?>
