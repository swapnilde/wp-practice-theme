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
							<?php the_title('<h1>','</h1>'); ?>
							<div class="post-thumbnail"><?php the_post_thumbnail(array(1200, 600)); ?> </div>
							<div class="entry-content"><?php the_content(); ?></div>
						</article>
					<?php endwhile; ?>
					<?php
						$likes = get_post_meta($post->ID, "likes", true);
						$likes = ($likes == "") ? 0 : $likes;
					?>
					This post has <span id='like_counter'><?php echo $likes ?></span> likes<br>
					<?php
						$nonce = wp_create_nonce("my_user_like_nonce");
						$link = admin_url('admin-ajax.php?action=my_user_like&post_id='.$post->ID.'&nonce='.$nonce);
						echo '<a id="user_like" class="user_like" data-nonce="' . $nonce . '" data-post_id="' . $post->ID . '" href="' . $link . '">Like this Post</a>';
					?>
				</div>
			</section>
		</div>
	</div>
<?php
	get_footer();