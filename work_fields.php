<?php

function work_metaboxes(){
	add_meta_box ( 
					'work_meta',
					__('Workin'), 
				   '<workin_metabox_callbox></workin_metabox_callbox>', 
				   'work',
				   'normal',
				   'core'
				  
		);
}
add_action( 'add_meta_boxes', 'work_metaboxes' );
function workin_metabox_callbox($post){
	wp_nonce_field(basename(__FILE__),'workmetabox_name');
	$subho_stored_meta = get_post_meta($post->ID);
	
	?>
		<div class="meta-row">
			<div class="meta-th">
				<label for="work_in" class="work_title"><?php _e('Work In','sobho_work');?></label>
			</div>
			<div class="meta-td">
				<input type="text" name="work_in" id="work_in" value="<?php
				if(!empty($subho_stored_meta['work_in'])){
					echo esc_attr($subho_stored_meta['work_in'][0]);
				}
				
				?>"/>
			</div>
		</div><!-- meta-row -->
	
		
		 <div class="meta-row">
			<div class="meta-th">
				<label for="work_listed" class="work_title"><?php _e('Work Listed','sobho_work');?></label>
			</div>
			<div class="meta-td">
				<input type="text" name="work_listed" class="row_content datepicker" id="work_listed" value="<?php
				if(!empty($subho_stored_meta['work_listed'])){
					echo esc_attr($subho_stored_meta['work_listed'][0]);
				}
				
				?>"/>
			</div>
		</div><!-- meta-row -->
	
		
		 <div class="meta-row">
			<div class="meta-th">
				<label for="work_application_deadline" class="work_title"><?php _e('Work Application Deadline','sobho_work');?></label>
			</div>
			<div class="meta-td">
				<input type="text" name="work_application_deadline" class="row_content datepicker" id="work_application_deadline" value="<?php
				if(!empty($subho_stored_meta['work_application_deadline'])){
					echo esc_attr($subho_stored_meta['work_application_deadline'][0]);
				}
				
				?>"/>
			</div>
		</div><!-- meta-row -->
	
		
		 <div class="meta-row">
			<div class="meta-th">
				<span for="work_editor" class="work_title"><?php _e('Work Duties','sobho_work');?></span>
			</div>
			<?php
				$content = get_post_meta( $post->ID, '_work_duties', true );
				$editor = '_work_duties';
				$settings = array(
					'textarea_rows' => 10,
					'media_buttons' => false,
				);
			wp_editor( $content, $editor, $settings);
			?>
		</div><!-- meta-row -->
	
		
		 
		<div class="meta-row">
			<div class="meta-th">
				<label for="work_minimum_requirements" class="work_title"><?php _e('Minimum Requirements','sobho_work');?></label>
			</div>
			<div class="meta-td">
				<textarea type="text" name="work_minimum_requirements" id="work_minimum_requirements"/><?php
				if(!empty($subho_stored_meta['work_minimum_requirements'])){
					echo esc_attr($subho_stored_meta['work_minimum_requirements'][0]);
				}
				
				?></textarea>
			</div>
		</div><!-- meta-row -->
		
		<div class="meta-row">
			<div class="meta-th">
				<label for="work_preferred_requirements" class="work_title">Preferred Requirements</label>
			</div>
			<div class="meta-td">
				<textarea type="text" name="work_preferred_requirements" id="work_preferred_requirements"/>
				<?php
				if(!empty($subho_stored_meta['work_preferred_requirements'])){
					echo esc_attr($subho_stored_meta['work_preferred_requirements'][0]);
				}
				
				?>
				</textarea>
			</div>
		</div><!-- meta-row -->
		
		<div class="meta-row">
			<div class="meta-th">
				<label for="work_relocation_assistance" class="work_title">Relocation Assistance</label>
			</div>
			<div class="meta-td">
				<select name="relocation_assistance" id="relocation_assistance">
	              <option value="Yes" <?php if ( ! empty ( $subho_stored_meta['relocation_assistance'] ) ) selected( $subho_stored_meta['relocation_assistance'][0], 'Yes' ); ?>><?php _e( 'Yes', 'wp-job-listing' )?></option>';
		          <option value="No" <?php if ( ! empty ( $subho_stored_meta['relocation_assistance'] ) ) selected( $subho_stored_meta['relocation_assistance'][0], 'No' ); ?>><?php _e( 'No', 'wp-job-listing' )?></option>';
	          </select>
			</div>
		</div><!-- meta-row -->
		
		
		
	<?php
}
function workmetabox_action( $post_id ){
$is_valid_nonce = ( isset( $_POST[ 'workmetabox_name' ] ) && wp_verify_nonce( $_POST[ 'workmetabox_name' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
$autosave =  wp_is_post_autosave( $post_id );
$post_rivision = wp_is_post_revision( $post_id );
	if(!$is_valid_nonce || $autosave || $post_rivision){
	return;
	}
	if(isset($_POST['work_in'])){
	update_post_meta($post_id, 'work_in', sanitize_text_field($_POST['work_in']));

	}
	if(isset($_POST['work_listed'])){
	update_post_meta($post_id, 'work_listed', sanitize_text_field($_POST['work_listed']));

	}
	if(isset($_POST['work_application_deadline'])){
	update_post_meta($post_id, 'work_application_deadline',  sanitize_text_field($_POST['work_application_deadline']));

	}
	if(isset($_POST['_work_duties'])){
	update_post_meta($post_id, '_work_duties', esc_textarea($_POST['_work_duties']));

	}
	if(isset($_POST['work_minimum_requirements'])){
	update_post_meta($post_id, 'work_minimum_requirements', wp_kses_post($_POST['work_minimum_requirements']));

	}
	if(isset($_POST['work_preferred_requirements'])){
	update_post_meta($post_id, 'work_preferred_requirements',wp_kses_post($_POST['work_preferred_requirements']));

	}
	
	if(isset($_POST['relocation_assistance'])){
	update_post_meta($post_id, 'relocation_assistance', sanitize_text_field($_POST['relocation_assistance']));

	}
	
	
}
add_action('save_post','workmetabox_action');
















