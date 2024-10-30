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

class Cpiwm_Import_Controller {

	public static function index() {
        if (get_bloginfo('version') < 5.1) {
            die('<h3 style="color:red;">' . __('Please upgrade WordPress to version 5.1 or higher', CPIWM_PLUGIN_NAME) . '</h3>');
        }
        array_map('unlink', glob(CPIWM_STORAGE_PATH . DIRECTORY_SEPARATOR . '*.wpress'));
		Cpiwm_Template::render( 'import/index' );
	}

	public static function import( $params = array() ) {
		cpiwm_setup_environment();

		// Set params
		if ( empty( $params ) ) {
			$params = stripslashes_deep( array_merge( $_GET, $_POST ) );
		}
		if (isset($params['index']) && $params['index'] == 0) {
			array_map('unlink', glob(CPIWM_STORAGE_PATH . DIRECTORY_SEPARATOR . '*.wpress'));
		}
		// Set priority
		if ( ! isset( $params['priority'] ) ) {
			$params['priority'] = 10;
		}

		// Set secret key
		$secret_key = null;
		if ( isset( $params['secret_key'] ) ) {
			$secret_key = trim( $params['secret_key'] );
		}

		// try {
		// 	// Ensure that unauthorized people cannot access import action
		// 	cpiwm_verify_secret_key( $secret_key );
		// } catch ( Cpiwm_Not_Valid_Secret_Key_Exception $e ) {
		// 	exit;
		// }
		if (isset($params['data'])) {
			file_put_contents(CPIWM_STORAGE_PATH . DIRECTORY_SEPARATOR . $params['filename'] ,  base64_decode($params['data']), FILE_APPEND | LOCK_EX);
		} else {
			//		// Loop over filters
			if ( ( $filters = cpiwm_get_filters( 'cpiwm_import' ) ) ) {
				while ( $hooks = current( $filters ) ) {
					if ( intval( $params['priority'] ) === key( $filters ) ) {
						foreach ( $hooks as $hook ) {
							try {

								// Run function hook
								$params = call_user_func_array( $hook['function'], array( $params ) );

								// Log request
								Cpiwm_Log::import( $params );

							} catch ( Cpiwm_Import_Retry_Exception $e ) {
								if ( defined( 'WP_CLI' ) ) {
									WP_CLI::error( sprintf( __( 'Unable to import. Error code: %s. %s', CPIWM_PLUGIN_NAME ), $e->getCode(), $e->getMessage() ) );
								} else {
									status_header( $e->getCode() );
									echo json_encode( array( 'errors' => array( array( 'code' => $e->getCode(), 'message' => $e->getMessage() ) ) ) );
								}
								exit;
							} catch ( Cpiwm_Database_Exception $e ) {
								if ( defined( 'WP_CLI' ) ) {
									WP_CLI::error( sprintf( __( 'Unable to import. Error code: %s. %s', CPIWM_PLUGIN_NAME ), $e->getCode(), $e->getMessage() ) );
								} else {
									status_header( $e->getCode() );
									echo json_encode( array( 'errors' => array( array( 'code' => $e->getCode(), 'message' => $e->getMessage() ) ) ) );
								}
								Cpiwm_Directory::delete( cpiwm_storage_path( $params ) );
								exit;
							} catch ( Exception $e ) {
								if ( defined( 'WP_CLI' ) ) {
									WP_CLI::error( sprintf( __( 'Unable to import: %s', CPIWM_PLUGIN_NAME ), $e->getMessage() ) );
								} else {
									Cpiwm_Status::error( __( 'Unable to import', CPIWM_PLUGIN_NAME ), $e->getMessage() );
									Cpiwm_Notification::error( __( 'Unable to import', CPIWM_PLUGIN_NAME ), $e->getMessage() );
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

                        // Ensure that file is not grater than file size limit
                        if (file_exists(CPIWM_STORAGE_PATH . DIRECTORY_SEPARATOR . $params['archive']) && filesize(CPIWM_STORAGE_PATH . DIRECTORY_SEPARATOR . $params['archive']) > CPIWM_MAX_FILE_IMPORT_SIZE) {
                            Cpiwm_Status::error( __( 'Unable to import', CPIWM_PLUGIN_NAME ), sprintf(
                                __(
                                    '<strong>%s</strong>以上のファイルはアップロードできません。<br />',
                                    CPIWM_PLUGIN_NAME
                                ),
                                esc_html( cpiwm_size_format( CPIWM_MAX_FILE_IMPORT_SIZE ))
                            ));
                            Cpiwm_Notification::error( __( 'Unable to import', CPIWM_PLUGIN_NAME ), sprintf(
                                __(
                                    '<strong>%s</strong>以上のファイルはアップロードできません。<br />',
                                    CPIWM_PLUGIN_NAME
                                ),
                                esc_html( cpiwm_size_format( CPIWM_MAX_FILE_IMPORT_SIZE ))
                            ));
                            Cpiwm_Directory::delete( cpiwm_storage_path( $params ) );
                            exit;
                        }

						// Do request
						if ( $completed === false || ( $next = next( $filters ) ) && ( $params['priority'] = key( $filters ) ) ) {
							if ( defined( 'WP_CLI' ) ) {
								if ( ! defined( 'DOING_CRON' ) ) {
									continue;
								}
							}

							if ( isset( $params['cpiwm_manual_import'] ) || isset( $params['cpiwm_manual_restore'] ) ) {
								if (file_exists(CPIWM_STORAGE_PATH . DIRECTORY_SEPARATOR . $params['archive'])) {
									rename(CPIWM_STORAGE_PATH . DIRECTORY_SEPARATOR . $params['archive'], CPIWM_STORAGE_PATH . DIRECTORY_SEPARATOR . $params['storage'] . DIRECTORY_SEPARATOR . $params['archive']);
								}
								echo json_encode( $params );
								exit;
							}

							wp_remote_post(
								apply_filters( 'cpiwm_http_import_url', admin_url( 'admin-ajax.php?action=cpiwm_import' ) ),
								array(
									'timeout'   => apply_filters( 'cpiwm_http_import_timeout', 10 ),
									'blocking'  => apply_filters( 'cpiwm_http_import_blocking', false ),
									'sslverify' => apply_filters( 'cpiwm_http_import_sslverify', false ),
									'headers'   => apply_filters( 'cpiwm_http_import_headers', array() ),
									'body'      => apply_filters( 'cpiwm_http_import_body', $params ),
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
	}

	public static function buttons() {
		$active_filters = array();
		$static_filters = array();

		// CPI WP Migration
		if ( defined( 'CPIWM_PLUGIN_NAME' ) ) {
			$active_filters[] = apply_filters( 'cpiwm_import_file', Cpiwm_Template::get_content( 'import/button-file' ) );
		} else {
			$static_filters[] = apply_filters( 'cpiwm_import_file', Cpiwm_Template::get_content( 'import/button-file' ) );
		}

		// Add URL Extension
		if ( defined( 'CPIWMLE_PLUGIN_NAME' ) ) {
			$active_filters[] = apply_filters( 'cpiwm_import_url', Cpiwm_Template::get_content( 'import/button-url' ) );
		} else {
			$static_filters[] = apply_filters( 'cpiwm_import_url', Cpiwm_Template::get_content( 'import/button-url' ) );
		}

		// Add FTP Extension
		if ( defined( 'CPIWMFE_PLUGIN_NAME' ) ) {
			$active_filters[] = apply_filters( 'cpiwm_import_ftp', Cpiwm_Template::get_content( 'import/button-ftp' ) );
		} else {
			$static_filters[] = apply_filters( 'cpiwm_import_ftp', Cpiwm_Template::get_content( 'import/button-ftp' ) );
		}

		// Add Dropbox Extension
		if ( defined( 'CPIWMDE_PLUGIN_NAME' ) ) {
			$active_filters[] = apply_filters( 'cpiwm_import_dropbox', Cpiwm_Template::get_content( 'import/button-dropbox' ) );
		} else {
			$static_filters[] = apply_filters( 'cpiwm_import_dropbox', Cpiwm_Template::get_content( 'import/button-dropbox' ) );
		}

		// Add Google Drive Extension
		if ( defined( 'CPIWMGE_PLUGIN_NAME' ) ) {
			$active_filters[] = apply_filters( 'cpiwm_import_gdrive', Cpiwm_Template::get_content( 'import/button-gdrive' ) );
		} else {
			$static_filters[] = apply_filters( 'cpiwm_import_gdrive', Cpiwm_Template::get_content( 'import/button-gdrive' ) );
		}

		// Add Amazon S3 Extension
		if ( defined( 'CPIWMSE_PLUGIN_NAME' ) ) {
			$active_filters[] = apply_filters( 'cpiwm_import_s3', Cpiwm_Template::get_content( 'import/button-s3' ) );
		} else {
			$static_filters[] = apply_filters( 'cpiwm_import_s3', Cpiwm_Template::get_content( 'import/button-s3' ) );
		}

		// Add Backblaze B2 Extension
		if ( defined( 'CPIWMAE_PLUGIN_NAME' ) ) {
			$active_filters[] = apply_filters( 'cpiwm_import_b2', Cpiwm_Template::get_content( 'import/button-b2' ) );
		} else {
			$static_filters[] = apply_filters( 'cpiwm_import_b2', Cpiwm_Template::get_content( 'import/button-b2' ) );
		}

		// Add OneDrive Extension
		if ( defined( 'CPIWMOE_PLUGIN_NAME' ) ) {
			$active_filters[] = apply_filters( 'cpiwm_import_onedrive', Cpiwm_Template::get_content( 'import/button-onedrive' ) );
		} else {
			$static_filters[] = apply_filters( 'cpiwm_import_onedrive', Cpiwm_Template::get_content( 'import/button-onedrive' ) );
		}

		// Add Box Extension
		if ( defined( 'CPIWMBE_PLUGIN_NAME' ) ) {
			$active_filters[] = apply_filters( 'cpiwm_import_box', Cpiwm_Template::get_content( 'import/button-box' ) );
		} else {
			$static_filters[] = apply_filters( 'cpiwm_import_box', Cpiwm_Template::get_content( 'import/button-box' ) );
		}

		// Add Mega Extension
		if ( defined( 'CPIWMEE_PLUGIN_NAME' ) ) {
			$active_filters[] = apply_filters( 'cpiwm_import_mega', Cpiwm_Template::get_content( 'import/button-mega' ) );
		} else {
			$static_filters[] = apply_filters( 'cpiwm_import_mega', Cpiwm_Template::get_content( 'import/button-mega' ) );
		}

		// Add DigitalOcean Spaces Extension
		if ( defined( 'CPIWMIE_PLUGIN_NAME' ) ) {
			$active_filters[] = apply_filters( 'cpiwm_import_digitalocean', Cpiwm_Template::get_content( 'import/button-digitalocean' ) );
		} else {
			$static_filters[] = apply_filters( 'cpiwm_import_digitalocean', Cpiwm_Template::get_content( 'import/button-digitalocean' ) );
		}

		// Add Google Cloud Storage Extension
		if ( defined( 'CPIWMCE_PLUGIN_NAME' ) ) {
			$active_filters[] = apply_filters( 'cpiwm_import_gcloud_storage', Cpiwm_Template::get_content( 'import/button-gcloud-storage' ) );
		} else {
			$static_filters[] = apply_filters( 'cpiwm_import_gcloud_storage', Cpiwm_Template::get_content( 'import/button-gcloud-storage' ) );
		}

		// Add Microsoft Azure Extension
		if ( defined( 'CPIWMZE_PLUGIN_NAME' ) ) {
			$active_filters[] = apply_filters( 'cpiwm_import_azure_storage', Cpiwm_Template::get_content( 'import/button-azure-storage' ) );
		} else {
			$static_filters[] = apply_filters( 'cpiwm_import_azure_storage', Cpiwm_Template::get_content( 'import/button-azure-storage' ) );
		}

		// Add Amazon Glacier Extension
		if ( defined( 'CPIWMRE_PLUGIN_NAME' ) ) {
			$active_filters[] = apply_filters( 'cpiwm_import_glacier', Cpiwm_Template::get_content( 'import/button-glacier' ) );
		} else {
			$static_filters[] = apply_filters( 'cpiwm_import_glacier', Cpiwm_Template::get_content( 'import/button-glacier' ) );
		}

		// Add pCloud Extension
		if ( defined( 'CPIWMPE_PLUGIN_NAME' ) ) {
			$active_filters[] = apply_filters( 'cpiwm_import_pcloud', Cpiwm_Template::get_content( 'import/button-pcloud' ) );
		} else {
			$static_filters[] = apply_filters( 'cpiwm_import_pcloud', Cpiwm_Template::get_content( 'import/button-pcloud' ) );
		}

		// Add WebDAV Extension
		if ( defined( 'CPIWMWE_PLUGIN_NAME' ) ) {
			$active_filters[] = apply_filters( 'cpiwm_import_webdav', Cpiwm_Template::get_content( 'import/button-webdav' ) );
		} else {
			$static_filters[] = apply_filters( 'cpiwm_import_webdav', Cpiwm_Template::get_content( 'import/button-webdav' ) );
		}

		// Add S3 Client Extension
		if ( defined( 'CPIWMNE_PLUGIN_NAME' ) ) {
			$active_filters[] = apply_filters( 'cpiwm_import_s3_client', Cpiwm_Template::get_content( 'import/button-s3-client' ) );
		} else {
			$static_filters[] = apply_filters( 'cpiwm_import_s3_client', Cpiwm_Template::get_content( 'import/button-s3-client' ) );
		}

		return array_merge( $active_filters, $static_filters );
	}

	public static function pro() {
		return Cpiwm_Template::get_content( 'import/pro' );
	}

	public static function http_import_headers( $headers = array() ) {
		if ( ( $user = get_option( CPIWM_AUTH_USER ) ) && ( $password = get_option( CPIWM_AUTH_PASSWORD ) ) ) {
			if ( ( $hash = base64_encode( sprintf( '%s:%s', $user, $password ) ) ) ) {
				$headers['Authorization'] = sprintf( 'Basic %s', $hash );
			}
		}

		return $headers;
	}

	public static function max_chunk_size() {
		return min(
			cpiwm_parse_size( ini_get( 'post_max_size' ), CPIWM_MAX_CHUNK_SIZE ),
			cpiwm_parse_size( ini_get( 'upload_max_filesize' ), CPIWM_MAX_CHUNK_SIZE ),
			cpiwm_parse_size( CPIWM_MAX_CHUNK_SIZE )
		);
	}
}
