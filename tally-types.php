<?php
/**
 * @package Tally Types
 *
/*
Plugin Name: Tally Types
Plugin URI: http://tallythemes.com/
Description: Provide Custom Post Types and Metaboxes
Version: 3.1
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

if(file_exists(get_stylesheet_directory().'/inc/tallytypes-config.php')){
	include(get_stylesheet_directory().'/inc/tallytypes-config.php');
}elseif(file_exists(get_template_directory().'/inc/tallytypes-config.php')){
	include(get_template_directory().'/inc/tallytypes-config.php');
}
if(!defined('TALLYTYPES_IS_carousel')){ define('TALLYTYPES_IS_carousel', 'no'); }
if(!defined('TALLYTYPES_IS_services')){ define('TALLYTYPES_IS_services', 'no'); }
if(!defined('TALLYTYPES_IS_testimonials')){ define('TALLYTYPES_IS_testimonials', 'no'); }
if(!defined('TALLYTYPES_IS_vcard')){ define('TALLYTYPES_IS_vcard', 'no'); }
if(!defined('TALLYTYPES_IS_grid')){ define('TALLYTYPES_IS_grid', 'no'); }
if(!defined('TALLYTYPES_IS_slider')){ define('TALLYTYPES_IS_slider', 'no'); }
if(!defined('TALLYTYPES_IS_gallery')){ define('TALLYTYPES_IS_gallery', 'no'); }


function tallytypes_options_std($name){
		
	if($name == 'carousel'){
		return TALLYTYPES_IS_carousel;
	}elseif($name == 'services'){
		return TALLYTYPES_IS_services;
	}elseif($name == 'testimonials'){
		return TALLYTYPES_IS_testimonials;
	}elseif($name == 'vcard'){
		return TALLYTYPES_IS_vcard;
	}elseif($name == 'grid'){
		return TALLYTYPES_IS_grid;
	}elseif($name == 'slider'){
		return TALLYTYPES_IS_slider;
	}elseif($name == 'gallery'){
		return TALLYTYPES_IS_gallery;
	}else{
		return 'no';
	}
}

include('includes/metabox-helper.php');
include('includes/script-loader.php');
include('includes/settings-page.php');

$tallytypes_options = get_option( TALLYTYPES_OPTION_NAME);

$tallytypes_is_carousel = (isset($tallytypes_options['carousel'])) ? $tallytypes_options['carousel'] : tallytypes_options_std('gallery');
$tallytypes_is_services = (isset($tallytypes_options['services'])) ? $tallytypes_options['services'] : tallytypes_options_std('services');
$tallytypes_is_testimonials = (isset($tallytypes_options['testimonials'])) ? $tallytypes_options['testimonials'] : tallytypes_options_std('testimonials');
$tallytypes_is_vcard = (isset($tallytypes_options['vcard'])) ? $tallytypes_options['vcard'] : tallytypes_options_std('vcard');
$tallytypes_is_grid = (isset($tallytypes_options['grid'])) ? $tallytypes_options['grid'] : tallytypes_options_std('grid');
$tallytypes_is_slider = (isset($tallytypes_options['slider'])) ? $tallytypes_options['slider'] : tallytypes_options_std('slider');
$tallytypes_is_gallery = (isset($tallytypes_options['gallery'])) ? $tallytypes_options['gallery'] : tallytypes_options_std('gallery');

if($tallytypes_is_carousel == 'yes'){
	include('types/carousel.php');
}
if($tallytypes_is_services == 'yes'){
	include('types/services.php');
}
if($tallytypes_is_testimonials == 'yes'){
	include('types/testimonials.php');
}
if($tallytypes_is_vcard == 'yes'){
	include('types/vcard.php');
}
if($tallytypes_is_grid == 'yes'){
	include('types/grid.php');
}
if($tallytypes_is_slider == 'yes'){
	include('types/slider.php');
}
if($tallytypes_is_gallery == 'yes'){
	include('types/gallery.php');
}

