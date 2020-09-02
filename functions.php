<?php

	use function Sodium\add;

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
		$message = get_the_title($post_id) . ' was just saved:';

		if(file_exists( $post_log)){
			$file = fopen( $post_log, 'a');
			fwrite( $file, $message . date('F j,Y,g:i a') . "\n");
		}else{
			$file = fopen( $post_log, 'w');
			fwrite( $file, $message . date('F j,Y,g:i a') . "\n");
		}

		fclose( $file);
	}

	add_filter('body_class','add_class_body');
	function add_class_body($classes) {
		global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;

		if($is_lynx){
			$classes[] = 'lynx';
		}elseif($is_gecko) {
			$classes[] = 'gecko';
		}
		elseif($is_opera) {
			$classes[] = 'opera';
		}
		elseif($is_NS4) {
			$classes[] = 'ns4';
		}
		elseif($is_safari) {
			$classes[] = 'safari';
		}
		elseif($is_chrome) {
			$classes[] = 'chrome';
		}
		elseif($is_IE) {
			$classes[] = 'ie';
		}
		else {
			$classes[] = 'unknown';
		}

		if($is_iphone) {
			$classes[] = 'iphone';
		}
		return $classes;
	}

	add_action('template_redirect','member_only');
	function member_only(){
		if(is_page('secret-page') && !is_user_logged_in()){
			do_action( 'user_redirected', date( "F j, Y, g:i a"));
			wp_redirect( home_url());
		}
	}

	add_action('user_redirected','log_when_accessed');
	function log_when_accessed($date){
		$access_log = get_stylesheet_directory() . '/posts_logs.txt';
		$message = 'Someone accessed secret page at:'.$date;

		if(file_exists( $access_log)){
			$file = fopen( $access_log, 'a');
			fwrite( $file, $message."\n");
		}else{
			$file = fopen( $access_log, 'w');
			fwrite( $file, $message . "\n");
		}

		fclose( $file);
	}

	add_filter ('the_content', 'add_ad');
	function add_ad($content) {
		if(!is_feed() && !is_home()) {
			$content.= "<div class='subscribe bg-dark text-white'>";
			$content.= "<h4>Enjoyed this article?</h4>";
			$content.= "<p>Subscribe to our  <a href='#'>RSS feed</a> and never miss a post!</p>";
			$content.= "</div>";
		}
		return $content;
	}

	add_action('wp_enqueue_scripts','register_ani_js');
	function register_ani_js(){
		wp_register_script( 'anijs', 'https://cdn.jsdelivr.net/gh/anijs/anijs@0.9.3/dist/anijs-min.js','','',true);
		wp_enqueue_script( 'anijs');
	}

	add_action('wp_enqueue_scripts','register_anijs_css');
	function register_anijs_css(){
		wp_register_style( 'anijs-css', 'http://anijs.github.io/lib/anicollection/anicollection.css','','','all');
		wp_enqueue_style( 'anijs-css');
	}
