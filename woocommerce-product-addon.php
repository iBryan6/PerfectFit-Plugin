<?php
/*
Plugin Name: Perfecto Estilo
Description: Plugin a medida para la Empresa JULYO'S.
Version: 16.7
Author: Bryan Argandoña
Domain Path: /languages
*/

// @since 6.1
if( ! defined('ABSPATH' ) ){
	exit;
}

define('PPOM_PATH', untrailingslashit(plugin_dir_path( __FILE__ )) );
define('PPOM_URL', untrailingslashit(plugin_dir_url( __FILE__ )) );
define('PPOM_WP_PLUGIN_DIR', untrailingslashit( plugin_dir_path( __DIR__ ) ));
define('PPOM_VERSION', 16.7);
define('PPOM_DB_VERSION', 16.7);
define("PPOM_PRODUCT_META_KEY", '_product_meta_id');
define('PPOM_TABLE_META', 'nm_personalized');
define('PPOM_UPLOAD_DIR_NAME', 'ppom_files');


include_once PPOM_PATH . "/inc/functions.php";
include_once PPOM_PATH . "/inc/deprecated.php";
include_once PPOM_PATH . "/inc/arrays.php";
include_once PPOM_PATH . "/inc/hooks.php";
include_once PPOM_PATH . "/inc/woocommerce.php";
include_once PPOM_PATH . "/inc/admin.php";
include_once PPOM_PATH . "/inc/files.php";
include_once PPOM_PATH . "/inc/nmInput.class.php";
include_once PPOM_PATH . "/inc/rest.class.php";


/* ======= For now we are including class file, we will replace  =========== */
// include_once PPOM_PATH . "/classes/nm-framework.php";
include_once PPOM_PATH . "/classes/input.class.php";
include_once PPOM_PATH . "/classes/fields.class.php";
include_once PPOM_PATH . "/classes/ppom.class.php";
include_once PPOM_PATH . "/classes/plugin.class.php";

if( is_admin() ){

	include_once PPOM_PATH . "/classes/admin.class.php";

	$ppom_admin = new NM_PersonalizedProduct_Admin();
	
	$ppom_basename = plugin_basename( __FILE__ );
	add_filter( "plugin_action_links_{$ppom_basename}", 'ppom_settings_link');
}


// ==================== INITIALIZE PLUGIN CLASS =======================
//
add_action('woocommerce_init', 'PPOM');
//
// ==================== INITIALIZE PLUGIN CLASS =======================

function PPOM(){
	return NM_PersonalizedProduct::get_instance();
}

/*
 * activation/install the plugin data
*/
register_activation_hook( __FILE__, array('NM_PersonalizedProduct', 'activate_plugin'));
register_deactivation_hook( __FILE__, array('NM_PersonalizedProduct', 'deactivate_plugin'));