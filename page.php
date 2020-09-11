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
			<div id="primary" class="site-content col-md-9 ml-sm-auto col-lg-10 px-4">
				<div id="content" role="main">

					<?php while ( have_posts() ) : the_post(); ?>
						<header class="entry-header">
							<?php the_post_thumbnail(); ?>
							<h1 class="entry-title"><?php the_title(); ?></h1>
						</header>
						<div class="entry-content">
							<?php the_content(); ?>
						</div>
					<?php endwhile;?>

				</div>
			</div>
		</div>
	</div>

<?php
	get_footer();