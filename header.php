<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
	      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?> >
<nav class="navbar navbar-dark bg-dark navbar-expand-lg">
	<a class="navbar-brand" href="#">
		<?php
			if(function_exists( 'the_custom_logo')){
				$custom_logo_id = get_theme_mod( 'custom_logo');
				$logo = wp_get_attachment_image_src( $custom_logo_id);

			}
		?>
		<img src="<?php echo $logo[0] ?>" width="30" height="30" class="d-inline-block align-top animate-logo" alt="" data-anijs="if: mouseover, do: rollOut animated, to: .animate-logo, after: $removeAnim">
		<?php echo get_bloginfo('name'); ?>
	</a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>

	<div class="collapse navbar-collapse" id="navbarSupportedContent">

		<?php
			wp_nav_menu(
					array(
						'menu'=>'primary',
						'container'=>'',
						'theme_location'=>'primary',
						'items_wrap'=>'<ul id=" " class="navbar-nav mr-auto">%3$s</ul>'
					)
			);
		?>

	</div>
</nav>