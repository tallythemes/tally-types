<?php
/**
 * @package Tally Types
 *
 * Register custom Post Type
**/

add_action( 'init', 'tallytypes_register_postType__slider' );
function tallytypes_register_postType__slider() {
	
	$labels = array(
		'name'               => 'Slider',
		'singular_name'      => 'Slider',
		'menu_name'          => 'Sliders',
		'name_admin_bar'     => 'Slider',
		'add_new'            => 'Add New Slider',
		'add_new_item'       => 'Add New Slider',
		'new_item'           => 'New Slider',
		'edit_item'          => 'Edit Slider',
		'view_item'          => 'View Slider',
		'all_items'          => 'Sliders',
		'search_items'       => 'Search Sliders',
		'parent_item_colon'  => 'Parent Sliders:',
		'not_found'          => 'No Sliders found.',
		'not_found_in_trash' => 'No Sliders found in Trash.',
	);

	$args = array(
		'labels'             => apply_filters('tallytypes_slider_labels', $labels),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => true,
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => 101 ,
		'menu_icon'			 => TALLYTYPES_URL.'assets/images/slider-icon.svg',
		'supports'           => array( 'title')
	);

	register_post_type( 'tt_slider', $args );
}


/*	Register Metabox
--------------------------------------*/
$mb_fields = array();
$mb_fields[] = array(
	'id' => 'slider_items_tt',
	'type' => 'group',
	'title' => 'Slider Items',
	'des' => '',
	'class' => '',
	'value' => '',
	'choices' => '',
	'sanitize' => '',
	'items' => array(
		array(
			'id' => 'image',
			'type' => 'image_upload',
			'title' => 'Image',
			'des' => '',
			'class' => '',
			'value' => '',
			'choices' => '',
			'sanitize' => 'wp_kses',
		),
		array(
			'id' => 'content',
			'type' => 'textarea',
			'title' => 'Content',
			'des' => '',
			'class' => '',
			'value' => '',
			'choices' => '',
			'sanitize' => 'wp_kses',
		),
		array(
			'id' => 'button_text',
			'type' => 'text',
			'title' => 'Button Text',
			'des' => '',
			'class' => '',
			'value' => '',
			'choices' => '',
			'sanitize' => 'wp_kses',
		),
		array(
			'id' => 'button_link',
			'type' => 'text',
			'title' => 'Button Link',
			'des' => '',
			'class' => '',
			'value' => '',
			'choices' => '',
			'sanitize' => 'wp_kses',
		),
		array(
			'id' => 'button_text2',
			'type' => 'text',
			'title' => 'Button 2 Text',
			'des' => '',
			'class' => '',
			'value' => '',
			'choices' => '',
			'sanitize' => 'wp_kses',
		),
		array(
			'id' => 'button_link2',
			'type' => 'text',
			'title' => 'Button 2 Link',
			'des' => '',
			'class' => '',
			'value' => '',
			'choices' => '',
			'sanitize' => 'wp_kses',
		),
		array(
			'id' => 'class',
			'type' => 'text',
			'title' => 'Class',
			'des' => '',
			'class' => '',
			'value' => '',
			'choices' => '',
			'sanitize' => 'wp_kses',
		),
	),
);
$mb_fields[] = array(
	'id' => 'dot_nav_tt',
	'type' => 'select',
	'title' => 'Enable Dot Nav',
	'des' => '',
	'class' => '',
	'value' => '',
	'choices' => array(
		array('title' => 'Yes', 'value' => 'yes'),
		array('title' => 'No', 'value' => 'no'),
	),
	'sanitize' => 'wp_kses',
);
$mb_fields[] = array(
	'id' => 'arrow_nav_tt',
	'type' => 'select',
	'title' => 'Enable Arrow Nav',
	'des' => '',
	'class' => '',
	'value' => '',
	'choices' => array(
		array('title' => 'Yes', 'value' => 'yes'),
		array('title' => 'No', 'value' => 'no'),
	),
	'sanitize' => 'wp_kses',
);

new tallytypes_metabox(array(
	'id' => 'tt_slider',
	'title' => 'Settings',
	'post_type' => 'tt_slider',
	'context' => 'normal',
	'priority' => 'default',
	'fields' => $mb_fields,
));