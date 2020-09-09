<?php

	function acme_theme_support(){
		add_theme_support( 'title-tag');
		add_theme_support( 'custom-logo');
		add_theme_support( 'post-thumbnails', array( 'post', 'page','faculty' ) );
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

	function add_dashboard_widget() {
		wp_add_dashboard_widget( 'dashboard_widget', 'Acme Dashboard Widget', 'widget_function' );
	}
	add_action( 'wp_dashboard_setup', 'add_dashboard_widget' );

	function widget_function() {
		esc_html_e( "This is Dashboard Widget!", "acme" );
	}

	add_action( 'add_meta_boxes', 'sd_meta_box_add' );
	function sd_meta_box_add()
	{
		add_meta_box( 'my-meta-box-id', 'Post Extra Details', 'sd_meta_box_flds', 'post', 'normal', 'high' );
	}

	function sd_meta_box_flds()
	{
		global $post;
		$values = get_post_custom( $post->ID );
		$text = isset( $values['my_meta_box_heading'] ) ? esc_attr( $values['my_meta_box_heading'][0] ) : ”;
		$selected = isset( $values['my_meta_box_category'] ) ? esc_attr( $values['my_meta_box_category'][0] ) : ”;


		wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' );

		?>

		<p>
			<label for="my_meta_box_heading">Write sub-heading</label>
			<input type="text" name="my_meta_box_heading" id="my_meta_box_heading" value="<?php echo $text; ?>"/>
		</p>

		<p>
			<label for="my_meta_box_category">Choose Category</label>
			<select name="my_meta_box_category" id="my_meta_box_category">
				<option value="Marketing" <?php selected( $selected, 'Marketing' ); ?>>Marketing</option>
				<option value="Technology" <?php selected( $selected, 'Technology' ); ?>>Technology</option>
				<option value="Business" <?php selected( $selected, 'Business' ); ?>>Business</option>
			</select>
		</p>
		<?php
	}

	add_action( 'save_post', 'cd_meta_box_save' );

	function cd_meta_box_save( $post_id )
	{

		if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;


		if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'my_meta_box_nonce' ) ) return;


		if( !current_user_can( 'edit_post' ) ) return;



		if( isset( $_POST['my_meta_box_heading'] ) )
			update_post_meta( $post_id, 'my_meta_box_heading', esc_attr( $_POST['my_meta_box_heading'] ) );

		if( isset( $_POST['my_meta_box_category'] ) )
			update_post_meta( $post_id, 'my_meta_box_category', esc_attr( $_POST['my_meta_box_category'] ) );


	}

	add_action('admin_init', 'admin_color_scheme');
	function admin_color_scheme(){
		$theme_dir = get_stylesheet_directory_uri();
		wp_admin_css_color('acme', __( 'Acme' ), $theme_dir.'/assets/css/admin-colors.css', array('#384047', '#5BC67B', '#838cc7', '#ffffff'));

	}

	add_action("admin_menu", "add_acme_admin_menu");
	function add_acme_admin_menu() {
		add_menu_page("Acme menu admin page", "Acme menu", "edit_posts",
			"acme-menu", "acme_page_content", null, 1);
		add_submenu_page( 'acme-menu', 'Acme menu sub page', 'Acme sub-menu', 'edit_posts', 'acme-sub-menu','acme_sub_page_content',1);
	}
	function acme_page_content(){
		echo "New Acme Admin Menu Page";
	}
	function acme_sub_page_content(){
		echo "New Acme Admin Sub-menu Page";
	}

	add_filter("custom_menu_order", "allowMenuStructure");
	function allowMenuStructure() {
		return true;
	}

	add_filter("menu_order", "loadMenuStructure");
	function loadMenuStructure() {
		return array("index.php", "tools.php","themes.php");
	}


	function acme_foobar_func( $atts ) {
		$a = shortcode_atts( array(
			'foo' => 'something',
			'bar' => 'something else',
		), $atts );

		return "foo = {$a['foo']}" ." ". "bar = {$a['bar']}";
	}
	add_shortcode( 'acme-foobar', 'acme_foobar_func' );

	function acme_donate_shortcode( $atts) {
		global $post;
		$a = shortcode_atts(array(
			'account' => 'your-paypal-email-address',
			'for' => $post->post_title,
			'onHover' => '',
		), $atts);

		return '<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_xclick&business='.$a['account'].'&item_name=Donation for '.$a['for'].'" title="'.$a['onHover'].'">Make a donation!</a>';
	}
	add_shortcode('acme-donate', 'acme_donate_shortcode');

//	remove_all_shortcodes();		//removes all shortcodes
//	remove_shortcode('bartag');		//removes specified shortcode

//	$ff = shortcode_exists( 'bartag');
//	print_r( $ff);		//outputs 1 if true
//	die();


		function embed_video( $atts) {
			$a = shortcode_atts( array(
				'url'=>'',
				'width'=>'320',
				'height'=>'240'
			), $atts);

			return <<<"EOT"
<video controls width="{$a['width']}">
    <source src="{$a['url']}"
            type="video/webm">
    <source src="{$a['url']}"
            type="video/mp4">
	<source src="{$a['url']}"
            type="video/ogg">
    Sorry, your browser doesn't support embedded videos.
</video>
EOT;
	}
	add_shortcode('acme-video', 'embed_video');


	add_action('init','acme_add_role');
	function acme_add_role(){
		add_role( 'acme_manager', 'Acme Manager',array(
			'read'=>true,
			'activate_plugins'=>true,
			'install_plugins'=>true,
			'update_plugins'=>true,
			'delete_plugins'=>true,
			'upload_plugins'=>true
		));
	}


	add_action('after_switch_theme','acme_add_role_themer');
	function acme_add_role_themer(){
		add_role( 'acme_themer', 'Acme Themer',array(
			'read'=>true,
			'switch_themes'=>true,
			'install_themes'=>true,
			'update_themes'=>true,
			'delete_themes'=>true,
			'upload_themes'=>true
		));
	}

	add_action('switch_theme','acme_remove_roles');
	function acme_remove_roles(){
		remove_role( 'acme_manager');
		remove_role( 'acme_themer');
	}

	function acme_add_theme_caps() {
		$role = get_role( 'author' );
		$role->add_cap( 'edit_others_posts' );
	}
	add_action( 'after_switch_theme', 'acme_add_theme_caps');

	function acme_add_user_caps() {
		$user = new WP_User( 12 );
		$user->add_cap( 'can_edit_posts' );
	}
	add_action( 'after_switch_theme', 'acme_add_user_caps');

	function acme_remove_role_caps() {
		$role = get_role( 'editor' );
		$role->remove_cap( 'read_private_posts' );
	}
	add_action( 'switch_theme', 'acme_remove_role_caps');

	function acme_remove_user_caps() {
		$user = new WP_User( 12 );
		$user->remove_cap( 'can_edit_posts' );
	}
	add_action( 'switch_theme', 'acme_remove_user_caps');


	


	function acme_register_faculty_post_type() {
		$labels = array(
			'name'                  => 'Faculties',
			'singular_name'         => 'Faculty',
			'menu_name'             => 'Faculty',
			'name_admin_bar'        => 'Faculty',
			'add_new'               => 'Add New',
			'add_new_item'          => 'Add New Faculty',
			'new_item'              => 'New Faculty',
			'edit_item'             => 'Edit Faculty',
			'view_item'             => 'View Faculty',
			'all_items'             => 'All Faculty',
			'search_items'          => 'Search Faculty',
			'parent_item_colon'     => 'Parent Faculty:',
			'not_found'             => 'No faculties found.',
			'not_found_in_trash'    => 'No faculties found in Trash.',
			'featured_image'        => 'Faculty Profile Image',
			'set_featured_image'    => 'Set Faculty Image',
			'remove_featured_image' => 'Remove Faculty Image',
			'use_featured_image'    => 'Use as Faculty Image',
			'archives'              => 'Faculty archives',
			'insert_into_item'      => 'Insert into faculty',
			'uploaded_to_this_item' => 'Uploaded to this faculty',
			'filter_items_list'     => 'Filter faculties list',
			'items_list_navigation' => 'Faculties list navigation',
			'items_list'            => 'Faculties list',
		);
	 
		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'faculty' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title', 'editor', 'thumbnail' ),
		);
	 
		register_post_type( 'faculty', $args );
	}

	function acme_register_faculty_taxonomy() {

		$labels = array(
			'name'              => 'Department',
			'singular_name'     => 'Department',
			'search_items'      => 'Search Department',
			'all_items'         => 'All Departments',
			'parent_item'       => 'Parent Department',
			'parent_item_colon' => 'Parent Department:',
			'edit_item'         => 'Edit Department',
			'update_item'       => 'Update Department',
			'add_new_item'      => 'Add New Department',
			'new_item_name'     => 'New Department Name',
			'menu_name'         => 'Department',
		);

		register_taxonomy( 'department', 'faculty', array(
			'label'        		=> 'Department',
			'labels'       		=> $labels,
			'rewrite'      		=> array( 'slug' => 'department' ),
			'hierarchical' 		=> true,
			'show_ui'           => true,
        	'show_admin_column' => true,
        	'query_var'         => true,
			'update_count_callback' => '_update_post_term_count',
		) );
	}
	add_action( 'init', 'acme_register_faculty_taxonomy');
	 
	add_action( 'init', 'acme_register_faculty_post_type' );


	add_action( 'after_switch_theme', 'my_rewrite_flush' );
	function my_rewrite_flush() {
		acme_register_faculty_post_type();
		acme_register_faculty_taxonomy();
		flush_rewrite_rules();
	}
	