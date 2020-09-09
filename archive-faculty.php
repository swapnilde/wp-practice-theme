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
                if ( have_posts() ) : 
                    while ( have_posts() ) : the_post();
                    ?>
                        <a href="<?php the_permalink(); ?>"> <?php the_title(); ?> </a>
                    <?php 
                        the_post_thumbnail(array(200,200)); 
                        the_excerpt();
                    endwhile; 
                endif; 
            ?>
		</main>
	</div>
</div>
<?php
get_footer();