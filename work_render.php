<?php 
// aad submenu page of for work under setting page
function setup_work_admin_submenumenus() {
    add_submenu_page('edit.php?post_type=work', 
        'Subho Work Settings', 'Work Settings', 'manage_options', 
        'work_settings', 'subho_worksetting_callback'); 
}
add_action("admin_menu", "setup_work_admin_submenumenus");
function subho_worksetting_callback(){
	
echo "<h1>THIS IS WORK RE_ORDER ADMIN PAGE</h1>";


$args = array(
			'post_type'=>'work',
			'orderby'=>'menu_order',
			'order'=>'ASC',
			'no_found_rows'=>true,
			'update_post_meta_cache'=>false,// ensuseing that query not from from any taxonomies
			'posts_per_page' => 50,
			'post_status' => 'publish',
);

$job_listing = new WP_Query( $args );
?>
	<div class="warp" id="job-sort">
		<div id="icon-job-admin" class="icon32"><br></div>
		<h2><?php _e('Sort Job Position', 'sobho_work'); ?><img src="<?php echo esc_url(admin_url().'/images/loading.gif');?>" alt="" id="loading-animation"/></h2> 
	<?php
				if($job_listing->have_posts()){
					?>
					<p><?php _e( '<strong>Note:</strong> This is onle Effect','sobho_work');?></p>
					<ul id="custom-type-list">
					<?php while($job_listing->have_posts()): $job_listing->the_post(); ?>
							<li id="<?php esc_attr( the_ID() ); ?>"> <?php esc_html(the_title()); ?></li>
					<?php endwhile; ?>
					</ul>
				<?php	
				}else{
					_e('<p>No Job Found</p>','sobho_work');
				}
	
	?>
	</div>
<?php

}



