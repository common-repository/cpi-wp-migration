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

class Cpiwm_Import_Database {

	public static function execute( $params ) {
		global $wpdb;

		// Skip database import
		if ( ! is_file( cpiwm_database_path( $params ) ) ) {
			return $params;
		}

		// Set query offset
		if ( isset( $params['query_offset'] ) ) {
			$query_offset = (int) $params['query_offset'];
		} else {
			$query_offset = 0;
		}

		// Set total queries size
		if ( isset( $params['total_queries_size'] ) ) {
			$total_queries_size = (int) $params['total_queries_size'];
		} else {
			$total_queries_size = 1;
		}

		// Read blogs.json file
		$handle = cpiwm_open( cpiwm_blogs_path( $params ), 'r' );

		// Parse blogs.json file
		$blogs = cpiwm_read( $handle, filesize( cpiwm_blogs_path( $params ) ) );
		$blogs = json_decode( $blogs, true );

		// Close handle
		cpiwm_close( $handle );

		// Read package.json file
		$handle = cpiwm_open( cpiwm_package_path( $params ), 'r' );

		// Parse package.json file
		$config = cpiwm_read( $handle, filesize( cpiwm_package_path( $params ) ) );
		$config = json_decode( $config, true );

		// Close handle
		cpiwm_close( $handle );

		// What percent of queries have we processed?
		$progress = (int) ( ( $query_offset / $total_queries_size ) * 100 );

		// Set progress
		Cpiwm_Status::info( sprintf( __( 'Restoring database...<br />%d%% complete', CPIWM_PLUGIN_NAME ), $progress ) );

		$old_replace_values = $old_replace_raw_values = array();
		$new_replace_values = $new_replace_raw_values = array();

		// Get Blog URLs
		foreach ( $blogs as $blog ) {

			$home_urls = array();

			// Add Home URL
			if ( ! empty( $blog['Old']['HomeURL'] ) ) {
				$home_urls[] = $blog['Old']['HomeURL'];
			}

			// Add Internal Home URL
			if ( ! empty( $blog['Old']['InternalHomeURL'] ) ) {
				if ( parse_url( $blog['Old']['InternalHomeURL'], PHP_URL_SCHEME ) && parse_url( $blog['Old']['InternalHomeURL'], PHP_URL_HOST ) ) {
					$home_urls[] = $blog['Old']['InternalHomeURL'];
				}
			}

			// Get Home URL
			foreach ( $home_urls as $home_url ) {

				// Get blogs dir Upload Path
				if ( ! in_array( sprintf( "'%s'", trim( cpiwm_blogsdir_path( $blog['Old']['BlogID'] ), '/' ) ), $old_replace_raw_values ) ) {
					$old_replace_raw_values[] = sprintf( "'%s'", trim( cpiwm_blogsdir_path( $blog['Old']['BlogID'] ), '/' ) );
					$new_replace_raw_values[] = sprintf( "'%s'", get_option( 'upload_path' ) );
				}

				// Get sites dir Upload Path
				if ( ! in_array( sprintf( "'%s'", trim( cpiwm_uploads_path( $blog['Old']['BlogID'] ), '/' ) ), $old_replace_raw_values ) ) {
					$old_replace_raw_values[] = sprintf( "'%s'", trim( cpiwm_uploads_path( $blog['Old']['BlogID'] ), '/' ) );
					$new_replace_raw_values[] = sprintf( "'%s'", get_option( 'upload_path' ) );
				}

				// Handle old and new sites dir style
				if ( defined( 'UPLOADBLOGSDIR' ) ) {

					// Get plain Upload Path
					if ( ! in_array( cpiwm_blogsdir_path( $blog['Old']['BlogID'] ), $old_replace_values ) ) {
						$old_replace_values[] = cpiwm_blogsdir_path( $blog['Old']['BlogID'] );
						$new_replace_values[] = cpiwm_blogsdir_path( $blog['New']['BlogID'] );
					}

					// Get URL encoded Upload Path
					if ( ! in_array( urlencode( cpiwm_blogsdir_path( $blog['Old']['BlogID'] ) ), $old_replace_values ) ) {
						$old_replace_values[] = urlencode( cpiwm_blogsdir_path( $blog['Old']['BlogID'] ) );
						$new_replace_values[] = urlencode( cpiwm_blogsdir_path( $blog['New']['BlogID'] ) );
					}

					// Get URL raw encoded Upload Path
					if ( ! in_array( rawurlencode( cpiwm_blogsdir_path( $blog['Old']['BlogID'] ) ), $old_replace_values ) ) {
						$old_replace_values[] = rawurlencode( cpiwm_blogsdir_path( $blog['Old']['BlogID'] ) );
						$new_replace_values[] = rawurlencode( cpiwm_blogsdir_path( $blog['New']['BlogID'] ) );
					}

					// Get JSON escaped Upload Path
					if ( ! in_array( addcslashes( cpiwm_blogsdir_path( $blog['Old']['BlogID'] ), '/' ), $old_replace_values ) ) {
						$old_replace_values[] = addcslashes( cpiwm_blogsdir_path( $blog['Old']['BlogID'] ), '/' );
						$new_replace_values[] = addcslashes( cpiwm_blogsdir_path( $blog['New']['BlogID'] ), '/' );
					}

					// Get plain Upload Path
					if ( ! in_array( cpiwm_uploads_path( $blog['Old']['BlogID'] ), $old_replace_values ) ) {
						$old_replace_values[] = cpiwm_uploads_path( $blog['Old']['BlogID'] );
						$new_replace_values[] = cpiwm_blogsdir_path( $blog['New']['BlogID'] );
					}

					// Get URL encoded Upload Path
					if ( ! in_array( urlencode( cpiwm_uploads_path( $blog['Old']['BlogID'] ) ), $old_replace_values ) ) {
						$old_replace_values[] = urlencode( cpiwm_uploads_path( $blog['Old']['BlogID'] ) );
						$new_replace_values[] = urlencode( cpiwm_blogsdir_path( $blog['New']['BlogID'] ) );
					}

					// Get URL raw encoded Upload Path
					if ( ! in_array( rawurlencode( cpiwm_uploads_path( $blog['Old']['BlogID'] ) ), $old_replace_values ) ) {
						$old_replace_values[] = rawurlencode( cpiwm_uploads_path( $blog['Old']['BlogID'] ) );
						$new_replace_values[] = rawurlencode( cpiwm_blogsdir_path( $blog['New']['BlogID'] ) );
					}

					// Get JSON escaped Upload Path
					if ( ! in_array( addcslashes( cpiwm_uploads_path( $blog['Old']['BlogID'] ), '/' ), $old_replace_values ) ) {
						$old_replace_values[] = addcslashes( cpiwm_uploads_path( $blog['Old']['BlogID'] ), '/' );
						$new_replace_values[] = addcslashes( cpiwm_blogsdir_path( $blog['New']['BlogID'] ), '/' );
					}
				} else {

					// Get files dir Upload URL
					if ( ! in_array( sprintf( '%s/%s/', untrailingslashit( $home_url ), 'files' ), $old_replace_values ) ) {
						$old_replace_values[] = sprintf( '%s/%s/', untrailingslashit( $home_url ), 'files' );
						$new_replace_values[] = cpiwm_uploads_url( $blog['New']['BlogID'] );
					}

					// Get plain Upload Path
					if ( ! in_array( cpiwm_blogsdir_path( $blog['Old']['BlogID'] ), $old_replace_values ) ) {
						$old_replace_values[] = cpiwm_blogsdir_path( $blog['Old']['BlogID'] );
						$new_replace_values[] = cpiwm_uploads_path( $blog['New']['BlogID'] );
					}

					// Get URL encoded Upload Path
					if ( ! in_array( urlencode( cpiwm_blogsdir_path( $blog['Old']['BlogID'] ) ), $old_replace_values ) ) {
						$old_replace_values[] = urlencode( cpiwm_blogsdir_path( $blog['Old']['BlogID'] ) );
						$new_replace_values[] = urlencode( cpiwm_uploads_path( $blog['New']['BlogID'] ) );
					}

					// Get URL raw encoded Upload Path
					if ( ! in_array( rawurlencode( cpiwm_blogsdir_path( $blog['Old']['BlogID'] ) ), $old_replace_values ) ) {
						$old_replace_values[] = rawurlencode( cpiwm_blogsdir_path( $blog['Old']['BlogID'] ) );
						$new_replace_values[] = rawurlencode( cpiwm_uploads_path( $blog['New']['BlogID'] ) );
					}

					// Get JSON escaped Upload Path
					if ( ! in_array( addcslashes( cpiwm_blogsdir_path( $blog['Old']['BlogID'] ), '/' ), $old_replace_values ) ) {
						$old_replace_values[] = addcslashes( cpiwm_blogsdir_path( $blog['Old']['BlogID'] ), '/' );
						$new_replace_values[] = addcslashes( cpiwm_uploads_path( $blog['New']['BlogID'] ), '/' );
					}

					// Get plain Upload Path
					if ( ! in_array( cpiwm_uploads_path( $blog['Old']['BlogID'] ), $old_replace_values ) ) {
						$old_replace_values[] = cpiwm_uploads_path( $blog['Old']['BlogID'] );
						$new_replace_values[] = cpiwm_uploads_path( $blog['New']['BlogID'] );
					}

					// Get URL encoded Upload Path
					if ( ! in_array( urlencode( cpiwm_uploads_path( $blog['Old']['BlogID'] ) ), $old_replace_values ) ) {
						$old_replace_values[] = urlencode( cpiwm_uploads_path( $blog['Old']['BlogID'] ) );
						$new_replace_values[] = urlencode( cpiwm_uploads_path( $blog['New']['BlogID'] ) );
					}

					// Get URL raw encoded Upload Path
					if ( ! in_array( rawurlencode( cpiwm_uploads_path( $blog['Old']['BlogID'] ) ), $old_replace_values ) ) {
						$old_replace_values[] = rawurlencode( cpiwm_uploads_path( $blog['Old']['BlogID'] ) );
						$new_replace_values[] = rawurlencode( cpiwm_uploads_path( $blog['New']['BlogID'] ) );
					}

					// Get JSON escaped Upload Path
					if ( ! in_array( addcslashes( cpiwm_uploads_path( $blog['Old']['BlogID'] ), '/' ), $old_replace_values ) ) {
						$old_replace_values[] = addcslashes( cpiwm_uploads_path( $blog['Old']['BlogID'] ), '/' );
						$new_replace_values[] = addcslashes( cpiwm_uploads_path( $blog['New']['BlogID'] ), '/' );
					}
				}
			}

			$site_urls = array();

			// Add Site URL
			if ( ! empty( $blog['Old']['SiteURL'] ) ) {
				$site_urls[] = $blog['Old']['SiteURL'];
			}

			// Add Internal Site URL
			if ( ! empty( $blog['Old']['InternalSiteURL'] ) ) {
				if ( parse_url( $blog['Old']['InternalSiteURL'], PHP_URL_SCHEME ) && parse_url( $blog['Old']['InternalSiteURL'], PHP_URL_HOST ) ) {
					$site_urls[] = $blog['Old']['InternalSiteURL'];
				}
			}

			// Get Site URL
			foreach ( $site_urls as $site_url ) {

				// Get www URL
				if ( stripos( $site_url, '//www.' ) !== false ) {
					$site_url_www_inversion = str_ireplace( '//www.', '//', $site_url );
				} else {
					$site_url_www_inversion = str_ireplace( '//', '//www.', $site_url );
				}

				// Replace Site URL
				foreach ( array( $site_url, $site_url_www_inversion ) as $url ) {

					// Get domain
					$old_domain = parse_url( $url, PHP_URL_HOST );
					$new_domain = parse_url( $blog['New']['SiteURL'], PHP_URL_HOST );

					// Get path
					$old_path = parse_url( $url, PHP_URL_PATH );
					$new_path = parse_url( $blog['New']['SiteURL'], PHP_URL_PATH );

					// Get scheme
					$new_scheme = parse_url( $blog['New']['SiteURL'], PHP_URL_SCHEME );

					// Add domain and path
					if ( ! in_array( sprintf( "'%s','%s'", $old_domain, trailingslashit( $old_path ) ), $old_replace_raw_values ) ) {
						$old_replace_raw_values[] = sprintf( "'%s','%s'", $old_domain, trailingslashit( $old_path ) );
						$new_replace_raw_values[] = sprintf( "'%s','%s'", $new_domain, trailingslashit( $new_path ) );
					}

					// Add domain and path with single quote
					if ( ! in_array( sprintf( "='%s%s", $old_domain, untrailingslashit( $old_path ) ), $old_replace_values ) ) {
						$old_replace_values[] = sprintf( "='%s%s", $old_domain, untrailingslashit( $old_path ) );
						$new_replace_values[] = sprintf( "='%s%s", $new_domain, untrailingslashit( $new_path ) );
					}

					// Add domain and path with double quote
					if ( ! in_array( sprintf( '="%s%s', $old_domain, untrailingslashit( $old_path ) ), $old_replace_values ) ) {
						$old_replace_values[] = sprintf( '="%s%s', $old_domain, untrailingslashit( $old_path ) );
						$new_replace_values[] = sprintf( '="%s%s', $new_domain, untrailingslashit( $new_path ) );
					}

					// Add Site URL scheme
					$old_schemes = array( 'http', 'https', '' );
					$new_schemes = array( $new_scheme, $new_scheme, '' );

					// Replace Site URL scheme
					for ( $i = 0; $i < count( $old_schemes ); $i++ ) {

						// Add plain Site URL
						if ( ! in_array( cpiwm_url_scheme( $url, $old_schemes[ $i ] ), $old_replace_values ) ) {
							$old_replace_values[] = cpiwm_url_scheme( $url, $old_schemes[ $i ] );
							$new_replace_values[] = cpiwm_url_scheme( $blog['New']['SiteURL'], $new_schemes[ $i ] );
						}

						// Add URL encoded Site URL
						if ( ! in_array( urlencode( cpiwm_url_scheme( $url, $old_schemes[ $i ] ) ), $old_replace_values ) ) {
							$old_replace_values[] = urlencode( cpiwm_url_scheme( $url, $old_schemes[ $i ] ) );
							$new_replace_values[] = urlencode( cpiwm_url_scheme( $blog['New']['SiteURL'], $new_schemes[ $i ] ) );
						}

						// Add URL raw encoded Site URL
						if ( ! in_array( rawurlencode( cpiwm_url_scheme( $url, $old_schemes[ $i ] ) ), $old_replace_values ) ) {
							$old_replace_values[] = rawurlencode( cpiwm_url_scheme( $url, $old_schemes[ $i ] ) );
							$new_replace_values[] = rawurlencode( cpiwm_url_scheme( $blog['New']['SiteURL'], $new_schemes[ $i ] ) );
						}

						// Add JSON escaped Site URL
						if ( ! in_array( addcslashes( cpiwm_url_scheme( $url, $old_schemes[ $i ] ), '/' ), $old_replace_values ) ) {
							$old_replace_values[] = addcslashes( cpiwm_url_scheme( $url, $old_schemes[ $i ] ), '/' );
							$new_replace_values[] = addcslashes( cpiwm_url_scheme( $blog['New']['SiteURL'], $new_schemes[ $i ] ), '/' );
						}
					}

					// Add email
					if ( ! isset( $config['NoEmailReplace'] ) ) {
						if ( ! in_array( sprintf( '@%s', $old_domain ), $old_replace_values ) ) {
							$old_replace_values[] = sprintf( '@%s', $old_domain );
							$new_replace_values[] = str_ireplace( '@www.', '@', sprintf( '@%s', $new_domain ) );
						}
					}
				}
			}

			$home_urls = array();

			// Add Home URL
			if ( ! empty( $blog['Old']['HomeURL'] ) ) {
				$home_urls[] = $blog['Old']['HomeURL'];
			}

			// Add Internal Home URL
			if ( ! empty( $blog['Old']['InternalHomeURL'] ) ) {
				if ( parse_url( $blog['Old']['InternalHomeURL'], PHP_URL_SCHEME ) && parse_url( $blog['Old']['InternalHomeURL'], PHP_URL_HOST ) ) {
					$home_urls[] = $blog['Old']['InternalHomeURL'];
				}
			}

			// Get Home URL
			foreach ( $home_urls as $home_url ) {

				// Get www URL
				if ( stripos( $home_url, '//www.' ) !== false ) {
					$home_url_www_inversion = str_ireplace( '//www.', '//', $home_url );
				} else {
					$home_url_www_inversion = str_ireplace( '//', '//www.', $home_url );
				}

				// Replace Home URL
				foreach ( array( $home_url, $home_url_www_inversion ) as $url ) {

					// Get domain
					$old_domain = parse_url( $url, PHP_URL_HOST );
					$new_domain = parse_url( $blog['New']['HomeURL'], PHP_URL_HOST );

					// Get path
					$old_path = parse_url( $url, PHP_URL_PATH );
					$new_path = parse_url( $blog['New']['HomeURL'], PHP_URL_PATH );

					// Get scheme
					$new_scheme = parse_url( $blog['New']['HomeURL'], PHP_URL_SCHEME );

					// Add domain and path
					if ( ! in_array( sprintf( "'%s','%s'", $old_domain, trailingslashit( $old_path ) ), $old_replace_raw_values ) ) {
						$old_replace_raw_values[] = sprintf( "'%s','%s'", $old_domain, trailingslashit( $old_path ) );
						$new_replace_raw_values[] = sprintf( "'%s','%s'", $new_domain, trailingslashit( $new_path ) );
					}

					// Add domain and path with single quote
					if ( ! in_array( sprintf( "='%s%s", $old_domain, untrailingslashit( $old_path ) ), $old_replace_values ) ) {
						$old_replace_values[] = sprintf( "='%s%s", $old_domain, untrailingslashit( $old_path ) );
						$new_replace_values[] = sprintf( "='%s%s", $new_domain, untrailingslashit( $new_path ) );
					}

					// Add domain and path with double quote
					if ( ! in_array( sprintf( '="%s%s', $old_domain, untrailingslashit( $old_path ) ), $old_replace_values ) ) {
						$old_replace_values[] = sprintf( '="%s%s', $old_domain, untrailingslashit( $old_path ) );
						$new_replace_values[] = sprintf( '="%s%s', $new_domain, untrailingslashit( $new_path ) );
					}

					// Set Home URL scheme
					$old_schemes = array( 'http', 'https', '' );
					$new_schemes = array( $new_scheme, $new_scheme, '' );

					// Replace Home URL scheme
					for ( $i = 0; $i < count( $old_schemes ); $i++ ) {

						// Add plain Home URL
						if ( ! in_array( cpiwm_url_scheme( $url, $old_schemes[ $i ] ), $old_replace_values ) ) {
							$old_replace_values[] = cpiwm_url_scheme( $url, $old_schemes[ $i ] );
							$new_replace_values[] = cpiwm_url_scheme( $blog['New']['HomeURL'], $new_schemes[ $i ] );
						}

						// Add URL encoded Home URL
						if ( ! in_array( urlencode( cpiwm_url_scheme( $url, $old_schemes[ $i ] ) ), $old_replace_values ) ) {
							$old_replace_values[] = urlencode( cpiwm_url_scheme( $url, $old_schemes[ $i ] ) );
							$new_replace_values[] = urlencode( cpiwm_url_scheme( $blog['New']['HomeURL'], $new_schemes[ $i ] ) );
						}

						// Add URL raw encoded Home URL
						if ( ! in_array( rawurlencode( cpiwm_url_scheme( $url, $old_schemes[ $i ] ) ), $old_replace_values ) ) {
							$old_replace_values[] = rawurlencode( cpiwm_url_scheme( $url, $old_schemes[ $i ] ) );
							$new_replace_values[] = rawurlencode( cpiwm_url_scheme( $blog['New']['HomeURL'], $new_schemes[ $i ] ) );
						}

						// Add JSON escaped Home URL
						if ( ! in_array( addcslashes( cpiwm_url_scheme( $url, $old_schemes[ $i ] ), '/' ), $old_replace_values ) ) {
							$old_replace_values[] = addcslashes( cpiwm_url_scheme( $url, $old_schemes[ $i ] ), '/' );
							$new_replace_values[] = addcslashes( cpiwm_url_scheme( $blog['New']['HomeURL'], $new_schemes[ $i ] ), '/' );
						}
					}

					// Add email
					if ( ! isset( $config['NoEmailReplace'] ) ) {
						if ( ! in_array( sprintf( '@%s', $old_domain ), $old_replace_values ) ) {
							$old_replace_values[] = sprintf( '@%s', $old_domain );
							$new_replace_values[] = str_ireplace( '@www.', '@', sprintf( '@%s', $new_domain ) );
						}
					}
				}
			}
		}

		$site_urls = array();

		// Add Site URL
		if ( ! empty( $config['SiteURL'] ) ) {
			$site_urls[] = $config['SiteURL'];
		}

		// Add Internal Site URL
		if ( ! empty( $config['InternalSiteURL'] ) ) {
			if ( parse_url( $config['InternalSiteURL'], PHP_URL_SCHEME ) && parse_url( $config['InternalSiteURL'], PHP_URL_HOST ) ) {
				$site_urls[] = $config['InternalSiteURL'];
			}
		}

		// Get Site URL
		foreach ( $site_urls as $site_url ) {

			// Get www URL
			if ( stripos( $site_url, '//www.' ) !== false ) {
				$site_url_www_inversion = str_ireplace( '//www.', '//', $site_url );
			} else {
				$site_url_www_inversion = str_ireplace( '//', '//www.', $site_url );
			}

			// Replace Site URL
			foreach ( array( $site_url, $site_url_www_inversion ) as $url ) {

				// Get domain
				$old_domain = parse_url( $url, PHP_URL_HOST );
				$new_domain = parse_url( site_url(), PHP_URL_HOST );

				// Get path
				$old_path = parse_url( $url, PHP_URL_PATH );
				$new_path = parse_url( site_url(), PHP_URL_PATH );

				// Get scheme
				$new_scheme = parse_url( site_url(), PHP_URL_SCHEME );

				// Add domain and path
				if ( ! in_array( sprintf( "'%s','%s'", $old_domain, trailingslashit( $old_path ) ), $old_replace_raw_values ) ) {
					$old_replace_raw_values[] = sprintf( "'%s','%s'", $old_domain, trailingslashit( $old_path ) );
					$new_replace_raw_values[] = sprintf( "'%s','%s'", $new_domain, trailingslashit( $new_path ) );
				}

				// Add domain and path with single quote
				if ( ! in_array( sprintf( "='%s%s", $old_domain, untrailingslashit( $old_path ) ), $old_replace_values ) ) {
					$old_replace_values[] = sprintf( "='%s%s", $old_domain, untrailingslashit( $old_path ) );
					$new_replace_values[] = sprintf( "='%s%s", $new_domain, untrailingslashit( $new_path ) );
				}

				// Add domain and path with double quote
				if ( ! in_array( sprintf( '="%s%s', $old_domain, untrailingslashit( $old_path ) ), $old_replace_values ) ) {
					$old_replace_values[] = sprintf( '="%s%s', $old_domain, untrailingslashit( $old_path ) );
					$new_replace_values[] = sprintf( '="%s%s', $new_domain, untrailingslashit( $new_path ) );
				}

				// Set Site URL scheme
				$old_schemes = array( 'http', 'https', '' );
				$new_schemes = array( $new_scheme, $new_scheme, '' );

				// Replace Site URL scheme
				for ( $i = 0; $i < count( $old_schemes ); $i++ ) {

					// Add plain Site URL
					if ( ! in_array( cpiwm_url_scheme( $url, $old_schemes[ $i ] ), $old_replace_values ) ) {
						$old_replace_values[] = cpiwm_url_scheme( $url, $old_schemes[ $i ] );
						$new_replace_values[] = cpiwm_url_scheme( site_url(), $new_schemes[ $i ] );
					}

					// Add URL encoded Site URL
					if ( ! in_array( urlencode( cpiwm_url_scheme( $url, $old_schemes[ $i ] ) ), $old_replace_values ) ) {
						$old_replace_values[] = urlencode( cpiwm_url_scheme( $url, $old_schemes[ $i ] ) );
						$new_replace_values[] = urlencode( cpiwm_url_scheme( site_url(), $new_schemes[ $i ] ) );
					}

					// Add URL raw encoded Site URL
					if ( ! in_array( rawurlencode( cpiwm_url_scheme( $url, $old_schemes[ $i ] ) ), $old_replace_values ) ) {
						$old_replace_values[] = rawurlencode( cpiwm_url_scheme( $url, $old_schemes[ $i ] ) );
						$new_replace_values[] = rawurlencode( cpiwm_url_scheme( site_url(), $new_schemes[ $i ] ) );
					}

					// Add JSON escaped Site URL
					if ( ! in_array( addcslashes( cpiwm_url_scheme( $url, $old_schemes[ $i ] ), '/' ), $old_replace_values ) ) {
						$old_replace_values[] = addcslashes( cpiwm_url_scheme( $url, $old_schemes[ $i ] ), '/' );
						$new_replace_values[] = addcslashes( cpiwm_url_scheme( site_url(), $new_schemes[ $i ] ), '/' );
					}
				}

				// Add email
				if ( ! isset( $config['NoEmailReplace'] ) ) {
					if ( ! in_array( sprintf( '@%s', $old_domain ), $old_replace_values ) ) {
						$old_replace_values[] = sprintf( '@%s', $old_domain );
						$new_replace_values[] = str_ireplace( '@www.', '@', sprintf( '@%s', $new_domain ) );
					}
				}
			}
		}

		$home_urls = array();

		// Add Home URL
		if ( ! empty( $config['HomeURL'] ) ) {
			$home_urls[] = $config['HomeURL'];
		}

		// Add Internal Home URL
		if ( ! empty( $config['InternalHomeURL'] ) ) {
			if ( parse_url( $config['InternalHomeURL'], PHP_URL_SCHEME ) && parse_url( $config['InternalHomeURL'], PHP_URL_HOST ) ) {
				$home_urls[] = $config['InternalHomeURL'];
			}
		}

		// Get Home URL
		foreach ( $home_urls as $home_url ) {

			// Get www URL
			if ( stripos( $home_url, '//www.' ) !== false ) {
				$home_url_www_inversion = str_ireplace( '//www.', '//', $home_url );
			} else {
				$home_url_www_inversion = str_ireplace( '//', '//www.', $home_url );
			}

			// Replace Home URL
			foreach ( array( $home_url, $home_url_www_inversion ) as $url ) {

				// Get domain
				$old_domain = parse_url( $url, PHP_URL_HOST );
				$new_domain = parse_url( home_url(), PHP_URL_HOST );

				// Get path
				$old_path = parse_url( $url, PHP_URL_PATH );
				$new_path = parse_url( home_url(), PHP_URL_PATH );

				// Get scheme
				$new_scheme = parse_url( home_url(), PHP_URL_SCHEME );

				// Add domain and path
				if ( ! in_array( sprintf( "'%s','%s'", $old_domain, trailingslashit( $old_path ) ), $old_replace_raw_values ) ) {
					$old_replace_raw_values[] = sprintf( "'%s','%s'", $old_domain, trailingslashit( $old_path ) );
					$new_replace_raw_values[] = sprintf( "'%s','%s'", $new_domain, trailingslashit( $new_path ) );
				}

				// Add domain and path with single quote
				if ( ! in_array( sprintf( "='%s%s", $old_domain, untrailingslashit( $old_path ) ), $old_replace_values ) ) {
					$old_replace_values[] = sprintf( "='%s%s", $old_domain, untrailingslashit( $old_path ) );
					$new_replace_values[] = sprintf( "='%s%s", $new_domain, untrailingslashit( $new_path ) );
				}

				// Add domain and path with double quote
				if ( ! in_array( sprintf( '="%s%s', $old_domain, untrailingslashit( $old_path ) ), $old_replace_values ) ) {
					$old_replace_values[] = sprintf( '="%s%s', $old_domain, untrailingslashit( $old_path ) );
					$new_replace_values[] = sprintf( '="%s%s', $new_domain, untrailingslashit( $new_path ) );
				}

				// Add Home URL scheme
				$old_schemes = array( 'http', 'https', '' );
				$new_schemes = array( $new_scheme, $new_scheme, '' );

				// Replace Home URL scheme
				for ( $i = 0; $i < count( $old_schemes ); $i++ ) {

					// Add plain Home URL
					if ( ! in_array( cpiwm_url_scheme( $url, $old_schemes[ $i ] ), $old_replace_values ) ) {
						$old_replace_values[] = cpiwm_url_scheme( $url, $old_schemes[ $i ] );
						$new_replace_values[] = cpiwm_url_scheme( home_url(), $new_schemes[ $i ] );
					}

					// Add URL encoded Home URL
					if ( ! in_array( urlencode( cpiwm_url_scheme( $url, $old_schemes[ $i ] ) ), $old_replace_values ) ) {
						$old_replace_values[] = urlencode( cpiwm_url_scheme( $url, $old_schemes[ $i ] ) );
						$new_replace_values[] = urlencode( cpiwm_url_scheme( home_url(), $new_schemes[ $i ] ) );
					}

					// Add URL raw encoded Home URL
					if ( ! in_array( rawurlencode( cpiwm_url_scheme( $url, $old_schemes[ $i ] ) ), $old_replace_values ) ) {
						$old_replace_values[] = rawurlencode( cpiwm_url_scheme( $url, $old_schemes[ $i ] ) );
						$new_replace_values[] = rawurlencode( cpiwm_url_scheme( home_url(), $new_schemes[ $i ] ) );
					}

					// Add JSON escaped Home URL
					if ( ! in_array( addcslashes( cpiwm_url_scheme( $url, $old_schemes[ $i ] ), '/' ), $old_replace_values ) ) {
						$old_replace_values[] = addcslashes( cpiwm_url_scheme( $url, $old_schemes[ $i ] ), '/' );
						$new_replace_values[] = addcslashes( cpiwm_url_scheme( home_url(), $new_schemes[ $i ] ), '/' );
					}
				}

				// Add email
				if ( ! isset( $config['NoEmailReplace'] ) ) {
					if ( ! in_array( sprintf( '@%s', $old_domain ), $old_replace_values ) ) {
						$old_replace_values[] = sprintf( '@%s', $old_domain );
						$new_replace_values[] = str_ireplace( '@www.', '@', sprintf( '@%s', $new_domain ) );
					}
				}
			}
		}

		// Get WordPress Content Dir
		if ( isset( $config['WordPress']['Content'] ) && ( $content_dir = $config['WordPress']['Content'] ) ) {

			// Add plain WordPress Content
			if ( ! in_array( $content_dir, $old_replace_values ) ) {
				$old_replace_values[] = $content_dir;
				$new_replace_values[] = WP_CONTENT_DIR;
			}

			// Add URL encoded WordPress Content
			if ( ! in_array( urlencode( $content_dir ), $old_replace_values ) ) {
				$old_replace_values[] = urlencode( $content_dir );
				$new_replace_values[] = urlencode( WP_CONTENT_DIR );
			}

			// Add URL raw encoded WordPress Content
			if ( ! in_array( rawurlencode( $content_dir ), $old_replace_values ) ) {
				$old_replace_values[] = rawurlencode( $content_dir );
				$new_replace_values[] = rawurlencode( WP_CONTENT_DIR );
			}

			// Add JSON escaped WordPress Content
			if ( ! in_array( addcslashes( $content_dir, '/' ), $old_replace_values ) ) {
				$old_replace_values[] = addcslashes( $content_dir, '/' );
				$new_replace_values[] = addcslashes( WP_CONTENT_DIR, '/' );
			}
		}

		// Get replace old and new values
		if ( isset( $config['Replace'] ) && ( $replace = $config['Replace'] ) ) {
			for ( $i = 0; $i < count( $replace['OldValues'] ); $i++ ) {
				if ( ! empty( $replace['OldValues'][ $i ] ) && ! empty( $replace['NewValues'][ $i ] ) ) {

					// Add plain replace values
					if ( ! in_array( $replace['OldValues'][ $i ], $old_replace_values ) ) {
						$old_replace_values[] = $replace['OldValues'][ $i ];
						$new_replace_values[] = $replace['NewValues'][ $i ];
					}

					// Add URL encoded replace values
					if ( ! in_array( urlencode( $replace['OldValues'][ $i ] ), $old_replace_values ) ) {
						$old_replace_values[] = urlencode( $replace['OldValues'][ $i ] );
						$new_replace_values[] = urlencode( $replace['NewValues'][ $i ] );
					}

					// Add URL raw encoded replace values
					if ( ! in_array( rawurlencode( $replace['OldValues'][ $i ] ), $old_replace_values ) ) {
						$old_replace_values[] = rawurlencode( $replace['OldValues'][ $i ] );
						$new_replace_values[] = rawurlencode( $replace['NewValues'][ $i ] );
					}

					// Add JSON Escaped replace values
					if ( ! in_array( addcslashes( $replace['OldValues'][ $i ], '/' ), $old_replace_values ) ) {
						$old_replace_values[] = addcslashes( $replace['OldValues'][ $i ], '/' );
						$new_replace_values[] = addcslashes( $replace['NewValues'][ $i ], '/' );
					}
				}
			}
		}

		// Get site URL
		$site_url = get_option( CPIWM_SITE_URL );

		// Get home URL
		$home_url = get_option( CPIWM_HOME_URL );

		// Get secret key
		$secret_key = get_option( CPIWM_SECRET_KEY );

		// Get HTTP user
		$auth_user = get_option( CPIWM_AUTH_USER );

		// Get HTTP password
		$auth_password = get_option( CPIWM_AUTH_PASSWORD );

		// Get backups labels
		$backups_labels = get_option( CPIWM_BACKUPS_LABELS, array() );

		// Get sites links
		$sites_links = get_option( CPIWM_SITES_LINKS, array() );

		$old_table_prefixes = array();
		$new_table_prefixes = array();

		// Set site table prefixes
		foreach ( $blogs as $blog ) {
			if ( cpiwm_main_site( $blog['Old']['BlogID'] ) === false ) {
				$old_table_prefixes[] = cpiwm_servmask_prefix( $blog['Old']['BlogID'] );
				$new_table_prefixes[] = cpiwm_table_prefix( $blog['New']['BlogID'] );
			}
		}

		// Set global table prefixes
		foreach ( $wpdb->global_tables as $table_name ) {
			$old_table_prefixes[] = cpiwm_servmask_prefix( 'mainsite' ) . $table_name;
			$new_table_prefixes[] = cpiwm_table_prefix() . $table_name;
		}

		// Set base table prefixes
		foreach ( $blogs as $blog ) {
			if ( cpiwm_main_site( $blog['Old']['BlogID'] ) === true ) {
				$old_table_prefixes[] = cpiwm_servmask_prefix( 'basesite' );
				$new_table_prefixes[] = cpiwm_table_prefix( $blog['New']['BlogID'] );
			}
		}

		// Set main table prefixes
		foreach ( $blogs as $blog ) {
			if ( cpiwm_main_site( $blog['Old']['BlogID'] ) === true ) {
				$old_table_prefixes[] = cpiwm_servmask_prefix( $blog['Old']['BlogID'] );
				$new_table_prefixes[] = cpiwm_table_prefix( $blog['New']['BlogID'] );
			}
		}

		// Set table prefixes
		$old_table_prefixes[] = cpiwm_servmask_prefix();
		$new_table_prefixes[] = cpiwm_table_prefix();

		// Get database client
		if ( empty( $wpdb->use_mysqli ) ) {
			$mysql = new Cpiwm_Database_Mysql( $wpdb );
		} else {
			$mysql = new Cpiwm_Database_Mysqli( $wpdb );
		}

		// Set database options
		$mysql->set_old_table_prefixes( $old_table_prefixes )
			->set_new_table_prefixes( $new_table_prefixes )
			->set_old_replace_values( $old_replace_values )
			->set_new_replace_values( $new_replace_values )
			->set_old_replace_raw_values( $old_replace_raw_values )
			->set_new_replace_raw_values( $new_replace_raw_values );

		// Set atomic tables (do not stop the current request for all listed tables if timeout has been exceeded)
		$mysql->set_atomic_tables( array( cpiwm_table_prefix() . 'options' ) );

		// Set Visual Composer
		$mysql->set_visual_composer( cpiwm_validate_plugin_basename( 'js_composer/js_composer.php' ) );

		// Set Optimize Press
		$mysql->set_optimize_press( cpiwm_validate_plugin_basename( 'optimizePressPlugin/optimizepress.php' ) );

		// Set BeTheme Responsive
		$mysql->set_betheme_responsive( cpiwm_validate_theme_basename( 'betheme/style.css' ) );

		// Import database
		if ( $mysql->import( cpiwm_database_path( $params ), $query_offset ) ) {

			// Set progress
			Cpiwm_Status::info( __( 'Done restoring database.', CPIWM_PLUGIN_NAME ) );

			// Unset query offset
			unset( $params['query_offset'] );

			// Unset total queries size
			unset( $params['total_queries_size'] );

			// Unset completed flag
			unset( $params['completed'] );

		} else {

			// Get total queries size
			$total_queries_size = cpiwm_database_bytes( $params );

			// What percent of queries have we processed?
			$progress = (int) ( ( $query_offset / $total_queries_size ) * 100 );

			// Set progress
			Cpiwm_Status::info( sprintf( __( 'Restoring database...<br />%d%% complete', CPIWM_PLUGIN_NAME ), $progress ) );

			// Set query offset
			$params['query_offset'] = $query_offset;

			// Set total queries size
			$params['total_queries_size'] = $total_queries_size;

			// Set completed flag
			$params['completed'] = false;
		}

		// Flush WP cache
		cpiwm_cache_flush();

		// Activate plugins
		cpiwm_activate_plugins( cpiwm_active_servmask_plugins() );

		// Set the new site URL
		update_option( CPIWM_SITE_URL, $site_url );

		// Set the new home URL
		update_option( CPIWM_HOME_URL, $home_url );

		// Set the new secret key value
		update_option( CPIWM_SECRET_KEY, $secret_key );

		// Set the new HTTP user
		update_option( CPIWM_AUTH_USER, $auth_user );

		// Set the new HTTP password
		update_option( CPIWM_AUTH_PASSWORD, $auth_password );

		// Set the new backups labels
		update_option( CPIWM_BACKUPS_LABELS, $backups_labels );

		// Set the new sites links
		update_option( CPIWM_SITES_LINKS, $sites_links );

		return $params;
	}
}
