<?php
/**
 
Plugin Name: Work
Plugin URI:
Description: This is not just a plugin, it symbolizes the hope and enthusiasm of an entire generation summed up in two words sung most famously by Louis Armstrong: Hello, Dolly. When activated you will randomly see a lyric from <cite>Hello, Dolly</cite> in the upper right of your admin screen on every page.
Author: Subhasish Manna
Version: 1.0
Author URI: http://ma.tt/
*/
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$plugin_dir = plugin_dir_path(__FILE__);
require_once ( $plugin_dir . 'work_cpt.php' );
require_once ( $plugin_dir . 'place_taxonomy.php' );
require_once ( $plugin_dir . 'work_fields.php' );
require_once ( $plugin_dir . 'work_render.php' );
require_once ( $plugin_dir . 'work_shortcode.php' );

//enqueue style and script
function subho_work_script(){
	global $pagenow, $typenow;
		
		// loding scripts in work settings page
		if($typenow=='work' && $pagenow=='edit.php'){
			
			wp_enqueue_style ( 'work-cpt', plugins_url('css/admin_work_cpt.css', __FILE__), array(), '24.02.2016', 'all' );
			wp_enqueue_script ( 'record', plugins_url('js/records.js', __FILE__), array('jquery','jquery-ui-sortable'), '24.02.2016', true );
			wp_localize_script('record', 'WP_WORK_LISTING', array(
								'security'=> wp_create_nonce('wp-work-order'),
								'success' => 'Job sort order has been Saved.',
								'failure' => 'Job sort order not Saved.'
			
			
			));
		 }
		 // loding scripts in work cpt page
	if(($pagenow == 'post-new.php' || $pagenow =='post.php') && $typenow=='work'){
		wp_enqueue_style ( 'work-cpt', plugins_url('css/admin_work_cpt.css', __FILE__), array(), '24.02.2016', 'all' );
		wp_enqueue_script ( 'workjs', plugins_url('js/admin_work.js', __FILE__), array('jquery', 'jquery-ui-datepicker'), '24.02.2016', true );
		wp_enqueue_script ( 'quicktagss', plugins_url('js/quicktags.js', __FILE__), array('jquery'), '24.02.2016', true );
		wp_enqueue_style( 'jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css' );
	}
   
	
}
add_action('admin_enqueue_scripts', 'subho_work_script');
//save ordering
function subho_work_save_ordering(){
	if(!check_ajax_referer('wp-work-order','security')){
		return wp_send_json_error('Invalid nonce');
	}
	if(!current_user_can('manage_options')){
		return wp_send_json_error('You are not allow to do this.');
	}
	$order = $_POST['order'];
	$counter = 0;
	foreach($order as $item_id){
		 $post = array(
			'ID' => (int)$item_id,
			'menu_order' => $counter
		 );
		wp_update_post( $post );
		$counter++;
	}
	
	 wp_send_json_success('post Saved');
}

add_action('wp_ajax_save_sort','subho_work_save_ordering');




