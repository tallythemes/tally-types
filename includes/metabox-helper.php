<?php
/**
 * @package Tally Types
 *
 * Custom functions for building metabox form fields.
**/


/*	sanitize function
--------------------------------------*/
function tallytypes_mb_field_sanitize($sanitize, $value){
	global $allowedposttags;
	
	$tags = $allowedposttags;
	
	$tags['iframe'] = array(
		'src' => true,
		'width' => true,
		'height' => true,
		'frameborder' => true,
		'style' => true,
		'allowfullscreen' => true,
		'class' => true,
		'id' => true,
	);
	
	if($sanitize == 'wp_kses'){
       $value = $sanitize($value, $tags);
	}else{
		$value = $sanitize($value);
	}
	
	return $value;
}


/*	default arguments of fields
--------------------------------------*/
function tallytypes_mb_field_default_arguments(){
	return array(
		'id' => '',
		'name' => '',
		'title' => '',
		'des' => '',
		'class' => '',
		'value' => '',
		'choices' => '',
		'type' => '',
		'rows' => '4',
		'sanitize' => 'wp_kses',
		'items' => '',
	);
}


/*	Before after function of fields
--------------------------------------*/
function tallytypes_mb_field_before($id, $title, $class){
	echo '<div class="tallytypes_mb_field '.$class.'">';
		echo '<label for="'.$id.'">'.$title.'</label>';
}

function tallytypes_mb_field_after($des){
		echo '<span class="des">'.$des.'</span>';
	echo '</div>';
}



/*	Save function of fields
--------------------------------------*/
function tallytypes_mb_field_save($post_id, $arg){
	extract(array_merge( tallytypes_mb_field_default_arguments(), $arg ));
	
	if ( isset( $_POST[$id] ) ){
		update_post_meta( $post_id, $id, tallytypes_mb_field_sanitize($sanitize, $_POST[$id]) );
		
	}
}




/*	Text
--------------------------------------*/
function tallytypes_mb_field_text($arg){
	extract(array_merge( tallytypes_mb_field_default_arguments(), $arg ));
	if($name == ''){ $name = $id; }
	
	tallytypes_mb_field_before($id, $title, $class);
		echo '<input type="text" name="'.$name.'" id="'.$id.'" value="'.tallytypes_mb_field_sanitize($sanitize, $value).'">';	
	tallytypes_mb_field_after($des);
}


/*	Select
--------------------------------------*/
function tallytypes_mb_field_select($arg){
	extract(array_merge( tallytypes_mb_field_default_arguments(), $arg ));
	if($name == ''){ $name = $id; }
	
	/* doing some data validation for Database output */
	$d_value = tallytypes_mb_field_sanitize($sanitize, $value);

	tallytypes_mb_field_before($id, $title, $class);
		if(is_array($choices)){
			echo '<select name="'.$name.'" id="'.$id.'">';
				foreach($choices as $choice){
					/* doing some data validation for user input */
					$c_value = tallytypes_mb_field_sanitize($sanitize, $choice['value']);
					echo '<option value="'.$c_value.'" '.selected( $d_value, $c_value, false ).'>'.$choice['title'].'</option>';
				}
			echo '</select>';
		}	
	tallytypes_mb_field_after($des);
}



/*	Textarea
--------------------------------------*/
function tallytypes_mb_field_textarea($arg){
	extract(array_merge( tallytypes_mb_field_default_arguments(), $arg ));
	if($name == ''){ $name = $id; }

	tallytypes_mb_field_before($id, $title, $class);
		echo '<textarea type="text" name="'.$name.'" id="'.$id.'" rows="'.$rows.'">'.tallytypes_mb_field_sanitize($sanitize, $value).'</textarea>';
		
	tallytypes_mb_field_after($des);
}


/*	Image Upload
--------------------------------------*/
function tallytypes_mb_field_image_upload($arg){
	extract(array_merge( tallytypes_mb_field_default_arguments(), $arg ));
	if($name == ''){ $name = $id; }

	tallytypes_mb_field_before($id, $title, $class);		
		echo '<img id="'.$id.'-img" src="'. $value.'" width="200" /><br />';
		echo '<input type="text" class="tt-image-upload-field" name="'. $name.'" id="'. $id.'" value="'.tallytypes_mb_field_sanitize($sanitize, $value).'" />';
		echo '<input type="button" name="upload-btn" id="'. $id.'-upload-btn" class="button-primary tt-upload-btn" value="Upload Image" data-tt-input-field-id="#'. $id.'" data-tt-image-id="#'.$id.'-img">';
	tallytypes_mb_field_after($des);
}


/*	group
--------------------------------------*/
function tallytypes_mb_field_group($arg){
	extract(array_merge( tallytypes_mb_field_default_arguments(), $arg ));

	tallytypes_mb_field_before($id, $title, $class);
		if(is_array($items)){
			echo '<div class="ttmbf_group" id="ttmbf_group_'.$id.'">';
				if(is_array($value)){
					foreach($value as $valu){
						echo '<div class="ttmbf_group_item">';
							echo '<div class="ttmbf_group_item_header">';
								echo '<span class="ttmbf_group_item_title">'.($valu['title'] ? $valu['title'] : '--').'</span>';
								echo '<a href="#" class="ttmbf_group_item_edit">Edit</a>';
								echo '<a href="#" class="ttmbf_group_item_delete">Delete</a>';
							echo '</div>';
							echo '<div class="ttmbf_group_item_content">';
								
								tallytypes_mb_field_text(array(
									'id' => $id.'title',
									'name' => $id.'title[]',
									'title' => "Title",
									'value' => $valu['title'],
									'class' => 'ttmbf_group_input_title',
								));
								foreach($items as $item){
									$item['value'] = (isset($valu[$item['id']])) ? $valu[$item['id']] : '';
									$item['name'] = $id.$item['id'].'[]';
									$item['id'] = $id.$item['id'];
									
									$field_function_name = 'tallytypes_mb_field_'.$item['type'];
									if(function_exists($field_function_name)){
										$field_function_name($item);
									}
								}
								echo '<input type="hidden" name="'.$id.'hidden[]" value="1">';
							echo '</div>';
						echo '</div>';
					}
				}
			echo '</div>';
			echo '<a href="#" class="button-primary ttmbf_add_new_group" id="ttmbf_add_new_group_'.$id.'">Add New</a>';
			
			echo '<div style="display:none;" id="ttmbf_group_temp_'.$id.'"></div>';
			
			echo '<div class="ttmbf_group_sample" style="display:none;" id="ttmbf_group_sample_'.$id.'">';
				echo '<div class="ttmbf_group_item">';
					echo '<div class="ttmbf_group_item_header">';
						echo '<span class="ttmbf_group_item_title">--</span>';
						echo '<a href="#" class="ttmbf_group_item_edit">Edit</a>';
						echo '<a href="#" class="ttmbf_group_item_delete">Delete</a>';
					echo '</div>';
					echo '<div class="ttmbf_group_item_content">';
						tallytypes_mb_field_text(array(
							'id' => $id.'title',
							'name' => $id.'title[]',
							'title' => "Title",
							'value' => '',
							'class' => 'ttmbf_group_input_title',
						));
						foreach($items as $item){
							$item['name'] = $id.$item['id'].'[]';
							$item['id'] = $id.$item['id'];
							
							$field_function_name = 'tallytypes_mb_field_'.$item['type'];
							if(function_exists($field_function_name)){
								$field_function_name($item);
							}
						
						}
						echo '<input type="hidden" name="'.$id.'hidden[]" value="1">';
					echo '</div>';
				echo '</div>';
			echo '</div>';
		}
	tallytypes_mb_field_after($des);
	?>
    <script type="text/javascript">
		jQuery(document).ready(function($){
			$(".ttmbf_group_sample :input").attr("disabled", true);
			
			$('#ttmbf_add_new_group_<?php echo $id; ?>').click(function(){
				
				$('#ttmbf_group_sample_<?php echo $id; ?> .ttmbf_group_item').clone().appendTo("#ttmbf_group_temp_<?php echo $id; ?>");
				$("#ttmbf_group_temp_<?php echo $id; ?> :input").attr("disabled", false);
					
				$('#ttmbf_group_temp_<?php echo $id; ?> .ttmbf_group_item').clone().appendTo("#ttmbf_group_<?php echo $id; ?>");
				$('#ttmbf_group_temp_<?php echo $id; ?> .ttmbf_group_item').remove();
				
				//$('#ttmbf_group_sample_<?php echo $id; ?> .ttmbf_group_item').clone().appendTo("#ttmbf_group_<?php echo $id; ?>");
				
				return false;
			});
			
			$( ".ttmbf_group" ).on('click', '.ttmbf_group_item_edit',function() {
				$(this).parent().next().toggle(400, 'linear');
			  	return false;
			});
			
			$( ".ttmbf_group" ).on('click', '.ttmbf_group_item_delete',function() {
				if(confirm("Are you sure? You are going to delete it.")){
					$(this).parent().parent().remove();
					return false;
				}
			});
			
			jQuery(".ttmbf_group").sortable({
				'tolerance':'intersect',
				'cursor':'pointer',
				'items':'.ttmbf_group_item',
				'placeholder':'placeholder',
				'nested': 'tbody'
			});
			//jQuery(".ttmbf_group").disableSelection();
		});
	</script>
    <?php
}

/*	Save group
--------------------------------------*/
function tallytypes_mb_group_field_save($post_id, $arg){
	extract(array_merge( tallytypes_mb_field_default_arguments(), $arg ));
	
	$new_data = array();
	$count = count(  $_POST[$id.'hidden'] );
	
	for ( $i = 0; $i < $count; $i++ ) {
		
		$get_form_data = $_POST[$id.'title'];
		$new_data[$i]['title'] = $get_form_data[$i];
		
		if(is_array($items)){
			foreach($items as $item){
				$get_form_data = $_POST[$id.$item['id']];
				$new_data[$i][$item['id']] = $get_form_data[$i];
			}
		}
	}

	update_post_meta( $post_id, $id, $new_data );
		
}


/*	Class of the metabox generator
--------------------------------------*/
class tallytypes_metabox{
	
	public $mb_id;
	public $mb_title;
	public $mb_post_type;
	public $mb_context;
	public $mb_priority;
	public $mb_fields;
	
	function __construct($arg){
		$arg = array_merge( array(
			'id' => '',
			'title' => '',
			'post_type' => 'post',
			'context' => 'normal',
			'priority' => 'default',
			'fields' => '',
		), $arg );
		
		$this->mb_id = $arg['id'];
		$this->mb_title = $arg['title'];
		$this->mb_post_type = $arg['post_type'];
		$this->mb_context = $arg['context'];
		$this->mb_priority = $arg['priority'];
		$this->mb_fields = $arg['fields'];
		
		add_action( 'add_meta_boxes', array($this, 'add_metabox') );
		add_action( 'save_post', array($this, 'save') );
	}
	
	
	function add_metabox(){
		add_meta_box(
			$this->mb_id,
			$this->mb_title,
			array($this, 'metabox_html'),
			$this->mb_post_type,
			$this->mb_context,
			$this->mb_priority
		);
	}
	
	
	function metabox_html($post){
		wp_nonce_field( '_'.$this->mb_id.'_nonce', $this->mb_id.'_nonce' );
		
		$fields = $this->mb_fields;
		if(is_array($fields)){
			foreach($fields as $field){
				$saved_value = get_post_meta($post->ID, $field['id'], true);
				if($saved_value != ''){
					$field['value'] = $saved_value;
				}
				if($field['type'] == 'text'){
					tallytypes_mb_field_text($field);
				}elseif($field['type'] == 'textarea'){
					tallytypes_mb_field_textarea($field);
				}elseif($field['type'] == 'select'){
					tallytypes_mb_field_select($field);
				}elseif($field['type'] == 'image_upload'){
					tallytypes_mb_field_image_upload($field);
				}elseif($field['type'] == 'group'){
					tallytypes_mb_field_group($field);
				}
			}
		}
	}
	
	
	function save($post_id){
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
		if ( ! isset( $_POST[$this->mb_id.'_nonce'] ) || ! wp_verify_nonce( $_POST[$this->mb_id.'_nonce'], '_'.$this->mb_id.'_nonce' ) ) return;
		if ( ! current_user_can( 'edit_post', $post_id ) ) return;
		
		$fields = $this->mb_fields;
		if(is_array($fields)){
			foreach($fields as $field){
				if($field['type'] == 'group'){
					tallytypes_mb_group_field_save($post_id, $field);
				}else{
					tallytypes_mb_field_save($post_id, $field);
				}
			}
		}
	}
}