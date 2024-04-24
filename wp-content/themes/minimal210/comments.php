<?php

if ( post_password_required() ) return; ?>

<?php if( have_comments() ) { ?>

<div class='row comments-row'>
	
	<div class='full-row'>
		
		<div class='blocks-container'>
			
			<div class='block block-title'>
				
				<h2><?php echo get_the_title(); ?></h2>

			</div>

			<div class='block comments-block'>

				<ul class="comment-list">
					<?php wp_list_comments( array( 
						'style'      => 'ul',
						'short_ping' => true,
					) ); ?>
				</ul><!-- .comment-list -->

				<?php comment_form(); ?>

			</div>

		</div> <!-- blocks-container -->

	</div> <!-- full-row -->

</div> <!-- row -->

<?php } ?>








