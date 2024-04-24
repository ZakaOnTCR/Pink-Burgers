<!doctype html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="profile" href="http://gmpg.org/xfn/11">

		<!-- header code theme settings -->
		<?php if(get_field('setting_header_insert','options')){ ?>

			<?php the_field('setting_header_insert','options');?>

		<?php } ?>

		<?php wp_head(); ?>
	</head>

<body <?php body_class(); ?>>

<!-- body code theme settings -->
<?php if(get_field('setting_body_insert','options')){ ?>

	<?php the_field('setting_body_insert','options');?>

<?php } ?>

<div id='page-wrapper'>

	<header id='main-header'>

		<?php get_template_part('header-templates/content', 'header'); ?>

	</header>