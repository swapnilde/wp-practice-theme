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
			<br><br>
				<div class="row">
					<?php
						$args = array(
							'post_type' => 'faculty',
						);
						$query = new WP_Query( $args );

						if ( $query->have_posts() ) {
					?>
					<div class="row row-cols-1 row-cols-md-4">
					<?php while ( $query->have_posts() ) : $query->the_post() ; ?>
							<div class="col mb-6">
								<div class="card">
									<img src="<?php the_post_thumbnail_url('150'); ?>" class="card-img-top" alt="...">
									<div class="card-body">
										<h5 class="card-title"><strong><?php the_title(); ?></strong></h5>
										<p class="card-text"><?php the_excerpt(); ?></p>
									</div>
								</div>
							</div>
					<?php endwhile;
					} ?>
					</div>
					<?php wp_reset_postdata(); ?>
				</div>
				<br><br>
				<div class="row">
					<?php $args = array(
						'posts_per_page' => '4',
						);
						$posts = get_posts( $args );
						if ( $posts ) { ?>
					<div class="row row-cols-1 row-cols-md-4 list-group list-group-horizontal">
						<?php foreach ($posts as $post ) { ?>
							<?php setup_postdata( $post ); ?>
							<div class="list-group-item">
								<?php
									the_title();
									the_excerpt();
								?>
							</div>
						<?php } ?>
					</div>
						<?php }
							wp_reset_postdata();
						?>
				</div>
				<br><br>
				<div class="row">
					<?php $args = array(
						'sort_order' => 'ASC',
 						'sort_column' => 'post_title',
						);
						$pages = get_pages( $args );
						if ( $pages ) { ?>
						<div class="row row-cols-1 row-cols-md-4 list-group list-group-horizontal">
							<?php foreach ($pages as $page ) { ?>
								<div class="list-group-item">
									<?php
										echo "<strong>Page:</strong> <br>" . $page->post_title;
									?>
								</div>
							<?php } ?>
					</div>
						<?php } ?>
				</div>
			</main>
		</div>
	</div>

<?php
	get_footer();