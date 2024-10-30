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

class Cpiwm_Export_Controller {

	public static function index() {
        if (get_bloginfo('version') < 4.9) {
            die('<h3 style="color:red;">' . __('Please upgrade WordPress to version 4.9 or higher', CPIWM_PLUGIN_NAME) . '</h3>');
        }
		Cpiwm_Template::render( 'export/index' );
	}

	public static function export( $params = array() ) {
		cpiwm_setup_environment();

		// Set params
		if ( empty( $params ) ) {
			$params = stripslashes_deep( array_merge( $_GET, $_POST ) );
		}

		// Set priority
		if ( ! isset( $params['priority'] ) ) {
			$params['priority'] = 5;
		}

		// Set secret key
		$secret_key = null;
		if ( isset( $params['secret_key'] ) ) {
			$secret_key = trim( $params['secret_key'] );
		}

		try {
			// Ensure that unauthorized people cannot access export action
			cpiwm_verify_secret_key( $secret_key );
		} catch ( Cpiwm_Not_Valid_Secret_Key_Exception $e ) {
			exit;
		}

		// Loop over filters
		if ( ( $filters = cpiwm_get_filters( 'cpiwm_export' ) ) ) {
			while ( $hooks = current( $filters ) ) {
				if ( intval( $params['priority'] ) === key( $filters ) ) {
					foreach ( $hooks as $hook ) {
						try {

							// Run function hook
							$params = call_user_func_array( $hook['function'], array( $params ) );

							// Log request
							Cpiwm_Log::export( $params );

						} catch ( Exception $e ) {
							if ( defined( 'WP_CLI' ) ) {
								WP_CLI::error( sprintf( __( 'Unable to export: %s', CPIWM_PLUGIN_NAME ), $e->getMessage() ) );
							} else {
								Cpiwm_Status::error( __( 'Unable to export', CPIWM_PLUGIN_NAME ), $e->getMessage() );
								Cpiwm_Notification::error( __( 'Unable to export', CPIWM_PLUGIN_NAME ), $e->getMessage() );
							}
							Cpiwm_Directory::delete( cpiwm_storage_path( $params ) );
							exit;
						}
					}

					// Set completed
					$completed = true;
					if ( isset( $params['completed'] ) ) {
						$completed = (bool) $params['completed'];
					}

					// Do request
					if ( $completed === false || ( $next = next( $filters ) ) && ( $params['priority'] = key( $filters ) ) ) {
						if ( defined( 'WP_CLI' ) ) {
							if ( ! defined( 'DOING_CRON' ) ) {
								continue;
							}
						}

						if ( isset( $params['cpiwm_manual_export'] ) ) {
							echo json_encode( $params );
							exit;
						}

						wp_remote_post(
							apply_filters( 'cpiwm_http_export_url', admin_url( 'admin-ajax.php?action=cpiwm_export' ) ),
							array(
								'timeout'   => apply_filters( 'cpiwm_http_export_timeout', 10 ),
								'blocking'  => apply_filters( 'cpiwm_http_export_blocking', false ),
								'sslverify' => apply_filters( 'cpiwm_http_export_sslverify', false ),
								'headers'   => apply_filters( 'cpiwm_http_export_headers', array() ),
								'body'      => apply_filters( 'cpiwm_http_export_body', $params ),
							)
						);
						exit;
					}
				}

				next( $filters );
			}
		}

		return $params;
	}

	public static function buttons() {
		$active_filters = array();
		$static_filters = array();

		// CPI WP Migration
		if ( defined( 'CPIWM_PLUGIN_NAME' ) ) {
			$active_filters[] = apply_filters( 'cpiwm_export_file', Cpiwm_Template::get_content( 'export/button-file' ) );
		} else {
			$static_filters[] = apply_filters( 'cpiwm_export_file', Cpiwm_Template::get_content( 'export/button-file' ) );
		}

		// Add FTP Extension
		if ( defined( 'CPIWMFE_PLUGIN_NAME' ) ) {
			$active_filters[] = apply_filters( 'cpiwm_export_ftp', Cpiwm_Template::get_content( 'export/button-ftp' ) );
		} else {
			$static_filters[] = apply_filters( 'cpiwm_export_ftp', Cpiwm_Template::get_content( 'export/button-ftp' ) );
		}

		// Add Dropbox Extension
		if ( defined( 'CPIWMDE_PLUGIN_NAME' ) ) {
			$active_filters[] = apply_filters( 'cpiwm_export_dropbox', Cpiwm_Template::get_content( 'export/button-dropbox' ) );
		} else {
			$static_filters[] = apply_filters( 'cpiwm_export_dropbox', Cpiwm_Template::get_content( 'export/button-dropbox' ) );
		}

		// Add Google Drive Extension
		if ( defined( 'CPIWMGE_PLUGIN_NAME' ) ) {
			$active_filters[] = apply_filters( 'cpiwm_export_gdrive', Cpiwm_Template::get_content( 'export/button-gdrive' ) );
		} else {
			$static_filters[] = apply_filters( 'cpiwm_export_gdrive', Cpiwm_Template::get_content( 'export/button-gdrive' ) );
		}

		// Add Amazon S3 Extension
		if ( defined( 'CPIWMSE_PLUGIN_NAME' ) ) {
			$active_filters[] = apply_filters( 'cpiwm_export_s3', Cpiwm_Template::get_content( 'export/button-s3' ) );
		} else {
			$static_filters[] = apply_filters( 'cpiwm_export_s3', Cpiwm_Template::get_content( 'export/button-s3' ) );
		}

		// Add Backblaze B2 Extension
		if ( defined( 'CPIWMAE_PLUGIN_NAME' ) ) {
			$active_filters[] = apply_filters( 'cpiwm_export_b2', Cpiwm_Template::get_content( 'export/button-b2' ) );
		} else {
			$static_filters[] = apply_filters( 'cpiwm_export_b2', Cpiwm_Template::get_content( 'export/button-b2' ) );
		}

		// Add OneDrive Extension
		if ( defined( 'CPIWMOE_PLUGIN_NAME' ) ) {
			$active_filters[] = apply_filters( 'cpiwm_export_onedrive', Cpiwm_Template::get_content( 'export/button-onedrive' ) );
		} else {
			$static_filters[] = apply_filters( 'cpiwm_export_onedrive', Cpiwm_Template::get_content( 'export/button-onedrive' ) );
		}

		// Add Box Extension
		if ( defined( 'CPIWMBE_PLUGIN_NAME' ) ) {
			$active_filters[] = apply_filters( 'cpiwm_export_box', Cpiwm_Template::get_content( 'export/button-box' ) );
		} else {
			$static_filters[] = apply_filters( 'cpiwm_export_box', Cpiwm_Template::get_content( 'export/button-box' ) );
		}

		// Add Mega Extension
		if ( defined( 'CPIWMEE_PLUGIN_NAME' ) ) {
			$active_filters[] = apply_filters( 'cpiwm_export_mega', Cpiwm_Template::get_content( 'export/button-mega' ) );
		} else {
			$static_filters[] = apply_filters( 'cpiwm_export_mega', Cpiwm_Template::get_content( 'export/button-mega' ) );
		}

		// Add DigitalOcean Spaces Extension
		if ( defined( 'CPIWMIE_PLUGIN_NAME' ) ) {
			$active_filters[] = apply_filters( 'cpiwm_export_digitalocean', Cpiwm_Template::get_content( 'export/button-digitalocean' ) );
		} else {
			$static_filters[] = apply_filters( 'cpiwm_export_digitalocean', Cpiwm_Template::get_content( 'export/button-digitalocean' ) );
		}

		// Add Google Cloud Storage Extension
		if ( defined( 'CPIWMCE_PLUGIN_NAME' ) ) {
			$active_filters[] = apply_filters( 'cpiwm_export_gcloud_storage', Cpiwm_Template::get_content( 'export/button-gcloud-storage' ) );
		} else {
			$static_filters[] = apply_filters( 'cpiwm_export_gcloud_storage', Cpiwm_Template::get_content( 'export/button-gcloud-storage' ) );
		}

		// Add Microsoft Azure Extension
		if ( defined( 'CPIWMZE_PLUGIN_NAME' ) ) {
			$active_filters[] = apply_filters( 'cpiwm_export_azure_storage', Cpiwm_Template::get_content( 'export/button-azure-storage' ) );
		} else {
			$static_filters[] = apply_filters( 'cpiwm_export_azure_storage', Cpiwm_Template::get_content( 'export/button-azure-storage' ) );
		}

		// Add Amazon Glacier Extension
		if ( defined( 'CPIWMRE_PLUGIN_NAME' ) ) {
			$active_filters[] = apply_filters( 'cpiwm_export_glacier', Cpiwm_Template::get_content( 'export/button-glacier' ) );
		} else {
			$static_filters[] = apply_filters( 'cpiwm_export_glacier', Cpiwm_Template::get_content( 'export/button-glacier' ) );
		}

		// Add pCloud Extension
		if ( defined( 'CPIWMPE_PLUGIN_NAME' ) ) {
			$active_filters[] = apply_filters( 'cpiwm_export_pcloud', Cpiwm_Template::get_content( 'export/button-pcloud' ) );
		} else {
			$static_filters[] = apply_filters( 'cpiwm_export_pcloud', Cpiwm_Template::get_content( 'export/button-pcloud' ) );
		}

		// Add WebDAV Extension
		if ( defined( 'CPIWMWE_PLUGIN_NAME' ) ) {
			$active_filters[] = apply_filters( 'cpiwm_export_webdav', Cpiwm_Template::get_content( 'export/button-webdav' ) );
		} else {
			$static_filters[] = apply_filters( 'cpiwm_export_webdav', Cpiwm_Template::get_content( 'export/button-webdav' ) );
		}

		// Add S3 Client Extension
		if ( defined( 'CPIWMNE_PLUGIN_NAME' ) ) {
			$active_filters[] = apply_filters( 'cpiwm_export_s3_client', Cpiwm_Template::get_content( 'export/button-s3-client' ) );
		} else {
			$static_filters[] = apply_filters( 'cpiwm_export_s3_client', Cpiwm_Template::get_content( 'export/button-s3-client' ) );
		}

		return array_merge( $active_filters, $static_filters );
	}

	public static function http_export_headers( $headers = array() ) {
		if ( ( $user = get_option( CPIWM_AUTH_USER ) ) && ( $password = get_option( CPIWM_AUTH_PASSWORD ) ) ) {
			if ( ( $hash = base64_encode( sprintf( '%s:%s', $user, $password ) ) ) ) {
				$headers['Authorization'] = sprintf( 'Basic %s', $hash );
			}
		}

		return $headers;
	}

	public static function cleanup() {
		try {
			// Iterate over storage directory
			$iterator = new Cpiwm_Recursive_Directory_Iterator( CPIWM_STORAGE_PATH );

			// Exclude index.php
			$iterator = new Cpiwm_Recursive_Exclude_Filter( $iterator, array( 'index.php' ) );

			// Loop over folders and files
			foreach ( $iterator as $item ) {
				try {
					if ( $item->getMTime() < ( time() - CPIWM_MAX_STORAGE_CLEANUP ) ) {
						if ( $item->isDir() ) {
							Cpiwm_Directory::delete( $item->getPathname() );
						} else {
							Cpiwm_File::delete( $item->getPathname() );
						}
					}
				} catch ( Exception $e ) {
				}
			}
		} catch ( Exception $e ) {
		}
	}
}
