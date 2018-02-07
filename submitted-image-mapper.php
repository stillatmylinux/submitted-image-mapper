<?php
/**
 * Plugin Name: Submitted Image Mapper
 * Plugin URI: https://stillatmylinux.com/
 * Description: A submitted image mapper
 * Version: 0.1.2
 * Author: Stillatmylinux
 * Author URI: https://stillatmylinux.com
 * Requires at least: 4.4
 * Tested up to: 4.9
 *
 * Text Domain: simgmap
 * Domain Path: /i18n/languages/
 * 
 * Requires: https://github.com/remoorejr/cordova-plugin-camera-with-exif
 *
 * @package SubmittedImageMapper
 * @category Core
 * @author Stillatmylinux
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Include the main class.
if ( ! class_exists( 'SubmittedImageMapper' ) ) {
	
	if(is_admin()) {
		include_once dirname( __FILE__ ) . '/inc/class-admin-page.php';
		$simAdminPage = new SimAdminPage();
		$simAdminPage->hooks();
	}

	include_once dirname( __FILE__ ) . '/inc/template-parts.php';
	include_once dirname( __FILE__ ) . '/inc/class-subimg-mapper.php';
	include_once dirname( __FILE__ ) . '/inc/class-img-geolocation.php';
	include_once dirname( __FILE__ ) . '/inc/appcamera-compatibility.php';
	include_once dirname( __FILE__ ) . '/inc/appgeo-compatibility.php';
	include_once dirname( __FILE__ ) . '/inc/class-cpt.php';
	include_once dirname( __FILE__ ) . '/inc/class-shortcodes.php';


	$submittedImageMapper = new SubmittedImageMapper();
	$submittedImageMapper->hooks();

	$sim_AppCamera_Compatibility = new SIM_AppCamera_Compatibility();
	$sim_AppCamera_Compatibility->hooks();

	$sim_AppGeo_Compatibility = new SIM_AppGeo_Compatibility();
	$sim_AppGeo_Compatibility->hooks();

	$sim_SubmittedPhoto_CPT = new SIM_SubmittedPhoto_CPT();
	$sim_SubmittedPhoto_CPT->hooks();

	$sim_Shortcodes = new SimShortcodes();
	$sim_Shortcodes->hooks();
}