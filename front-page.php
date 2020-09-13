<?php
	get_header();
?>

	<div class="container-fluid">
		<div class="row">
			<nav class="col-md-2 d-none d-md-block bg-light sidebar">
				<?php
					dynamic_sidebar( 'sidebar-2' )
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
							echo do_shortcode( '[acme-donate account="swapnil@gmail.com"]' );
						}
					}
				?>

				<div class="row">
					<?php
						$args = array(
							'post_type' => 'faculty',
							'post__not_in' => array( $post->ID )
						);
						$query = new WP_Query( $args );

						if ( $query->have_posts() ) {
					?>
					<div class="col-4">

							<ul class="list-group list-group-horizontal-lg w-auto p-3">
							<?php while ( $query->have_posts() ) : $query->the_post() ; ?>
									<li class="list-group-item flex-fill"><strong><?php the_title(); ?></strong>
										<p>
											<?php the_excerpt(); ?>
										</p>
									</li>
							<?php endwhile;
							} ?>
							</ul>

					</div>
						<?php wp_reset_postdata(); ?>
				</div>

			</main>
		</div>
	</div>

<?php
	get_footer();