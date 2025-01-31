<?php
/**
 * Copyright (C) 2014-2019 ServMask Inc.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * ███████╗███████╗██████╗ ██╗   ██╗███╗   ███╗ █████╗ ███████╗██╗  ██╗
 * ██╔════╝██╔════╝██╔══██╗██║   ██║████╗ ████║██╔══██╗██╔════╝██║ ██╔╝
 * ███████╗█████╗  ██████╔╝██║   ██║██╔████╔██║███████║███████╗█████╔╝
 * ╚════██║██╔══╝  ██╔══██╗╚██╗ ██╔╝██║╚██╔╝██║██╔══██║╚════██║██╔═██╗
 * ███████║███████╗██║  ██║ ╚████╔╝ ██║ ╚═╝ ██║██║  ██║███████║██║  ██╗
 * ╚══════╝╚══════╝╚═╝  ╚═╝  ╚═══╝  ╚═╝     ╚═╝╚═╝  ╚═╝╚══════╝╚═╝  ╚═╝
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Kangaroos cannot jump here' );
}

class Cpiwm_Main_Controller {

	/**
	 * Main Application Controller
	 *
	 * @return Cpiwm_Main_Controller
	 */
	public function __construct() {
		register_activation_hook( CPIWM_PLUGIN_BASENAME, array( $this, 'activation_hook' ) );

		// Activate hooks
		$this->activate_actions();
		$this->activate_filters();
	}

	/**
	 * Activation hook callback
	 *
	 * @return void
	 */
	public function activation_hook() {
		if ( is_dir( CPIWM_BACKUPS_PATH ) ) {
			$this->create_backups_htaccess( CPIWM_BACKUPS_HTACCESS );
			$this->create_backups_webconfig( CPIWM_BACKUPS_WEBCONFIG );
			$this->create_backups_index( CPIWM_BACKUPS_INDEX );
		}

		if ( extension_loaded( 'litespeed' ) ) {
			$this->create_litespeed_htaccess( CPIWM_WORDPRESS_HTACCESS );
		}

		$this->setup_folders();
		$this->create_secret_key();
	}

	/**
	 * Initializes language domain for the plugin
	 *
	 * @return void
	 */
	public function load_textdomain() {
		load_plugin_textdomain( CPIWM_PLUGIN_NAME, false, false );
	}

	/**
	 * Register listeners for actions
	 *
	 * @return void
	 */
	private function activate_actions() {
		// Init
		add_action( 'admin_init', array( $this, 'init' ) );

		// Router
		add_action( 'admin_init', array( $this, 'router' ) );

		// Setup folders
		add_action( 'admin_init', array( $this, 'setup_folders' ) );

		// Create secret key
		add_action( 'admin_init', array( $this, 'create_secret_key' ) );

		// Check user role capability
		add_action( 'admin_init', array( $this, 'check_user_role_capability' ) );

		// Schedule crons
		add_action( 'admin_init', array( $this, 'schedule_crons' ) );

		// Load text domain
		add_action( 'admin_init', array( $this, 'load_textdomain' ) );

		// Admin header
		add_action( 'admin_head', array( $this, 'admin_head' ) );

		// CPI WP Migration
		add_action( 'plugins_loaded', array( $this, 'cpiwm_loaded' ), 10 );

		// Export and import commands
		add_action( 'plugins_loaded', array( $this, 'cpiwm_commands' ), 10 );

		// Export and import buttons
		add_action( 'plugins_loaded', array( $this, 'cpiwm_buttons' ), 10 );

		// WP CLI commands
		add_action( 'plugins_loaded', array( $this, 'wp_cli' ), 10 );

		// Register scripts and styles
		add_action( 'admin_enqueue_scripts', array( $this, 'register_scripts_and_styles' ), 5 );

		// Enqueue export scripts and styles
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_export_scripts_and_styles' ), 5 );

		// Enqueue import scripts and styles
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_import_scripts_and_styles' ), 5 );

		// Enqueue backups scripts and styles
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_backups_scripts_and_styles' ), 5 );

		// Enqueue updater scripts and styles
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_updater_scripts_and_styles' ), 5 );
	}

	/**
	 * Register listeners for filters
	 *
	 * @return void
	 */
	private function activate_filters() {
		// Add links to plugin list page
		add_filter( 'plugin_row_meta', array( $this, 'plugin_row_meta' ), 10, 2 );

		// Add custom schedules
		add_filter( 'cron_schedules', array( $this, 'add_cron_schedules' ), 9999 );
	}

	/**
	 * Export and import commands
	 *
	 * @return void
	 */
	public function cpiwm_commands() {
		// Add export commands
		add_filter( 'cpiwm_export', 'Cpiwm_Export_Init::execute', 5 );
		add_filter( 'cpiwm_export', 'Cpiwm_Export_Compatibility::execute', 5 );
		add_filter( 'cpiwm_export', 'Cpiwm_Export_Archive::execute', 10 );
		add_filter( 'cpiwm_export', 'Cpiwm_Export_Config::execute', 50 );
		add_filter( 'cpiwm_export', 'Cpiwm_Export_Config_File::execute', 60 );
		add_filter( 'cpiwm_export', 'Cpiwm_Export_Enumerate::execute', 100 );
		add_filter( 'cpiwm_export', 'Cpiwm_Export_Content::execute', 150 );
		add_filter( 'cpiwm_export', 'Cpiwm_Export_Database::execute', 200 );
		add_filter( 'cpiwm_export', 'Cpiwm_Export_Database_File::execute', 220 );
		add_filter( 'cpiwm_export', 'Cpiwm_Export_Download::execute', 250 );
		add_filter( 'cpiwm_export', 'Cpiwm_Export_Clean::execute', 300 );

		// Add import commands
		add_filter( 'cpiwm_import', 'Cpiwm_Import_Upload::execute', 5 );
		add_filter( 'cpiwm_import', 'Cpiwm_Import_Compatibility::execute', 10 );
		add_filter( 'cpiwm_import', 'Cpiwm_Import_Validate::execute', 50 );
		add_filter( 'cpiwm_import', 'Cpiwm_Import_Confirm::execute', 100 );
		add_filter( 'cpiwm_import', 'Cpiwm_Import_Blogs::execute', 150 );
		add_filter( 'cpiwm_import', 'Cpiwm_Import_Enumerate::execute', 200 );
		add_filter( 'cpiwm_import', 'Cpiwm_Import_Content::execute', 250 );
		add_filter( 'cpiwm_import', 'Cpiwm_Import_Mu_Plugins::execute', 270 );
		add_filter( 'cpiwm_import', 'Cpiwm_Import_Database::execute', 300 );
		add_filter( 'cpiwm_import', 'Cpiwm_Import_Plugins::execute', 340 );
		add_filter( 'cpiwm_import', 'Cpiwm_Import_Done::execute', 350 );
		add_filter( 'cpiwm_import', 'Cpiwm_Import_Clean::execute', 400 );
	}

	/**
	 * Export and import buttons
	 *
	 * @return void
	 */
	public function cpiwm_buttons() {
		// Add export buttons
		add_filter( 'cpiwm_export_buttons', 'Cpiwm_Export_Controller::buttons' );

		// Add import buttons
		add_filter( 'cpiwm_import_buttons', 'Cpiwm_Import_Controller::buttons' );

		add_filter( 'cpiwm_pro', 'Cpiwm_Import_Controller::pro', 10 );
	}

	/**
	 * CPI WP Migration loaded
	 *
	 * @return void
	 */
	public function cpiwm_loaded() {
		if ( ! defined( 'CPIWMME_PLUGIN_NAME' ) ) {
			if ( is_multisite() ) {
				add_action( 'network_admin_notices', array( $this, 'multisite_notice' ) );
			} else {
				add_action( 'admin_menu', array( $this, 'admin_menu' ) );
			}
		} else {
			if ( is_multisite() ) {
				add_action( 'network_admin_menu', array( $this, 'admin_menu' ) );
			} else {
				add_action( 'admin_menu', array( $this, 'admin_menu' ) );
			}
		}

		// Add automatic plugins update
		add_action( 'wp_maybe_auto_update', 'Cpiwm_Updater_Controller::check_for_updates' );

		// Add HTTP export headers
		add_filter( 'cpiwm_http_export_headers', 'Cpiwm_Export_Controller::http_export_headers' );

		// Add HTTP import headers
		add_filter( 'cpiwm_http_import_headers', 'Cpiwm_Import_Controller::http_import_headers' );

		// Add chunk size limit
		add_filter( 'cpiwm_max_chunk_size', 'Cpiwm_Import_Controller::max_chunk_size' );

		// Add plugins api
		add_filter( 'plugins_api', 'Cpiwm_Updater_Controller::plugins_api', 20, 3 );

		// Add plugins updates
		add_filter( 'pre_set_site_transient_update_plugins', 'Cpiwm_Updater_Controller::pre_update_plugins' );

		// Add plugins metadata
		add_filter( 'site_transient_update_plugins', 'Cpiwm_Updater_Controller::update_plugins' );

		// Add "Check for updates" link to plugin list page
		add_filter( 'plugin_row_meta', 'Cpiwm_Updater_Controller::plugin_row_meta', 10, 2 );

		// Add storage folder daily cleanup cron
		add_action( 'cpiwm_storage_cleanup', 'Cpiwm_Export_Controller::cleanup' );
	}

	/**
	 * WP CLI commands
	 *
	 * @return void
	 */
	public function wp_cli() {
		if ( defined( 'WP_CLI' ) ) {
			WP_CLI::add_command( 'cpiwm', 'Cpiwm_WP_CLI_Command', array( 'shortdesc' => __( 'CPI WP Migration Command', CPIWM_PLUGIN_NAME ) ) );
		}
	}

	/**
	 * Create folders and files needed for plugin operation, if they don't exist
	 *
	 * @return void
	 */
	public function setup_folders() {
		// Check if storage folder is created
		if ( ! is_dir( CPIWM_STORAGE_PATH ) ) {
			$this->create_storage_folder( CPIWM_STORAGE_PATH );
		}

		// Check if backups folder is created
		if ( ! is_dir( CPIWM_BACKUPS_PATH ) ) {
			$this->create_backups_folder( CPIWM_BACKUPS_PATH );
		}

		// Check if index.php is created in storage folder
		if ( ! is_file( CPIWM_STORAGE_INDEX ) ) {
			$this->create_storage_index( CPIWM_STORAGE_INDEX );
		}

		// Check if index.php is created in backups folder
		if ( ! is_file( CPIWM_BACKUPS_INDEX ) ) {
			$this->create_backups_index( CPIWM_BACKUPS_INDEX );
		}

		// Check if .htaccess is created in backups folder
		if ( ! is_file( CPIWM_BACKUPS_HTACCESS ) ) {
			$this->create_backups_htaccess( CPIWM_BACKUPS_HTACCESS );
		}

		// Check if web.config is created in backups folder
		if ( ! is_file( CPIWM_BACKUPS_WEBCONFIG ) ) {
			$this->create_backups_webconfig( CPIWM_BACKUPS_WEBCONFIG );
		}
	}

	/**
	 * Create secret key if they don't exist yet
	 *
	 * @return void
	 */
	public function create_secret_key() {
		if ( ! get_option( CPIWM_SECRET_KEY ) ) {
			update_option( CPIWM_SECRET_KEY, wp_generate_password( 12, false ) );
		}
	}

	/**
	 * Check user role capability
	 *
	 * @return void
	 */
	public function check_user_role_capability() {
		if ( ( $user = wp_get_current_user() ) && in_array( 'administrator', $user->roles ) ) {
			if ( ! $user->has_cap( 'export' ) || ! $user->has_cap( 'import' ) ) {
				if ( is_multisite() ) {
					return add_action( 'network_admin_notices', array( $this, 'missing_role_capability_notice' ) );
				} else {
					return add_action( 'admin_notices', array( $this, 'missing_role_capability_notice' ) );
				}
			}
		}
	}

	/**
	 * Schedule cron tasks for plugin operation, if not done yet
	 *
	 * @return void
	 */
	public function schedule_crons() {
		// Delete old cleanup cronjob
		if ( Cpiwm_Cron::exists( 'cpiwm_cleanup_cron' ) ) {
			Cpiwm_Cron::clear( 'cpiwm_cleanup_cron' );
		}

		// Schedule a new daily cleanup
		if ( ! Cpiwm_Cron::exists( 'cpiwm_storage_cleanup' ) ) {
			Cpiwm_Cron::add( 'cpiwm_storage_cleanup', 'daily', time() );
		}
	}

	/**
	 * Create storage folder
	 *
	 * @param  string Path to folder
	 * @return void
	 */
	public function create_storage_folder( $path ) {
		if ( ! Cpiwm_Directory::create( $path ) ) {
			if ( is_multisite() ) {
				return add_action( 'network_admin_notices', array( $this, 'storage_path_notice' ) );
			} else {
				return add_action( 'admin_notices', array( $this, 'storage_path_notice' ) );
			}
		}
	}

	/**
	 * Create backups folder
	 *
	 * @param  string Path to folder
	 * @return void
	 */
	public function create_backups_folder( $path ) {
		if ( ! Cpiwm_Directory::create( $path ) ) {
			if ( is_multisite() ) {
				return add_action( 'network_admin_notices', array( $this, 'backups_path_notice' ) );
			} else {
				return add_action( 'admin_notices', array( $this, 'backups_path_notice' ) );
			}
		}
	}

	/**
	 * Create storage index.php file
	 *
	 * @param  string Path to file
	 * @return void
	 */
	public function create_storage_index( $path ) {
		if ( ! Cpiwm_File_Index::create( $path ) ) {
			if ( is_multisite() ) {
				return add_action( 'network_admin_notices', array( $this, 'storage_index_notice' ) );
			} else {
				return add_action( 'admin_notices', array( $this, 'storage_index_notice' ) );
			}
		}
	}

	/**
	 * Create backups .htaccess file
	 *
	 * @param  string Path to file
	 * @return void
	 */
	public function create_backups_htaccess( $path ) {
		if ( ! Cpiwm_File_Htaccess::create( $path ) ) {
			if ( is_multisite() ) {
				return add_action( 'network_admin_notices', array( $this, 'backups_htaccess_notice' ) );
			} else {
				return add_action( 'admin_notices', array( $this, 'backups_htaccess_notice' ) );
			}
		}
	}

	/**
	 * Create backups web.config file
	 *
	 * @param  string Path to file
	 * @return void
	 */
	public function create_backups_webconfig( $path ) {
		if ( ! Cpiwm_File_Webconfig::create( $path ) ) {
			if ( is_multisite() ) {
				return add_action( 'network_admin_notices', array( $this, 'backups_webconfig_notice' ) );
			} else {
				return add_action( 'admin_notices', array( $this, 'backups_webconfig_notice' ) );
			}
		}
	}

	/**
	 * Create backups index.php file
	 *
	 * @param  string Path to file
	 * @return void
	 */
	public function create_backups_index( $path ) {
		if ( ! Cpiwm_File_Index::create( $path ) ) {
			if ( is_multisite() ) {
				return add_action( 'network_admin_notices', array( $this, 'backups_index_notice' ) );
			} else {
				return add_action( 'admin_notices', array( $this, 'backups_index_notice' ) );
			}
		}
	}

	/**
	 * If the "noabort" environment variable has been set,
	 * the script will continue to run even though the connection has been broken
	 *
	 * @return void
	 */
	public function create_litespeed_htaccess( $path ) {
		if ( ! Cpiwm_File_Htaccess::litespeed( $path ) ) {
			if ( is_multisite() ) {
				return add_action( 'network_admin_notices', array( $this, 'wordpress_htaccess_notice' ) );
			} else {
				return add_action( 'admin_notices', array( $this, 'wordpress_htaccess_notice' ) );
			}
		}
	}

	/**
	 * Display multisite notice
	 *
	 * @return void
	 */
	public function multisite_notice() {
		Cpiwm_Template::render( 'main/multisite-notice' );
	}

	/**
	 * Display notice for storage directory
	 *
	 * @return void
	 */
	public function storage_path_notice() {
		Cpiwm_Template::render( 'main/storage-path-notice' );
	}

	/**
	 * Display notice for index file in storage directory
	 *
	 * @return void
	 */
	public function storage_index_notice() {
		Cpiwm_Template::render( 'main/storage-index-notice' );
	}

	/**
	 * Display notice for backups directory
	 *
	 * @return void
	 */
	public function backups_path_notice() {
		Cpiwm_Template::render( 'main/backups-path-notice' );
	}

	/**
	 * Display notice for .htaccess file in backups directory
	 *
	 * @return void
	 */
	public function backups_htaccess_notice() {
		Cpiwm_Template::render( 'main/backups-htaccess-notice' );
	}

	/**
	 * Display notice for web.config file in backups directory
	 *
	 * @return void
	 */
	public function backups_webconfig_notice() {
		Cpiwm_Template::render( 'main/backups-webconfig-notice' );
	}

	/**
	 * Display notice for index file in backups directory
	 *
	 * @return void
	 */
	public function backups_index_notice() {
		Cpiwm_Template::render( 'main/backups-index-notice' );
	}

	/**
	 * Display notice for .htaccess file in WordPress directory
	 *
	 * @return void
	 */
	public function wordpress_htaccess_notice() {
		Cpiwm_Template::render( 'main/wordpress-htaccess-notice' );
	}

	/**
	 * Display notice for missing role capability
	 *
	 * @return void
	 */
	public function missing_role_capability_notice() {
		Cpiwm_Template::render( 'main/missing-role-capability-notice' );
	}

	/**
	 * Add links to plugin list page
	 *
	 * @return array
	 */
	public function plugin_row_meta( $links, $file ) {
		if ( $file === CPIWM_PLUGIN_BASENAME ) {
			$links[] = Cpiwm_Template::get_content( 'main/get-support' );
		}

		return $links;
	}

	/**
	 * Register plugin menus
	 *
	 * @return void
	 */
	public function admin_menu() {
		// Top-level WP Migration menu
		add_menu_page(
			'CPI WP Migration',
			'CPI WP Migration',
			'export',
			'cpiwm_export',
			'Cpiwm_Export_Controller::index',
			'',
			'76.295'
		);

		// Sub-level Export menu
		add_submenu_page(
			'cpiwm_export',
			__( 'Export', CPIWM_PLUGIN_NAME ),
			__( 'Export', CPIWM_PLUGIN_NAME ),
			'export',
			'cpiwm_export',
			'Cpiwm_Export_Controller::index'
		);

		// Sub-level Import menu
		add_submenu_page(
			'cpiwm_export',
			__( 'Import', CPIWM_PLUGIN_NAME ),
			__( 'Import', CPIWM_PLUGIN_NAME ),
			'import',
			'cpiwm_import',
			'Cpiwm_Import_Controller::index'
		);

		// Sub-level Backups menu
		add_submenu_page(
			'cpiwm_export',
			__( 'Backups', CPIWM_PLUGIN_NAME ),
			__( 'Backups', CPIWM_PLUGIN_NAME ),
			'import',
			'cpiwm_backups',
			'Cpiwm_Backups_Controller::index'
		);
	}

	/**
	 * Register scripts and styles
	 *
	 * @return void
	 */
	public function register_scripts_and_styles() {
		if ( is_rtl() ) {
			wp_register_style(
				'cpiwm_servmask',
				Cpiwm_Template::asset_link( 'css/servmask.min.rtl.css' )
			);
		} else {
			wp_register_style(
				'cpiwm_servmask',
				Cpiwm_Template::asset_link( 'css/servmask.min.css' )
			);
		}

		wp_register_script(
			'cpiwm_util',
			Cpiwm_Template::asset_link( 'javascript/util.min.js' ),
			array( 'jquery' )
		);

		wp_register_script(
			'cpiwm_settings',
			Cpiwm_Template::asset_link( 'javascript/settings.min.js' ),
			array( 'cpiwm_util' )
		);

		wp_localize_script(
			'cpiwm_settings',
			'cpiwm_locale',
			array(
				'leave_feedback'                      => __( 'Leave plugin developers any feedback here', CPIWM_PLUGIN_NAME ),
				'how_may_we_help_you'                 => __( 'How may we help you?', CPIWM_PLUGIN_NAME ),
				'thanks_for_submitting_your_feedback' => __( 'Thanks for submitting your feedback!', CPIWM_PLUGIN_NAME ),
				'thanks_for_submitting_your_request'  => __( 'Thanks for submitting your request!', CPIWM_PLUGIN_NAME ),
			)
		);
	}

	/**
	 * Enqueue scripts and styles for Export Controller
	 *
	 * @param  string $hook Hook suffix
	 * @return void
	 */
	public function enqueue_export_scripts_and_styles( $hook ) {
		if ( stripos( 'toplevel_page_cpiwm_export', $hook ) === false ) {
			return;
		}

		// We don't want heartbeat to occur when exporting
		wp_deregister_script( 'heartbeat' );

		// We don't want auth check for monitoring whether the user is still logged in
		remove_action( 'admin_enqueue_scripts', 'wp_auth_check_load' );

		if ( is_rtl() ) {
			wp_enqueue_style(
				'cpiwm_export',
				Cpiwm_Template::asset_link( 'css/export.min.rtl.css' )
			);
		} else {
			wp_enqueue_style(
				'cpiwm_export',
				Cpiwm_Template::asset_link( 'css/export.min.css' )
			);
		}

		wp_enqueue_script(
			'cpiwm_export',
			Cpiwm_Template::asset_link( 'javascript/export.min.js' ),
			array( 'cpiwm_util' )
		);

		wp_localize_script(
			'cpiwm_export',
			'cpiwm_feedback',
			array(
				'ajax'       => array(
					'url' => wp_make_link_relative( admin_url( 'admin-ajax.php?action=cpiwm_feedback' ) ),
				),
				'secret_key' => get_option( CPIWM_SECRET_KEY ),
			)
		);

		wp_localize_script(
			'cpiwm_export',
			'cpiwm_report',
			array(
				'ajax'       => array(
					'url' => wp_make_link_relative( admin_url( 'admin-ajax.php?action=cpiwm_report' ) ),
				),
				'secret_key' => get_option( CPIWM_SECRET_KEY ),
			)
		);

		wp_localize_script(
			'cpiwm_export',
			'cpiwm_export',
			array(
				'ajax'       => array(
					'url' => wp_make_link_relative( admin_url( 'admin-ajax.php?action=cpiwm_export' ) ),
				),
				'status'     => array(
					'url' => wp_make_link_relative( add_query_arg( array( 'secret_key' => get_option( CPIWM_SECRET_KEY ) ), admin_url( 'admin-ajax.php?action=cpiwm_status' ) ) ),
				),
				'secret_key' => get_option( CPIWM_SECRET_KEY ),
			)
		);

		wp_localize_script(
			'cpiwm_export',
			'cpiwm_locale',
			array(
				'stop_exporting_your_website'         => __( 'You are about to stop exporting your website, are you sure?', CPIWM_PLUGIN_NAME ),
				'preparing_to_export'                 => __( 'Preparing to export...', CPIWM_PLUGIN_NAME ),
				'unable_to_export'                    => __( 'Unable to export', CPIWM_PLUGIN_NAME ),
				'unable_to_start_the_export'          => __( 'Unable to start the export. Refresh the page and try again', CPIWM_PLUGIN_NAME ),
				'unable_to_run_the_export'            => __( 'Unable to run the export. Refresh the page and try again', CPIWM_PLUGIN_NAME ),
				'unable_to_stop_the_export'           => __( 'Unable to stop the export. Refresh the page and try again', CPIWM_PLUGIN_NAME ),
				'please_wait_stopping_the_export'     => __( 'Please wait, stopping the export...', CPIWM_PLUGIN_NAME ),
				'close_export'                        => __( 'Close', CPIWM_PLUGIN_NAME ),
				'stop_export'                         => __( 'Stop export', CPIWM_PLUGIN_NAME ),
				'leave_feedback'                      => __( 'Leave plugin developers any feedback here', CPIWM_PLUGIN_NAME ),
				'how_may_we_help_you'                 => __( 'How may we help you?', CPIWM_PLUGIN_NAME ),
				'thanks_for_submitting_your_feedback' => __( 'Thanks for submitting your feedback!', CPIWM_PLUGIN_NAME ),
				'thanks_for_submitting_your_request'  => __( 'Thanks for submitting your request!', CPIWM_PLUGIN_NAME ),
			)
		);
	}

	/**
	 * Enqueue scripts and styles for Import Controller
	 *
	 * @param  string $hook Hook suffix
	 * @return void
	 */
	public function enqueue_import_scripts_and_styles( $hook ) {
		if ( stripos( 'cpi-wp-migration_page_cpiwm_import', $hook ) === false ) {
			return;
		}

		// We don't want heartbeat to occur when importing
		wp_deregister_script( 'heartbeat' );

		// We don't want auth check for monitoring whether the user is still logged in
		remove_action( 'admin_enqueue_scripts', 'wp_auth_check_load' );

		if ( is_rtl() ) {
			wp_enqueue_style(
				'cpiwm_import',
				Cpiwm_Template::asset_link( 'css/import.min.rtl.css' )
			);
		} else {
			wp_enqueue_style(
				'cpiwm_import',
				Cpiwm_Template::asset_link( 'css/import.min.css' )
			);
		}

		wp_enqueue_script(
			'cpiwm_import',
			Cpiwm_Template::asset_link( 'javascript/import.min.js' ),
			array( 'cpiwm_util' )
		);

		wp_localize_script(
			'cpiwm_import',
			'cpiwm_feedback',
			array(
				'ajax'       => array(
					'url' => wp_make_link_relative( admin_url( 'admin-ajax.php?action=cpiwm_feedback' ) ),
				),
				'secret_key' => get_option( CPIWM_SECRET_KEY ),
			)
		);

		wp_localize_script(
			'cpiwm_import',
			'cpiwm_report',
			array(
				'ajax'       => array(
					'url' => wp_make_link_relative( admin_url( 'admin-ajax.php?action=cpiwm_report' ) ),
				),
				'secret_key' => get_option( CPIWM_SECRET_KEY ),
			)
		);

		wp_localize_script(
			'cpiwm_import',
			'cpiwm_uploader',
			array(
				'max_file_size' => CPIWM_MAX_FILE_IMPORT_SIZE > wp_max_upload_size() ? wp_max_upload_size() : CPIWM_MAX_FILE_IMPORT_SIZE,
				'url'           => wp_make_link_relative( admin_url( 'admin-ajax.php?action=cpiwm_import' ) ),
				'params'        => array(
					'priority'   => 5,
					'secret_key' => get_option( CPIWM_SECRET_KEY ),
				),
			)
		);

		wp_localize_script(
			'cpiwm_import',
			'cpiwm_import',
			array(
				'ajax'       => array(
					'url' => wp_make_link_relative( admin_url( 'admin-ajax.php?action=cpiwm_import' ) ),
				),
				'status'     => array(
					'url' => wp_make_link_relative( add_query_arg( array( 'secret_key' => get_option( CPIWM_SECRET_KEY ) ), admin_url( 'admin-ajax.php?action=cpiwm_status' ) ) ),
				),
				'secret_key' => get_option( CPIWM_SECRET_KEY ),
			)
		);

		wp_localize_script(
			'cpiwm_import',
			'cpiwm_compatibility',
			array(
				'messages' => Cpiwm_Compatibility::get( array() ),
			)
		);

		wp_localize_script(
			'cpiwm_import',
			'cpiwm_disk_space',
			array(
				'free'   => disk_free_space( CPIWM_STORAGE_PATH ),
				'factor' => CPIWM_DISK_SPACE_FACTOR,
				'extra'  => CPIWM_DISK_SPACE_EXTRA,
			)
		);

		wp_localize_script(
			'cpiwm_import',
			'cpiwm_locale',
			array(
				'stop_importing_your_website'         => __( 'You are about to stop importing your website, are you sure?', CPIWM_PLUGIN_NAME ),
				'preparing_to_import'                 => __( 'Preparing to import...', CPIWM_PLUGIN_NAME ),
				'unable_to_import'                    => __( 'Unable to import', CPIWM_PLUGIN_NAME ),
				'unable_to_start_the_import'          => __( 'Unable to start the import. Refresh the page and try again', CPIWM_PLUGIN_NAME ),
				'unable_to_confirm_the_import'        => __( 'Unable to confirm the import. Refresh the page and try again', CPIWM_PLUGIN_NAME ),
				'unable_to_prepare_blogs_on_import'   => __( 'Unable to prepare blogs on import. Refresh the page and try again', CPIWM_PLUGIN_NAME ),
				'unable_to_stop_the_import'           => __( 'Unable to stop the import. Refresh the page and try again', CPIWM_PLUGIN_NAME ),
				'please_wait_stopping_the_import'     => __( 'Please wait, stopping the import...', CPIWM_PLUGIN_NAME ),
				'close_import'                        => __( 'Close', CPIWM_PLUGIN_NAME ),
				'finish_import'                       => __( 'Finish', CPIWM_PLUGIN_NAME ),
				'stop_import'                         => __( 'Stop import', CPIWM_PLUGIN_NAME ),
				'confirm_import'                      => __( 'Proceed', CPIWM_PLUGIN_NAME ),
				'confirm_disk_space'                  => __( 'I have enough disk space', CPIWM_PLUGIN_NAME ),
				'continue_import'                     => __( 'Continue', CPIWM_PLUGIN_NAME ),
				'please_do_not_close_this_browser'    => __( 'Please do not close this browser window or your import will fail', CPIWM_PLUGIN_NAME ),
				'leave_feedback'                      => __( 'Leave plugin developers any feedback here', CPIWM_PLUGIN_NAME ),
				'how_may_we_help_you'                 => __( 'How may we help you?', CPIWM_PLUGIN_NAME ),
				'thanks_for_submitting_your_feedback' => __( 'Thanks for submitting your feedback!', CPIWM_PLUGIN_NAME ),
				'thanks_for_submitting_your_request'  => __( 'Thanks for submitting your request!', CPIWM_PLUGIN_NAME ),
                'import_from_file'                    => CPIWM_MAX_FILE_IMPORT_SIZE < wp_max_upload_size() ? sprintf(
                '<strong>%s</strong>以上のファイルはアップロードできません。',
                    esc_html( cpiwm_size_format( CPIWM_MAX_FILE_IMPORT_SIZE ) ) )
                    : sprintf(__(
                        '<strong>%s</strong>以上のファイルはアップロードできません。<br />%s',
                        CPIWM_PLUGIN_NAME
                    ),
                    esc_html( cpiwm_size_format( wp_max_upload_size() ) ) ,
                    __(
                        '<a href="https:/faq.cpi.ad.jp/faq/show/333?site_domain=default" target="_blank">How-to: Increase maximum upload file size</a> or ',
                        CPIWM_PLUGIN_NAME
                    )),
				'invalid_archive_extension'           => __(
					'The file type that you have tried to upload is not compatible with this plugin. ' .
					'Please ensure that your file is a <strong>.wpress</strong> file that was created with the CPI WP migration plugin. ' .
					'<a href="#" target="_blank">Technical details</a>',
					CPIWM_PLUGIN_NAME
				),
				'upgrade'                             => sprintf(
					__(
						'The file that you are trying to import is over the maximum upload file size limit of <strong>%s</strong>.<br />' .
						'You can remove this restriction by purchasing our ' .
						'<a href="#" target="_blank">Unlimited Extension</a>.',
						CPIWM_PLUGIN_NAME
					),
					'512MB'
				),
				'out_of_disk_space'                   => __(
					'There is not enough space available on the disk.<br />' .
					'Free up %s of disk space.',
					CPIWM_PLUGIN_NAME
				),
			)
		);
	}

	/**
	 * Enqueue scripts and styles for Backups Controller
	 *
	 * @param  string $hook Hook suffix
	 * @return void
	 */
	public function enqueue_backups_scripts_and_styles( $hook ) {
		if ( stripos( 'cpi-wp-migration_page_cpiwm_backups', $hook ) === false ) {
			return;
		}

		// We don't want heartbeat to occur when restoring
		wp_deregister_script( 'heartbeat' );

		// We don't want auth check for monitoring whether the user is still logged in
		remove_action( 'admin_enqueue_scripts', 'wp_auth_check_load' );

		if ( is_rtl() ) {
			wp_enqueue_style(
				'cpiwm_backups',
				Cpiwm_Template::asset_link( 'css/backups.min.rtl.css' )
			);
		} else {
			wp_enqueue_style(
				'cpiwm_backups',
				Cpiwm_Template::asset_link( 'css/backups.min.css' )
			);
		}

		wp_enqueue_script(
			'cpiwm_backups',
			Cpiwm_Template::asset_link( 'javascript/backups.min.js' ),
			array( 'cpiwm_util' )
		);

		wp_localize_script(
			'cpiwm_backups',
			'cpiwm_feedback',
			array(
				'ajax'       => array(
					'url' => wp_make_link_relative( admin_url( 'admin-ajax.php?action=cpiwm_feedback' ) ),
				),
				'secret_key' => get_option( CPIWM_SECRET_KEY ),
			)
		);

		wp_localize_script(
			'cpiwm_backups',
			'cpiwm_report',
			array(
				'ajax'       => array(
					'url' => wp_make_link_relative( admin_url( 'admin-ajax.php?action=cpiwm_report' ) ),
				),
				'secret_key' => get_option( CPIWM_SECRET_KEY ),
			)
		);

		wp_localize_script(
			'cpiwm_backups',
			'cpiwm_import',
			array(
				'ajax'       => array(
					'url' => wp_make_link_relative( admin_url( 'admin-ajax.php?action=cpiwm_import' ) ),
				),
				'status'     => array(
					'url' => wp_make_link_relative( add_query_arg( array( 'secret_key' => get_option( CPIWM_SECRET_KEY ) ), admin_url( 'admin-ajax.php?action=cpiwm_status' ) ) ),
				),
				'secret_key' => get_option( CPIWM_SECRET_KEY ),
			)
		);

		wp_localize_script(
			'cpiwm_backups',
			'cpiwm_export',
			array(
				'ajax'       => array(
					'url' => wp_make_link_relative( admin_url( 'admin-ajax.php?action=cpiwm_export' ) ),
				),
				'status'     => array(
					'url' => wp_make_link_relative( add_query_arg( array( 'secret_key' => get_option( CPIWM_SECRET_KEY ) ), admin_url( 'admin-ajax.php?action=cpiwm_status' ) ) ),
				),
				'secret_key' => get_option( CPIWM_SECRET_KEY ),
			)
		);

		wp_localize_script(
			'cpiwm_backups',
			'cpiwm_backups',
			array(
				'ajax'       => array(
					'url' => wp_make_link_relative( admin_url( 'admin-ajax.php?action=cpiwm_backups' ) ),
				),
				'backups'    => array(
					'url' => wp_make_link_relative( admin_url( 'admin-ajax.php?action=cpiwm_backup_list' ) ),
				),
				'labels'     => array(
					'url' => wp_make_link_relative( admin_url( 'admin-ajax.php?action=cpiwm_add_backup_label' ) ),
				),
				'secret_key' => get_option( CPIWM_SECRET_KEY ),
			)
		);

		wp_localize_script(
			'cpiwm_backups',
			'cpiwm_disk_space',
			array(
				'free'   => disk_free_space( CPIWM_STORAGE_PATH ),
				'factor' => CPIWM_DISK_SPACE_FACTOR,
				'extra'  => CPIWM_DISK_SPACE_EXTRA,
			)
		);

		wp_localize_script(
			'cpiwm_backups',
			'cpiwm_locale',
			array(
				'stop_exporting_your_website'         => __( 'You are about to stop exporting your website, are you sure?', CPIWM_PLUGIN_NAME ),
				'preparing_to_export'                 => __( 'Preparing to export...', CPIWM_PLUGIN_NAME ),
				'unable_to_export'                    => __( 'Unable to export', CPIWM_PLUGIN_NAME ),
				'unable_to_start_the_export'          => __( 'Unable to start the export. Refresh the page and try again', CPIWM_PLUGIN_NAME ),
				'unable_to_run_the_export'            => __( 'Unable to run the export. Refresh the page and try again', CPIWM_PLUGIN_NAME ),
				'unable_to_stop_the_export'           => __( 'Unable to stop the export. Refresh the page and try again', CPIWM_PLUGIN_NAME ),
				'please_wait_stopping_the_export'     => __( 'Please wait, stopping the export...', CPIWM_PLUGIN_NAME ),
				'close_export'                        => __( 'Close', CPIWM_PLUGIN_NAME ),
				'stop_export'                         => __( 'Stop export', CPIWM_PLUGIN_NAME ),
				'stop_importing_your_website'         => __( 'You are about to stop importing your website, are you sure?', CPIWM_PLUGIN_NAME ),
				'preparing_to_import'                 => __( 'Preparing to import...', CPIWM_PLUGIN_NAME ),
				'unable_to_import'                    => __( 'Unable to import', CPIWM_PLUGIN_NAME ),
				'unable_to_start_the_import'          => __( 'Unable to start the import. Refresh the page and try again', CPIWM_PLUGIN_NAME ),
				'unable_to_confirm_the_import'        => __( 'Unable to confirm the import. Refresh the page and try again', CPIWM_PLUGIN_NAME ),
				'unable_to_prepare_blogs_on_import'   => __( 'Unable to prepare blogs on import. Refresh the page and try again', CPIWM_PLUGIN_NAME ),
				'unable_to_stop_the_import'           => __( 'Unable to stop the import. Refresh the page and try again', CPIWM_PLUGIN_NAME ),
				'please_wait_stopping_the_import'     => __( 'Please wait, stopping the import...', CPIWM_PLUGIN_NAME ),
				'finish_import'                       => __( 'Finish', CPIWM_PLUGIN_NAME ),
				'close_import'                        => __( 'Close', CPIWM_PLUGIN_NAME ),
				'stop_import'                         => __( 'Stop import', CPIWM_PLUGIN_NAME ),
				'confirm_import'                      => __( 'Proceed', CPIWM_PLUGIN_NAME ),
				'confirm_disk_space'                  => __( 'I have enough disk space', CPIWM_PLUGIN_NAME ),
				'continue_import'                     => __( 'Continue', CPIWM_PLUGIN_NAME ),
				'please_do_not_close_this_browser'    => __( 'Please do not close this browser window or your import will fail', CPIWM_PLUGIN_NAME ),
				'leave_feedback'                      => __( 'Leave plugin developers any feedback here', CPIWM_PLUGIN_NAME ),
				'how_may_we_help_you'                 => __( 'How may we help you?', CPIWM_PLUGIN_NAME ),
				'thanks_for_submitting_your_feedback' => __( 'Thanks for submitting your feedback!', CPIWM_PLUGIN_NAME ),
				'thanks_for_submitting_your_request'  => __( 'Thanks for submitting your request!', CPIWM_PLUGIN_NAME ),
				'want_to_delete_this_file'            => __( 'Are you sure you want to delete this file?', CPIWM_PLUGIN_NAME ),
				'unlimited'                           => __( 'Restoring a backup is available via Unlimited extension. <a href="#" target="_blank">Get it here</a>', CPIWM_PLUGIN_NAME ),
				'restore_from_file'                   => __( '"Restore" functionality is available in a <a href="#" target="_blank">paid extension</a>.<br />You could also download the backup and then use "Import from file".', CPIWM_PLUGIN_NAME ),
				'out_of_disk_space'                   => __(
					'There is not enough space available on the disk.<br />' .
					'Free up %s of disk space.',
					CPIWM_PLUGIN_NAME
				),
			)
		);
	}

	/**
	 * Enqueue scripts and styles for Updater Controller
	 *
	 * @param  string $hook Hook suffix
	 * @return void
	 */
	public function enqueue_updater_scripts_and_styles( $hook ) {
		if ( 'plugins.php' !== strtolower( $hook ) ) {
			return;
		}

		if ( is_rtl() ) {
			wp_enqueue_style(
				'cpiwm_updater',
				Cpiwm_Template::asset_link( 'css/updater.min.rtl.css' )
			);
		} else {
			wp_enqueue_style(
				'cpiwm_updater',
				Cpiwm_Template::asset_link( 'css/updater.min.css' )
			);
		}

		wp_enqueue_script(
			'cpiwm_updater',
			Cpiwm_Template::asset_link( 'javascript/updater.min.js' ),
			array( 'cpiwm_util' )
		);

		wp_localize_script(
			'cpiwm_updater',
			'cpiwm_updater',
			array(
				'ajax' => array(
					'url' => wp_make_link_relative( add_query_arg( array( 'cpiwm_nonce' => wp_create_nonce( 'cpiwm_updater' ) ), admin_url( 'admin-ajax.php?action=cpiwm_updater' ) ) ),
				),
			)
		);

		wp_localize_script(
			'cpiwm_updater',
			'cpiwm_locale',
			array(
				'check_for_updates'   => __( 'Check for updates', CPIWM_PLUGIN_NAME ),
				'invalid_purchase_id' => __( 'Your purchase ID is invalid, please <a href="#">contact us</a>', CPIWM_PLUGIN_NAME ),
			)
		);
	}

	/**
	 * Outputs menu icon between head tags
	 *
	 * @return void
	 */
	public function admin_head() {
		global $wp_version;

		// Admin header
		Cpiwm_Template::render( 'main/admin-head', array( 'version' => $wp_version ) );
	}

	/**
	 * Register initial parameters
	 *
	 * @return void
	 */
	public function init() {

		// Set username
		if ( isset( $_SERVER['PHP_AUTH_USER'] ) ) {
			update_option( CPIWM_AUTH_USER, $_SERVER['PHP_AUTH_USER'] );
		} elseif ( isset( $_SERVER['REMOTE_USER'] ) ) {
			update_option( CPIWM_AUTH_USER, $_SERVER['REMOTE_USER'] );
		}

		// Set password
		if ( isset( $_SERVER['PHP_AUTH_PW'] ) ) {
			update_option( CPIWM_AUTH_PASSWORD, $_SERVER['PHP_AUTH_PW'] );
		}

		// Check for updates
		if ( isset( $_GET['cpiwm_check_for_updates'] ) ) {
			if ( check_admin_referer( 'cpiwm_check_for_updates', 'cpiwm_nonce' ) ) {
				if ( current_user_can( 'update_plugins' ) ) {
					Cpiwm_Updater::check_for_updates();
				}
			}
		}
	}

	/**
	 * Register initial router
	 *
	 * @return void
	 */
	public function router() {
		// Public actions
		add_action( 'wp_ajax_nopriv_cpiwm_export', 'Cpiwm_Export_Controller::export' );
		add_action( 'wp_ajax_nopriv_cpiwm_import', 'Cpiwm_Import_Controller::import' );
		add_action( 'wp_ajax_nopriv_cpiwm_status', 'Cpiwm_Status_Controller::status' );
		add_action( 'wp_ajax_nopriv_cpiwm_backups', 'Cpiwm_Backups_Controller::delete' );
		add_action( 'wp_ajax_nopriv_cpiwm_feedback', 'Cpiwm_Feedback_Controller::feedback' );
		add_action( 'wp_ajax_nopriv_cpiwm_report', 'Cpiwm_Report_Controller::report' );
		add_action( 'wp_ajax_nopriv_cpiwm_add_backup_label', 'Cpiwm_Backups_Controller::add_label' );
		add_action( 'wp_ajax_nopriv_cpiwm_backup_list', 'Cpiwm_Backups_Controller::backup_list' );

		// Private actions
		add_action( 'wp_ajax_cpiwm_export', 'Cpiwm_Export_Controller::export' );
		add_action( 'wp_ajax_cpiwm_import', 'Cpiwm_Import_Controller::import' );
		add_action( 'wp_ajax_cpiwm_status', 'Cpiwm_Status_Controller::status' );
		add_action( 'wp_ajax_cpiwm_backups', 'Cpiwm_Backups_Controller::delete' );
		add_action( 'wp_ajax_cpiwm_feedback', 'Cpiwm_Feedback_Controller::feedback' );
		add_action( 'wp_ajax_cpiwm_report', 'Cpiwm_Report_Controller::report' );
		add_action( 'wp_ajax_cpiwm_add_backup_label', 'Cpiwm_Backups_Controller::add_label' );
		add_action( 'wp_ajax_cpiwm_backup_list', 'Cpiwm_Backups_Controller::backup_list' );

		// Update actions
		if ( current_user_can( 'update_plugins' ) ) {
			add_action( 'wp_ajax_cpiwm_updater', 'Cpiwm_Updater_Controller::updater' );
		}
	}

	/**
	 * Add custom cron schedules
	 *
	 * @param  array $schedules List of schedules
	 * @return array
	 */
	public function add_cron_schedules( $schedules ) {
		$schedules['weekly']  = array(
			'display'  => __( 'Weekly', CPIWM_PLUGIN_NAME ),
			'interval' => 60 * 60 * 24 * 7,
		);
		$schedules['monthly'] = array(
			'display'  => __( 'Monthly', CPIWM_PLUGIN_NAME ),
			'interval' => ( strtotime( '+1 month' ) - time() ),
		);

		return $schedules;
	}
}
