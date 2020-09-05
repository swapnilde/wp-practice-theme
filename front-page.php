<?php
	get_header();
?>

<div class="container-fluid">
	<div class="row">
		<nav class="col-md-2 d-none d-md-block bg-light sidebar">
			<?php
				dynamic_sidebar('sidebar-2')
			?>
		</nav>
		<main class="col-md-9 ml-sm-auto col-lg-10 px-4">
			<?php
				if ( have_posts() ) {
					while ( have_posts() ) {
						the_post();
						?>
						<h2 class="entry-title heading-size-1">
							<a href="<?php the_permalink(); ?>"> <?php the_title(); ?> </a>
						</h2>
						<?php
						the_excerpt();
						echo do_shortcode( '[acme-donate account="swapnil@gmail.com"]');
					}
				}
			?>
		</main>
	</div>
</div>

<?php
	get_footer();