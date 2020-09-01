<?php

	function acme_theme_support(){
		add_theme_support( 'title-tag');
		add_theme_support( 'custom-logo');
	}

	add_action('after_setup_theme','acme_theme_support');

	function acme_menus(){
		$locations = array(
			'primary'=>'Theme primary menu',
			'footer'=>'Theme footer menu'
		);
		register_nav_menus($locations);
	}

	add_action('init', 'acme_menus');

	add_action( 'widgets_init', 'acme_register_sidebar' );
	function acme_register_sidebar() {

		register_sidebar( array(
			'name' => __( 'Front Page Sidebar' ),
			'id' => 'sidebar-1',
			'description' => __('Main sidebar for front page'),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		) );
		register_sidebar( array(
			'name' => __( 'Rest Page Sidebar' ),
			'id' => 'sidebar-2',
			'description' => __('Main sidebar for rest of the pages'),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		) );
	}

	function acme_register_styles(){
		wp_enqueue_style( 'acme_main-styles',get_template_directory_uri().'/style.css',array(),'1.0.0','all');
		wp_enqueue_style( 'acme_bootstrap-css','https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css',array(),'4.5.2','all');
	}

	add_action('wp_enqueue_scripts','acme_register_styles');

	function acme_register_scripts(){
		wp_enqueue_script( 'acme_bootstrap-jq','https://code.jquery.com/jquery-3.5.1.slim.min.js',array(),'3.5.1',true);
		wp_enqueue_script( 'acme_bootstrap-popper','https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js',array(),'1.16.1',true);
		wp_enqueue_script( 'acme_bootstrap-js','https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js',array(),'4.5.2',true);
	}

	add_action('wp_enqueue_scripts','acme_register_scripts');

	add_filter('excerpt_length','custom_excerpt_size');
	function custom_excerpt_size($length){
		$length = 20;
		return $length;
	}

	add_action('save_post','log_posts_stat');
	function log_posts_stat($post_id){
		if(!(wp_is_post_revision( $post_id)) || wp_is_post_autosave( $post_id)){
			return;
		}

		$post_log = get_stylesheet_directory() . '/posts_logs.txt';
		$message = get_the_title($post_id) . 'was just saved';

		if(file_exists( $post_log)){
			$file = fopen( $post_log, 'a');
			fwrite( $file, $message . date('F j,Y,g:i a') . "\n");
		}else{
			$file = fopen( $post_log, 'w');
			fwrite( $file, $message . date('F j,Y,g:i a') . "\n");
		}

		fclose( $file);
	}