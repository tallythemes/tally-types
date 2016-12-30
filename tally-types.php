<?php
/**
 * @package Tally Types
 *
/*
Plugin Name: Tally Types
Plugin URI: http://tallythemes.com/
Description: Provide Custom Post Types and Metaboxes
Version: 3.0
Author: TallyThemes
Author URI: http://tallythemes.com/
License: GPLv2 or later
Text Domain: tally-types
Prefix: tallytypes_
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA..
*/

// Make sure we don't expose any info if called directly

if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}

define( 'TALLYTYPES_URL', plugin_dir_url( __FILE__ ) );
define( 'TALLYTYPES_DRI', plugin_dir_path( __FILE__ ) );

define( 'TALLYTYPES_OPTION_NAME', apply_filters('tallytypes_option_name', 'tallytypes_option') );

define( 'TALLYTYPES_ENABLE_CAROUSEL', apply_filters('tallytypes_enable_carousel', false) );
define( 'TALLYTYPES_ENABLE_SERVICES', apply_filters('tallytypes_enable_services', false) );
define( 'TALLYTYPES_ENABLE_TESTIMONIALS', apply_filters('tallytypes_enable_testimonials', false) );
define( 'TALLYTYPES_ENABLE_VCARD', apply_filters('tallytypes_enable_vcard', false) );
define( 'TALLYTYPES_ENABLE_GRID', apply_filters('tallytypes_enable_grid', false) );
define( 'TALLYTYPES_ENABLE_SLIDER', apply_filters('tallytypes_enable_slider', false) );
define( 'TALLYTYPES_ENABLE_GALLERY', apply_filters('tallytypes_enable_gallery', false) );

include('includes/metabox-helper.php');
include('includes/script-loader.php');
include('includes/settings-page.php');

$tallytypes_options = get_option( TALLYTYPES_OPTION_NAME );

$tallytypes_is_carousel = (isset($tallytypes_options['carousel'])) ? $tallytypes_options['carousel'] : TALLYTYPES_ENABLE_CAROUSEL;
$tallytypes_is_services = (isset($tallytypes_options['services'])) ? $tallytypes_options['services'] : TALLYTYPES_ENABLE_SERVICES;
$tallytypes_is_testimonials = (isset($tallytypes_options['testimonials'])) ? $tallytypes_options['testimonials'] : TALLYTYPES_ENABLE_TESTIMONIALS;
$tallytypes_is_vcard = (isset($tallytypes_options['vcard'])) ? $tallytypes_options['vcard'] : TALLYTYPES_ENABLE_VCARD;
$tallytypes_is_grid = (isset($tallytypes_options['grid'])) ? $tallytypes_options['grid'] : TALLYTYPES_ENABLE_GRID;
$tallytypes_is_slider = (isset($tallytypes_options['slider'])) ? $tallytypes_options['slider'] : TALLYTYPES_ENABLE_SLIDER;
$tallytypes_is_gallery = (isset($tallytypes_options['gallery'])) ? $tallytypes_options['gallery'] : TALLYTYPES_ENABLE_GALLERY;

if($tallytypes_is_carousel == true){
	include('types/carousel.php');
}
if($tallytypes_is_services == true){
	include('types/services.php');
}
if($tallytypes_is_testimonials == true){
	include('types/testimonials.php');
}
if($tallytypes_is_vcard == true){
	include('types/vcard.php');
}
if($tallytypes_is_grid == true){
	include('types/grid.php');
}
if($tallytypes_is_slider == true){
	include('types/slider.php');
}
if($tallytypes_is_gallery == true){
	include('types/gallery.php');
}