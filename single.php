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
			<section id="content" class="col-md-9 ml-sm-auto col-lg-10 px-4">
				<div class="wrap-content blog-single">
					<?php  while ( have_posts() ) : the_post(); ?>
						<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
							<?php the_title( '<h1>','</h1>' );  ?>
							<div class="post-thumbnail"><?php the_post_thumbnail(array(1200, 600)); ?> </div>
							<div class="entry-content"><?php the_content(); ?></div>
						</article>
					<?php endwhile; ?>
				</div>
			</section>
		</div>
	</div>
<?php
	get_footer();