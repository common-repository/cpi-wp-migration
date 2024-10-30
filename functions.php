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

/**
 * Get storage absolute path
 *
 * @param  array  $params Request parameters
 * @return string
 */
function cpiwm_storage_path( $params ) {
	if ( empty( $params['storage'] ) ) {
		throw new Cpiwm_Storage_Exception( __( 'Unable to locate storage path. <a href="#" target="_blank">Technical details</a>', CPIWM_PLUGIN_NAME ) );
	}

	// Get storage path
	$storage = CPIWM_STORAGE_PATH . DIRECTORY_SEPARATOR . basename( $params['storage'] );
	if ( ! is_dir( $storage ) ) {
		mkdir( $storage );
	}

	return $storage;
}

/**
 * Get backup absolute path
 *
 * @param  array  $params Request parameters
 * @return string
 */
function cpiwm_backup_path( $params ) {
	if ( empty( $params['archive'] ) ) {
		throw new Cpiwm_Archive_Exception( __( 'Unable to locate archive path. <a href="#" target="_blank">Technical details</a>', CPIWM_PLUGIN_NAME ) );
	}

	// Validate archive path
	if ( validate_file( $params['archive'] ) !== 0 ) {
		throw new Cpiwm_Archive_Exception( __( 'Invalid archive path. <a href="#" target="_blank">Technical details</a>', CPIWM_PLUGIN_NAME ) );
	}

	return CPIWM_BACKUPS_PATH . DIRECTORY_SEPARATOR . $params['archive'];
}

/**
 * Get archive absolute path
 *
 * @param  array  $params Request parameters
 * @return string
 */
function cpiwm_archive_path( $params ) {
	if ( empty( $params['archive'] ) ) {
		throw new Cpiwm_Archive_Exception( __( 'Unable to locate archive path. <a href="#" target="_blank">Technical details</a>', CPIWM_PLUGIN_NAME ) );
	}

	// Validate archive path
	if ( validate_file( $params['archive'] ) !== 0 ) {
		throw new Cpiwm_Archive_Exception( __( 'Invalid archive path. <a href="#" target="_blank">Technical details</a>', CPIWM_PLUGIN_NAME ) );
	}

	// Get archive path
	if ( empty( $params['cpiwm_manual_restore'] ) ) {
		return cpiwm_storage_path( $params ) . DIRECTORY_SEPARATOR . $params['archive'];
	}

	return cpiwm_backup_path( $params );
}

/**
 * Get export log absolute path
 *
 * @param  array  $params Request parameters
 * @return string
 */
function cpiwm_export_path( $params ) {
	return cpiwm_storage_path( $params ) . DIRECTORY_SEPARATOR . CPIWM_EXPORT_NAME;
}

/**
 * Get import log absolute path
 *
 * @param  array  $params Request parameters
 * @return string
 */
function cpiwm_import_path( $params ) {
	return cpiwm_storage_path( $params ) . DIRECTORY_SEPARATOR . CPIWM_IMPORT_NAME;
}

/**
 * Get multipart.list absolute path
 *
 * @param  array  $params Request parameters
 * @return string
 */
function cpiwm_multipart_path( $params ) {
	return cpiwm_storage_path( $params ) . DIRECTORY_SEPARATOR . CPIWM_MULTIPART_NAME;
}

/**
 * Get filemap.list absolute path
 *
 * @param  array  $params Request parameters
 * @return string
 */
function cpiwm_filemap_path( $params ) {
	return cpiwm_storage_path( $params ) . DIRECTORY_SEPARATOR . CPIWM_FILEMAP_NAME;
}

/**
 * Get package.json absolute path
 *
 * @param  array  $params Request parameters
 * @return string
 */
function cpiwm_package_path( $params ) {
	return cpiwm_storage_path( $params ) . DIRECTORY_SEPARATOR . CPIWM_PACKAGE_NAME;
}

/**
 * Get multisite.json absolute path
 *
 * @param  array  $params Request parameters
 * @return string
 */
function cpiwm_multisite_path( $params ) {
	return cpiwm_storage_path( $params ) . DIRECTORY_SEPARATOR . CPIWM_MULTISITE_NAME;
}

/**
 * Get blogs.json absolute path
 *
 * @param  array  $params Request parameters
 * @return string
 */
function cpiwm_blogs_path( $params ) {
	return cpiwm_storage_path( $params ) . DIRECTORY_SEPARATOR . CPIWM_BLOGS_NAME;
}

/**
 * Get settings.json absolute path
 *
 * @param  array  $params Request parameters
 * @return string
 */
function cpiwm_settings_path( $params ) {
	return cpiwm_storage_path( $params ) . DIRECTORY_SEPARATOR . CPIWM_SETTINGS_NAME;
}

/**
 * Get database.sql absolute path
 *
 * @param  array  $params Request parameters
 * @return string
 */
function cpiwm_database_path( $params ) {
	return cpiwm_storage_path( $params ) . DIRECTORY_SEPARATOR . CPIWM_DATABASE_NAME;
}

/**
 * Get error log absolute path
 *
 * @return string
 */
function cpiwm_error_path() {
	return CPIWM_STORAGE_PATH . DIRECTORY_SEPARATOR . CPIWM_ERROR_NAME;
}

/**
 * Get WordPress content directory
 *
 * @param  string $path Relative path
 * @return string
 */
function cpiwm_content_path( $path = null ) {
	if ( empty( $path ) ) {
		return WP_CONTENT_DIR;
	}

	return WP_CONTENT_DIR . DIRECTORY_SEPARATOR . $path;
}

/**
 * Get archive name
 *
 * @param  array  $params Request parameters
 * @return string
 */
function cpiwm_archive_name( $params ) {
	return basename( $params['archive'] );
}

/**
 * Get backup URL address
 *
 * @param  array  $params Request parameters
 * @return string
 */
function cpiwm_backup_url( $params ) {
	return CPIWM_BACKUPS_URL . '/' . str_replace( DIRECTORY_SEPARATOR, '/', $params['archive'] );
}

/**
 * Get archive size in bytes
 *
 * @param  array   $params Request parameters
 * @return integer
 */
function cpiwm_archive_bytes( $params ) {
	return filesize( cpiwm_archive_path( $params ) );
}

/**
 * Get backup size in bytes
 *
 * @param  array   $params Request parameters
 * @return integer
 */
function cpiwm_backup_bytes( $params ) {
	return filesize( cpiwm_backup_path( $params ) );
}

/**
 * Get database size in bytes
 *
 * @param  array   $params Request parameters
 * @return integer
 */
function cpiwm_database_bytes( $params ) {
	return filesize( cpiwm_database_path( $params ) );
}

/**
 * Get package size in bytes
 *
 * @param  array   $params Request parameters
 * @return integer
 */
function cpiwm_package_bytes( $params ) {
	return filesize( cpiwm_package_path( $params ) );
}

/**
 * Get multisite size in bytes
 *
 * @param  array   $params Request parameters
 * @return integer
 */
function cpiwm_multisite_bytes( $params ) {
	return filesize( cpiwm_multisite_path( $params ) );
}

/**
 * Get archive size as text
 *
 * @param  array  $params Request parameters
 * @return string
 */
function cpiwm_archive_size( $params ) {
	return cpiwm_size_format( filesize( cpiwm_archive_path( $params ) ) );
}

/**
 * Get backup size as text
 *
 * @param  array  $params Request parameters
 * @return string
 */
function cpiwm_backup_size( $params ) {
	return cpiwm_size_format( filesize( cpiwm_backup_path( $params ) ) );
}

/**
 * Parse file size
 *
 * @param  string $size    File size
 * @param  string $default Default size
 * @return string
 */
function cpiwm_parse_size( $size, $default = null ) {
	$suffixes = array(
		''  => 1,
		'k' => 1000,
		'm' => 1000000,
		'g' => 1000000000,
	);

	// Parse size format
	if ( preg_match( '/([0-9]+)\s*(k|m|g)?(b?(ytes?)?)/i', $size, $match ) ) {
		return $match[1] * $suffixes[ strtolower( $match[2] ) ];
	}

	return $default;
}

/**
 * Format file size into human-readable string
 *
 * Fixes the WP size_format bug: size_format( '0' ) => false
 *
 * @param  int|string   $bytes            Number of bytes. Note max integer size for integers.
 * @param  int          $decimals         Optional. Precision of number of decimal places. Default 0.
 * @return string|false False on failure. Number string on success.
 */
function cpiwm_size_format( $bytes, $decimals = 0 ) {
	if ( strval( $bytes ) === '0' ) {
		return size_format( 0, $decimals );
	}

	return size_format( $bytes, $decimals );
}

/**
 * Get current site name
 *
 * @param  integer $blog_id Blog ID
 * @return string
 */
function cpiwm_site_name( $blog_id = null ) {
	return parse_url( get_site_url( $blog_id ), PHP_URL_HOST );
}

/**
 * Get archive file name
 *
 * @param  integer $blog_id Blog ID
 * @return string
 */
function cpiwm_archive_file( $blog_id = null ) {
	$name = array();

	// Add domain
	$name[] = parse_url( get_site_url( $blog_id ), PHP_URL_HOST );

	// Add path
	if ( ( $path = explode( '/', parse_url( get_site_url( $blog_id ), PHP_URL_PATH ) ) ) ) {
		foreach ( $path as $directory ) {
			if ( $directory ) {
				$name[] = $directory;
			}
		}
	}

	// Add year, month and day
	$name[] = date( 'Ymd' );

	// Add hours, minutes and seconds
	$name[] = date( 'His' );

	// Add unique identifier
	$name[] = rand( 100, 999 );

	return sprintf( '%s.wpress', strtolower( implode( '-', $name ) ) );
}

/**
 * Get archive folder name
 *
 * @param  integer $blog_id Blog ID
 * @return string
 */
function cpiwm_archive_folder( $blog_id = null ) {
	$name = array();

	// Add domain
	$name[] = parse_url( get_site_url( $blog_id ), PHP_URL_HOST );

	// Add path
	if ( ( $path = explode( '/', parse_url( get_site_url( $blog_id ), PHP_URL_PATH ) ) ) ) {
		foreach ( $path as $directory ) {
			if ( $directory ) {
				$name[] = $directory;
			}
		}
	}

	return strtolower( implode( '-', $name ) );
}

/**
 * Get archive bucket name
 *
 * @param  integer $blog_id Blog ID
 * @return string
 */
function cpiwm_archive_bucket( $blog_id = null ) {
	$name = array();

	// Add domain
	if ( ( $domain = explode( '.', parse_url( get_site_url( $blog_id ), PHP_URL_HOST ) ) ) ) {
		foreach ( $domain as $subdomain ) {
			if ( $subdomain = strtolower( preg_replace( '/[^A-Za-z0-9\-]/', '', $subdomain ) ) ) {
				$name[] = $subdomain;
			}
		}
	}

	// Add path
	if ( ( $path = explode( '/', parse_url( get_site_url( $blog_id ), PHP_URL_PATH ) ) ) ) {
		foreach ( $path as $directory ) {
			if ( $directory = strtolower( preg_replace( '/[^A-Za-z0-9\-]/', '', $directory ) ) ) {
				$name[] = $directory;
			}
		}
	}

	return strtolower( implode( '-', $name ) );
}

/**
 * Get archive vault name
 *
 * @param  integer $blog_id Blog ID
 * @return string
 */
function cpiwm_archive_vault( $blog_id = null ) {
	$name = array();

	// Add domain
	if ( ( $domain = explode( '.', parse_url( get_site_url( $blog_id ), PHP_URL_HOST ) ) ) ) {
		foreach ( $domain as $subdomain ) {
			if ( $subdomain = strtolower( preg_replace( '/[^A-Za-z0-9\-]/', '', $subdomain ) ) ) {
				$name[] = $subdomain;
			}
		}
	}

	// Add path
	if ( ( $path = explode( '/', parse_url( get_site_url( $blog_id ), PHP_URL_PATH ) ) ) ) {
		foreach ( $path as $directory ) {
			if ( $directory = strtolower( preg_replace( '/[^A-Za-z0-9\-]/', '', $directory ) ) ) {
				$name[] = $directory;
			}
		}
	}

	return strtolower( implode( '-', $name ) );
}

/**
 * Get archive project name
 *
 * @param  integer $blog_id Blog ID
 * @return string
 */
function cpiwm_archive_project( $blog_id = null ) {
	$name = array();

	// Add domain
	if ( ( $domain = explode( '.', parse_url( get_site_url( $blog_id ), PHP_URL_HOST ) ) ) ) {
		foreach ( $domain as $subdomain ) {
			if ( $subdomain ) {
				$name[] = $subdomain;
			}
		}
	}

	// Add path
	if ( ( $path = explode( '/', parse_url( get_site_url( $blog_id ), PHP_URL_PATH ) ) ) ) {
		foreach ( $path as $directory ) {
			if ( $directory ) {
				$name[] = $directory;
			}
		}
	}

	return strtolower( implode( '-', $name ) );
}

/**
 * Get archive share name
 *
 * @param  integer $blog_id Blog ID
 * @return string
 */
function cpiwm_archive_share( $blog_id = null ) {
	$name = array();

	// Add domain
	if ( ( $domain = explode( '.', parse_url( get_site_url( $blog_id ), PHP_URL_HOST ) ) ) ) {
		foreach ( $domain as $subdomain ) {
			if ( $subdomain = strtolower( preg_replace( '/[^A-Za-z0-9\-]/', '', $subdomain ) ) ) {
				$name[] = $subdomain;
			}
		}
	}

	// Add path
	if ( ( $path = explode( '/', parse_url( get_site_url( $blog_id ), PHP_URL_PATH ) ) ) ) {
		foreach ( $path as $directory ) {
			if ( $directory = strtolower( preg_replace( '/[^A-Za-z0-9\-]/', '', $directory ) ) ) {
				$name[] = $directory;
			}
		}
	}

	return strtolower( implode( '-', $name ) );
}

/**
 * Get storage folder name
 *
 * @return string
 */
function cpiwm_storage_folder() {
	return uniqid();
}

/**
 * Check whether blog ID is main site
 *
 * @param  integer $blog_id Blog ID
 * @return boolean
 */
function cpiwm_main_site( $blog_id = null ) {
	return $blog_id === null || $blog_id === 0 || $blog_id === 1;
}

/**
 * Get sites absolute path by blog ID
 *
 * @param  integer $blog_id Blog ID
 * @return string
 */
function cpiwm_sites_path( $blog_id = null ) {
	if ( cpiwm_main_site( $blog_id ) ) {
		return CPIWM_UPLOADS_PATH;
	}

	return CPIWM_SITES_PATH . DIRECTORY_SEPARATOR . $blog_id;
}

/**
 * Get files absolute path by blog ID
 *
 * @param  integer $blog_id Blog ID
 * @return string
 */
function cpiwm_files_path( $blog_id = null ) {
	if ( cpiwm_main_site( $blog_id ) ) {
		return CPIWM_UPLOADS_PATH;
	}

	return CPIWM_BLOGSDIR_PATH . DIRECTORY_SEPARATOR . $blog_id . DIRECTORY_SEPARATOR . 'files';
}

/**
 * Get blogs.dir absolute path by blog ID
 *
 * @param  integer $blog_id Blog ID
 * @return string
 */
function cpiwm_blogsdir_path( $blog_id = null ) {
	if ( cpiwm_main_site( $blog_id ) ) {
		return '/wp-content/uploads/';
	}

	return "/wp-content/blogs.dir/{$blog_id}/files/";
}

/**
 * Get blogs.dir URL by blog ID
 *
 * @param  integer $blog_id Blog ID
 * @return string
 */
function cpiwm_blogsdir_url( $blog_id = null ) {
	if ( cpiwm_main_site( $blog_id ) ) {
		return get_site_url( $blog_id, '/wp-content/uploads/' );
	}

	return get_site_url( $blog_id, "/wp-content/blogs.dir/{$blog_id}/files/" );
}

/**
 * Get uploads absolute path by blog ID
 *
 * @param  integer $blog_id Blog ID
 * @return string
 */
function cpiwm_uploads_path( $blog_id = null ) {
	if ( cpiwm_main_site( $blog_id ) ) {
		return '/wp-content/uploads/';
	}

	return "/wp-content/uploads/sites/{$blog_id}/";
}

/**
 * Get uploads URL by blog ID
 *
 * @param  integer $blog_id Blog ID
 * @return string
 */
function cpiwm_uploads_url( $blog_id = null ) {
	if ( cpiwm_main_site( $blog_id ) ) {
		return get_site_url( $blog_id, '/wp-content/uploads/' );
	}

	return get_site_url( $blog_id, "/wp-content/uploads/sites/{$blog_id}/" );
}

/**
 * Get ServMask table prefix by blog ID
 *
 * @param  integer $blog_id Blog ID
 * @return string
 */
function cpiwm_servmask_prefix( $blog_id = null ) {
	// Set base table prefix
	if ( cpiwm_main_site( $blog_id ) ) {
		return CPIWM_TABLE_PREFIX;
	}

	return CPIWM_TABLE_PREFIX . $blog_id . '_';
}

/**
 * Get WordPress table prefix by blog ID
 *
 * @param  integer $blog_id Blog ID
 * @return string
 */
function cpiwm_table_prefix( $blog_id = null ) {
	global $wpdb;

	// Set base table prefix
	if ( cpiwm_main_site( $blog_id ) ) {
		return $wpdb->base_prefix;
	}

	return $wpdb->base_prefix . $blog_id . '_';
}

/**
 * Get default content filters
 *
 * @param  array $filters List of files and directories
 * @return array
 */
function cpiwm_content_filters( $filters = array() ) {
	return array_merge(
		$filters,
		array(
			CPIWM_BACKUPS_NAME,
			CPIWM_PACKAGE_NAME,
			CPIWM_MULTISITE_NAME,
			CPIWM_DATABASE_NAME,
		)
	);
}

/**
 * Get default plugin filters
 *
 * @param  array $filters List of plugins
 * @return array
 */
function cpiwm_plugin_filters( $filters = array() ) {
	// WP Migration Plugin
	if ( defined( 'CPIWM_PLUGIN_BASENAME' ) ) {
		$filters[] = 'plugins' . DIRECTORY_SEPARATOR . dirname( CPIWM_PLUGIN_BASENAME );
	} else {
		$filters[] = 'plugins' . DIRECTORY_SEPARATOR . 'cpi-wp-migration';
	}

	// Microsoft Azure Extension
	if ( defined( 'CPIWMZE_PLUGIN_BASENAME' ) ) {
		$filters[] = 'plugins' . DIRECTORY_SEPARATOR . dirname( CPIWMZE_PLUGIN_BASENAME );
	} else {
		$filters[] = 'plugins' . DIRECTORY_SEPARATOR . 'cpi-wp-migration-azure-storage-extension';
	}

	// Backblaze B2 Extension
	if ( defined( 'CPIWMAE_PLUGIN_BASENAME' ) ) {
		$filters[] = 'plugins' . DIRECTORY_SEPARATOR . dirname( CPIWMAE_PLUGIN_BASENAME );
	} else {
		$filters[] = 'plugins' . DIRECTORY_SEPARATOR . 'cpi-wp-migration-b2-extension';
	}

	// Box Extension
	if ( defined( 'CPIWMBE_PLUGIN_BASENAME' ) ) {
		$filters[] = 'plugins' . DIRECTORY_SEPARATOR . dirname( CPIWMBE_PLUGIN_BASENAME );
	} else {
		$filters[] = 'plugins' . DIRECTORY_SEPARATOR . 'cpi-wp-migration-box-extension';
	}

	// DigitalOcean Spaces Extension
	if ( defined( 'CPIWMIE_PLUGIN_BASENAME' ) ) {
		$filters[] = 'plugins' . DIRECTORY_SEPARATOR . dirname( CPIWMIE_PLUGIN_BASENAME );
	} else {
		$filters[] = 'plugins' . DIRECTORY_SEPARATOR . 'cpi-wp-migration-digitalocean-extension';
	}

	// Direct Extension
	if ( defined( 'CPIWMXE_PLUGIN_BASENAME' ) ) {
		$filters[] = 'plugins' . DIRECTORY_SEPARATOR . dirname( CPIWMXE_PLUGIN_BASENAME );
	} else {
		$filters[] = 'plugins' . DIRECTORY_SEPARATOR . 'cpi-wp-migration-direct-extension';
	}

	// Dropbox Extension
	if ( defined( 'CPIWMDE_PLUGIN_BASENAME' ) ) {
		$filters[] = 'plugins' . DIRECTORY_SEPARATOR . dirname( CPIWMDE_PLUGIN_BASENAME );
	} else {
		$filters[] = 'plugins' . DIRECTORY_SEPARATOR . 'cpi-wp-migration-dropbox-extension';
	}

	// File Extension
	if ( defined( 'CPIWMTE_PLUGIN_BASENAME' ) ) {
		$filters[] = 'plugins' . DIRECTORY_SEPARATOR . dirname( CPIWMTE_PLUGIN_BASENAME );
	} else {
		$filters[] = 'plugins' . DIRECTORY_SEPARATOR . 'cpi-wp-migration-file-extension';
	}

	// FTP Extension
	if ( defined( 'CPIWMFE_PLUGIN_BASENAME' ) ) {
		$filters[] = 'plugins' . DIRECTORY_SEPARATOR . dirname( CPIWMFE_PLUGIN_BASENAME );
	} else {
		$filters[] = 'plugins' . DIRECTORY_SEPARATOR . 'cpi-wp-migration-ftp-extension';
	}

	// Google Cloud Storage Extension
	if ( defined( 'CPIWMCE_PLUGIN_BASENAME' ) ) {
		$filters[] = 'plugins' . DIRECTORY_SEPARATOR . dirname( CPIWMCE_PLUGIN_BASENAME );
	} else {
		$filters[] = 'plugins' . DIRECTORY_SEPARATOR . 'cpi-wp-migration-gcloud-storage-extension';
	}

	// Google Drive Extension
	if ( defined( 'CPIWMGE_PLUGIN_BASENAME' ) ) {
		$filters[] = 'plugins' . DIRECTORY_SEPARATOR . dirname( CPIWMGE_PLUGIN_BASENAME );
	} else {
		$filters[] = 'plugins' . DIRECTORY_SEPARATOR . 'cpi-wp-migration-gdrive-extension';
	}

	// Amazon Glacier Extension
	if ( defined( 'CPIWMRE_PLUGIN_BASENAME' ) ) {
		$filters[] = 'plugins' . DIRECTORY_SEPARATOR . dirname( CPIWMRE_PLUGIN_BASENAME );
	} else {
		$filters[] = 'plugins' . DIRECTORY_SEPARATOR . 'cpi-wp-migration-glacier-extension';
	}

	// Mega Extension
	if ( defined( 'CPIWMEE_PLUGIN_BASENAME' ) ) {
		$filters[] = 'plugins' . DIRECTORY_SEPARATOR . dirname( CPIWMEE_PLUGIN_BASENAME );
	} else {
		$filters[] = 'plugins' . DIRECTORY_SEPARATOR . 'cpi-wp-migration-mega-extension';
	}

	// Multisite Extension
	if ( defined( 'CPIWMME_PLUGIN_BASENAME' ) ) {
		$filters[] = 'plugins' . DIRECTORY_SEPARATOR . dirname( CPIWMME_PLUGIN_BASENAME );
	} else {
		$filters[] = 'plugins' . DIRECTORY_SEPARATOR . 'cpi-wp-migration-multisite-extension';
	}

	// OneDrive Extension
	if ( defined( 'CPIWMOE_PLUGIN_BASENAME' ) ) {
		$filters[] = 'plugins' . DIRECTORY_SEPARATOR . dirname( CPIWMOE_PLUGIN_BASENAME );
	} else {
		$filters[] = 'plugins' . DIRECTORY_SEPARATOR . 'cpi-wp-migration-onedrive-extension';
	}

	// pCloud Extension
	if ( defined( 'CPIWMPE_PLUGIN_BASENAME' ) ) {
		$filters[] = 'plugins' . DIRECTORY_SEPARATOR . dirname( CPIWMPE_PLUGIN_BASENAME );
	} else {
		$filters[] = 'plugins' . DIRECTORY_SEPARATOR . 'cpi-wp-migration-pcloud-extension';
	}

	// S3 Client Extension
	if ( defined( 'AI1WNE_PLUGIN_BASENAME' ) ) {
		$filters[] = 'plugins' . DIRECTORY_SEPARATOR . dirname( CPIWMNE_PLUGIN_BASENAME );
	} else {
		$filters[] = 'plugins' . DIRECTORY_SEPARATOR . 'cpi-wp-migration-s3-client-extension';
	}

	// Amazon S3 Extension
	if ( defined( 'CPIWMSE_PLUGIN_BASENAME' ) ) {
		$filters[] = 'plugins' . DIRECTORY_SEPARATOR . dirname( CPIWMSE_PLUGIN_BASENAME );
	} else {
		$filters[] = 'plugins' . DIRECTORY_SEPARATOR . 'cpi-wp-migration-s3-extension';
	}

	// Unlimited Extension
	if ( defined( 'CPIWMUE_PLUGIN_BASENAME' ) ) {
		$filters[] = 'plugins' . DIRECTORY_SEPARATOR . dirname( CPIWMUE_PLUGIN_BASENAME );
	} else {
		$filters[] = 'plugins' . DIRECTORY_SEPARATOR . 'cpi-wp-migration-unlimited-extension';
	}

	// URL Extension
	if ( defined( 'CPIWMLE_PLUGIN_BASENAME' ) ) {
		$filters[] = 'plugins' . DIRECTORY_SEPARATOR . dirname( CPIWMLE_PLUGIN_BASENAME );
	} else {
		$filters[] = 'plugins' . DIRECTORY_SEPARATOR . 'cpi-wp-migration-url-extension';
	}

	// WebDAV Extension
	if ( defined( 'CPIWMWE_PLUGIN_BASENAME' ) ) {
		$filters[] = 'plugins' . DIRECTORY_SEPARATOR . dirname( CPIWMWE_PLUGIN_BASENAME );
	} else {
		$filters[] = 'plugins' . DIRECTORY_SEPARATOR . 'cpi-wp-migration-webdav-extension';
	}

	return $filters;
}

/**
 * Get active ServMask plugins
 *
 * @return array
 */
function cpiwm_active_servmask_plugins( $plugins = array() ) {
	// WP Migration Plugin
	if ( defined( 'CPIWM_PLUGIN_BASENAME' ) ) {
		$plugins[] = CPIWM_PLUGIN_BASENAME;
	}

	// Microsoft Azure Extension
	if ( defined( 'CPIWMZE_PLUGIN_BASENAME' ) ) {
		$plugins[] = CPIWMZE_PLUGIN_BASENAME;
	}

	// Backblaze B2 Extension
	if ( defined( 'CPIWMAE_PLUGIN_BASENAME' ) ) {
		$plugins[] = CPIWMAE_PLUGIN_BASENAME;
	}

	// Box Extension
	if ( defined( 'CPIWMBE_PLUGIN_BASENAME' ) ) {
		$plugins[] = CPIWMBE_PLUGIN_BASENAME;
	}

	// DigitalOcean Spaces Extension
	if ( defined( 'CPIWMIE_PLUGIN_BASENAME' ) ) {
		$plugins[] = CPIWMIE_PLUGIN_BASENAME;
	}

	// Direct Extension
	if ( defined( 'CPIWMXE_PLUGIN_BASENAME' ) ) {
		$plugins[] = CPIWMXE_PLUGIN_BASENAME;
	}

	// Dropbox Extension
	if ( defined( 'CPIWMDE_PLUGIN_BASENAME' ) ) {
		$plugins[] = CPIWMDE_PLUGIN_BASENAME;
	}

	// File Extension
	if ( defined( 'CPIWMTE_PLUGIN_BASENAME' ) ) {
		$plugins[] = CPIWMTE_PLUGIN_BASENAME;
	}

	// FTP Extension
	if ( defined( 'CPIWMFE_PLUGIN_BASENAME' ) ) {
		$plugins[] = CPIWMFE_PLUGIN_BASENAME;
	}

	// Google Cloud Storage Extension
	if ( defined( 'CPIWMCE_PLUGIN_BASENAME' ) ) {
		$plugins[] = CPIWMCE_PLUGIN_BASENAME;
	}

	// Google Drive Extension
	if ( defined( 'CPIWMGE_PLUGIN_BASENAME' ) ) {
		$plugins[] = CPIWMGE_PLUGIN_BASENAME;
	}

	// Amazon Glacier Extension
	if ( defined( 'CPIWMRE_PLUGIN_BASENAME' ) ) {
		$plugins[] = CPIWMRE_PLUGIN_BASENAME;
	}

	// Mega Extension
	if ( defined( 'CPIWMEE_PLUGIN_BASENAME' ) ) {
		$plugins[] = CPIWMEE_PLUGIN_BASENAME;
	}

	// Multisite Extension
	if ( defined( 'CPIWMME_PLUGIN_BASENAME' ) ) {
		$plugins[] = CPIWMME_PLUGIN_BASENAME;
	}

	// OneDrive Extension
	if ( defined( 'CPIWMOE_PLUGIN_BASENAME' ) ) {
		$plugins[] = CPIWMOE_PLUGIN_BASENAME;
	}

	// pCloud Extension
	if ( defined( 'CPIWMPE_PLUGIN_BASENAME' ) ) {
		$plugins[] = CPIWMPE_PLUGIN_BASENAME;
	}

	// S3 Client Extension
	if ( defined( 'CPIWMNE_PLUGIN_BASENAME' ) ) {
		$plugins[] = CPIWMNE_PLUGIN_BASENAME;
	}

	// Amazon S3 Extension
	if ( defined( 'CPIWMSE_PLUGIN_BASENAME' ) ) {
		$plugins[] = CPIWMSE_PLUGIN_BASENAME;
	}

	// Unlimited Extension
	if ( defined( 'CPIWMUE_PLUGIN_BASENAME' ) ) {
		$plugins[] = CPIWMUE_PLUGIN_BASENAME;
	}

	// URL Extension
	if ( defined( 'CPIWMLE_PLUGIN_BASENAME' ) ) {
		$plugins[] = CPIWMLE_PLUGIN_BASENAME;
	}

	// WebDAV Extension
	if ( defined( 'CPIWMWE_PLUGIN_BASENAME' ) ) {
		$plugins[] = CPIWMWE_PLUGIN_BASENAME;
	}

	return $plugins;
}

/**
 * Get active sitewide plugins
 *
 * @return array
 */
function cpiwm_active_sitewide_plugins() {
	return array_keys( get_site_option( CPIWM_ACTIVE_SITEWIDE_PLUGINS, array() ) );
}

/**
 * Get active plugins
 *
 * @return array
 */
function cpiwm_active_plugins() {
	return array_values( get_option( CPIWM_ACTIVE_PLUGINS, array() ) );
}

/**
 * Set active sitewide plugins (inspired by WordPress activate_plugins() function)
 *
 * @param  array   $plugins List of plugins
 * @return boolean
 */
function cpiwm_activate_sitewide_plugins( $plugins ) {
	$current = get_site_option( CPIWM_ACTIVE_SITEWIDE_PLUGINS, array() );

	// Add plugins
	foreach ( $plugins as $plugin ) {
		if ( ! isset( $current[ $plugin ] ) && ! is_wp_error( validate_plugin( $plugin ) ) ) {
			$current[ $plugin ] = time();
		}
	}

	return update_site_option( CPIWM_ACTIVE_SITEWIDE_PLUGINS, $current );
}

/**
 * Set active plugins (inspired by WordPress activate_plugins() function)
 *
 * @param  array   $plugins List of plugins
 * @return boolean
 */
function cpiwm_activate_plugins( $plugins ) {
	$current = get_option( CPIWM_ACTIVE_PLUGINS, array() );

	// Add plugins
	foreach ( $plugins as $plugin ) {
		if ( ! in_array( $plugin, $current ) && ! is_wp_error( validate_plugin( $plugin ) ) ) {
			$current[] = $plugin;
		}
	}

	return update_option( CPIWM_ACTIVE_PLUGINS, $current );
}

/**
 * Get active template
 *
 * @return string
 */
function cpiwm_active_template() {
	return get_option( CPIWM_ACTIVE_TEMPLATE );
}

/**
 * Get active stylesheet
 *
 * @return string
 */
function cpiwm_active_stylesheet() {
	return get_option( CPIWM_ACTIVE_STYLESHEET );
}

/**
 * Set active template
 *
 * @param  string  $template Template name
 * @return boolean
 */
function cpiwm_activate_template( $template ) {
	return update_option( CPIWM_ACTIVE_TEMPLATE, $template );
}

/**
 * Set active stylesheet
 *
 * @param  string  $stylesheet Stylesheet name
 * @return boolean
 */
function cpiwm_activate_stylesheet( $stylesheet ) {
	return update_option( CPIWM_ACTIVE_STYLESHEET, $stylesheet );
}

/**
 * Set inactive sitewide plugins (inspired by WordPress deactivate_plugins() function)
 *
 * @param  array   $plugins List of plugins
 * @return boolean
 */
function cpiwm_deactivate_sitewide_plugins( $plugins ) {
	$current = get_site_option( CPIWM_ACTIVE_SITEWIDE_PLUGINS, array() );

	// Add plugins
	foreach ( $plugins as $plugin ) {
		if ( isset( $current[ $plugin ] ) ) {
			unset( $current[ $plugin ] );
		}
	}

	return update_site_option( CPIWM_ACTIVE_SITEWIDE_PLUGINS, $current );
}


/**
 * Set inactive plugins (inspired by WordPress deactivate_plugins() function)
 *
 * @param  array   $plugins List of plugins
 * @return boolean
 */
function cpiwm_deactivate_plugins( $plugins ) {
	$current = get_option( CPIWM_ACTIVE_PLUGINS, array() );

	// Remove plugins
	foreach ( $plugins as $plugin ) {
		if ( ( $key = array_search( $plugin, $current ) ) !== false ) {
			unset( $current[ $key ] );
		}
	}

	return update_option( CPIWM_ACTIVE_PLUGINS, $current );
}

/**
 * Deactivate Jetpack modules
 *
 * @param  array   $modules List of modules
 * @return boolean
 */
function cpiwm_deactivate_jetpack_modules( $modules ) {
	$current = get_option( CPIWM_JETPACK_ACTIVE_MODULES, array() );

	// Remove modules
	foreach ( $modules as $module ) {
		if ( ( $key = array_search( $module, $current ) ) !== false ) {
			unset( $current[ $key ] );
		}
	}

	return update_option( CPIWM_JETPACK_ACTIVE_MODULES, $current );
}

/**
 * Deactivate sitewide Revolution Slider
 *
 * @param  string  $basename Plugin basename
 * @return boolean
 */
function cpiwm_deactivate_sitewide_revolution_slider( $basename ) {
	global $wp_version;

	// Do not deactivate Revolution Slider (WordPress >= 5.2)
	if ( version_compare( $wp_version, '5.2', '>=' ) ) {
		return false;
	}

	// Deactivate Revolution Slider
	if ( ( $plugins = get_plugins() ) ) {
		if ( isset( $plugins[ $basename ]['Version'] ) && ( $version = $plugins[ $basename ]['Version'] ) ) {
			if ( version_compare( PHP_VERSION, '7.3', '>=' ) && version_compare( $version, '5.4.8.3', '<' ) ) {
				return cpiwm_deactivate_sitewide_plugins( array( $basename ) );
			}

			if ( version_compare( PHP_VERSION, '7.2', '>=' ) && version_compare( $version, '5.4.6', '<' ) ) {
				return cpiwm_deactivate_sitewide_plugins( array( $basename ) );
			}

			if ( version_compare( PHP_VERSION, '7.1', '>=' ) && version_compare( $version, '5.4.1', '<' ) ) {
				return cpiwm_deactivate_sitewide_plugins( array( $basename ) );
			}

			if ( version_compare( PHP_VERSION, '7.0', '>=' ) && version_compare( $version, '4.6.5', '<' ) ) {
				return cpiwm_deactivate_sitewide_plugins( array( $basename ) );
			}
		}
	}

	return false;
}

/**
 * Deactivate Revolution Slider
 *
 * @param  string  $basename Plugin basename
 * @return boolean
 */
function cpiwm_deactivate_revolution_slider( $basename ) {
	global $wp_version;

	// Do not deactivate Revolution Slider (WordPress >= 5.2)
	if ( version_compare( $wp_version, '5.2', '>=' ) ) {
		return false;
	}

	// Deactivate Revolution Slider
	if ( ( $plugins = get_plugins() ) ) {
		if ( isset( $plugins[ $basename ]['Version'] ) && ( $version = $plugins[ $basename ]['Version'] ) ) {
			if ( version_compare( PHP_VERSION, '7.3', '>=' ) && version_compare( $version, '5.4.8.3', '<' ) ) {
				return cpiwm_deactivate_plugins( array( $basename ) );
			}

			if ( version_compare( PHP_VERSION, '7.2', '>=' ) && version_compare( $version, '5.4.6', '<' ) ) {
				return cpiwm_deactivate_plugins( array( $basename ) );
			}

			if ( version_compare( PHP_VERSION, '7.1', '>=' ) && version_compare( $version, '5.4.1', '<' ) ) {
				return cpiwm_deactivate_plugins( array( $basename ) );
			}

			if ( version_compare( PHP_VERSION, '7.0', '>=' ) && version_compare( $version, '4.6.5', '<' ) ) {
				return cpiwm_deactivate_plugins( array( $basename ) );
			}
		}
	}

	return false;
}

/**
 * Discover plugin basename
 *
 * @param  string $basename Plugin basename
 * @return string
 */
function cpiwm_discover_plugin_basename( $basename ) {
	if ( ( $plugins = get_plugins() ) ) {
		foreach ( $plugins as $plugin => $info ) {
			if ( strpos( dirname( $plugin ), dirname( $basename ) ) !== false ) {
				if ( basename( $plugin ) === basename( $basename ) ) {
					return $plugin;
				}
			}
		}
	}

	return $basename;
}

/**
 * Validate plugin basename
 *
 * @param  string  $basename Plugin basename
 * @return boolean
 */
function cpiwm_validate_plugin_basename( $basename ) {
	if ( ( $plugins = get_plugins() ) ) {
		foreach ( $plugins as $plugin => $info ) {
			if ( $plugin === $basename ) {
				return true;
			}
		}
	}

	return false;
}

/**
 * Validate theme basename
 *
 * @param  string  $basename Theme basename
 * @return boolean
 */
function cpiwm_validate_theme_basename( $basename ) {
	if ( ( $themes = search_theme_directories() ) ) {
		foreach ( $themes as $theme => $info ) {
			if ( $info['theme_file'] === $basename ) {
				return true;
			}
		}
	}

	return false;
}

/**
 * Flush WP options cache
 *
 * @return void
 */
function cpiwm_cache_flush() {
	wp_cache_init();
	wp_cache_flush();

	// Reset WP options cache
	wp_cache_set( 'alloptions', array(), 'options' );
	wp_cache_set( 'notoptions', array(), 'options' );

	// Reset WP sitemeta cache
	wp_cache_set( '1:notoptions', array(), 'site-options' );
	wp_cache_set( '1:ms_files_rewriting', false, 'site-options' );
	wp_cache_set( '1:active_sitewide_plugins', false, 'site-options' );

	// Delete WP options cache
	wp_cache_delete( 'alloptions', 'options' );
	wp_cache_delete( 'notoptions', 'options' );

	// Delete WP sitemeta cache
	wp_cache_delete( '1:notoptions', 'site-options' );
	wp_cache_delete( '1:ms_files_rewriting', 'site-options' );
	wp_cache_delete( '1:active_sitewide_plugins', 'site-options' );

	// Remove WP options filter
	remove_all_filters( 'sanitize_option_home' );
	remove_all_filters( 'sanitize_option_siteurl' );
}

/**
 * Flush Elementor cache
 *
 * @return void
 */
function cpiwm_elementor_cache_flush() {
	delete_post_meta_by_key( '_elementor_css' );
	delete_option( '_elementor_global_css' );
	delete_option( 'elementor-custom-breakpoints-files' );
}

/**
 * Set URL scheme
 *
 * @param  string $url    URL value
 * @param  string $scheme URL scheme
 * @return string
 */
function cpiwm_url_scheme( $url, $scheme = '' ) {
	if ( empty( $scheme ) ) {
		return preg_replace( '#^\w+://#', '//', $url );
	}

	return preg_replace( '#^\w+://#', $scheme . '://', $url );
}

/**
 * Opens a file in specified mode
 *
 * @param  string   $file Path to the file to open
 * @param  string   $mode Mode in which to open the file
 * @return resource
 * @throws Cpiwm_Not_Accessible_Exception
 */
function cpiwm_open( $file, $mode ) {
	$file_handle = @fopen( $file, $mode );
	if ( false === $file_handle ) {
		throw new Cpiwm_Not_Accessible_Exception( sprintf( __( 'Unable to open %s with mode %s. <a href="#" target="_blank">Technical details</a>', CPIWM_PLUGIN_NAME ), $file, $mode ) );
	}

	return $file_handle;
}

/**
 * Write contents to a file
 *
 * @param  resource $handle  File handle to write to
 * @param  string   $content Contents to write to the file
 * @return integer
 * @throws Cpiwm_Not_Writable_Exception
 * @throws Cpiwm_Quota_Exceeded_Exception
 */
function cpiwm_write( $handle, $content ) {
	$write_result = @fwrite( $handle, $content );
	if ( false === $write_result ) {
		if ( ( $meta = stream_get_meta_data( $handle ) ) ) {
			throw new Cpiwm_Not_Writable_Exception( sprintf( __( 'Unable to write to: %s. <a href="#" target="_blank">Technical details</a>', CPIWM_PLUGIN_NAME ), $meta['uri'] ) );
		}
	} elseif ( strlen( $content ) !== $write_result ) {
		if ( ( $meta = stream_get_meta_data( $handle ) ) ) {
			throw new Cpiwm_Quota_Exceeded_Exception( sprintf( __( 'Out of disk space. Unable to write to: %s. <a href="#" target="_blank">Technical details</a>', CPIWM_PLUGIN_NAME ), $meta['uri'] ) );
		}
	}

	return $write_result;
}

/**
 * Read contents from a file
 *
 * @param  resource $handle   File handle to read from
 * @param  string   $filesize File size
 * @return integer
 * @throws Cpiwm_Not_Readable_Exception
 */
function cpiwm_read( $handle, $filesize ) {
	$read_result = @fread( $handle, $filesize );
	if ( false === $read_result ) {
		if ( ( $meta = stream_get_meta_data( $handle ) ) ) {
			throw new Cpiwm_Not_Readable_Exception( sprintf( __( 'Unable to read file: %s. <a href="#" target="_blank">Technical details</a>', CPIWM_PLUGIN_NAME ), $meta['uri'] ) );
		}
	}

	return $read_result;
}

/**
 * Seeks on a file pointer
 *
 * @param  string  $handle File handle to seeks
 * @return integer
 */
function cpiwm_seek( $handle, $offset, $mode = SEEK_SET ) {
	$seek_result = @fseek( $handle, $offset, $mode );
	if ( -1 === $seek_result ) {
		if ( ( $meta = stream_get_meta_data( $handle ) ) ) {
			throw new Cpiwm_Not_Seekable_Exception( sprintf( __( 'Unable to seek to offset %d on %s. <a href="#" target="_blank">Technical details</a>', CPIWM_PLUGIN_NAME ), $offset, $meta['uri'] ) );
		}
	}

	return $seek_result;
}

/**
 * Tells on a file pointer
 *
 * @param  string  $handle File handle to tells
 * @return integer
 */
function cpiwm_tell( $handle ) {
	$tell_result = @ftell( $handle );
	if ( false === $tell_result ) {
		if ( ( $meta = stream_get_meta_data( $handle ) ) ) {
			throw new Cpiwm_Not_Tellable_Exception( sprintf( __( 'Unable to get current pointer position of %s. <a href="#" target="_blank">Technical details</a>', CPIWM_PLUGIN_NAME ), $meta['uri'] ) );
		}
	}

	return $tell_result;
}

/**
 * Closes a file handle
 *
 * @param  resource $handle File handle to close
 * @return boolean
 */
function cpiwm_close( $handle ) {
	return @fclose( $handle );
}

/**
 * Deletes a file
 *
 * @param  string  $file Path to file to delete
 * @return boolean
 */
function cpiwm_unlink( $file ) {
	return @unlink( $file );
}

/**
 * Sets modification time of a file
 *
 * @param  string  $file Path to file to change modification time
 * @param  integer $time File modification time
 * @return boolean
 */
function cpiwm_touch( $file, $mtime ) {
	return @touch( $file, $mtime );
}

/**
 * Changes file mode
 *
 * @param  string  $file Path to file to change mode
 * @param  integer $time File mode
 * @return boolean
 */
function cpiwm_chmod( $file, $mode ) {
	return @chmod( $file, $mode );
}

/**
 * Copies one file's contents to another
 *
 * @param  string $source_file      File to copy the contents from
 * @param  string $destination_file File to copy the contents to
 */
function cpiwm_copy( $source_file, $destination_file ) {
	$source_handle      = cpiwm_open( $source_file, 'rb' );
	$destination_handle = cpiwm_open( $destination_file, 'ab' );
	while ( $buffer = cpiwm_read( $source_handle, 4096 ) ) {
		cpiwm_write( $destination_handle, $buffer );
	}
	cpiwm_close( $source_handle );
	cpiwm_close( $destination_handle );
}

/**
 * Check whether file size is supported by current PHP version
 *
 * @param  string  $file         Path to file
 * @param  integer $php_int_size Size of PHP integer
 * @return boolean $php_int_max  Max value of PHP integer
 */
function cpiwm_is_filesize_supported( $file, $php_int_size = PHP_INT_SIZE, $php_int_max = PHP_INT_MAX ) {
	$size_result = true;

	// Check whether file size is less than 2GB in PHP 32bits
	if ( $php_int_size === 4 ) {
		if ( ( $file_handle = @fopen( $file, 'r' ) ) ) {
			if ( @fseek( $file_handle, $php_int_max, SEEK_SET ) !== -1 ) {
				if ( @fgetc( $file_handle ) !== false ) {
					$size_result = false;
				}
			}

			@fclose( $file_handle );
		}
	}

	return $size_result;
}

/**
 * Verify secret key
 * * @param  string  $secret_key Secret key
 * @return boolean
 * @throws Cpiwm_Not_Valid_Secret_Key_Exception
 */
function cpiwm_verify_secret_key( $secret_key ) {
	if ( $secret_key !== get_option( CPIWM_SECRET_KEY ) ) {
		throw new Cpiwm_Not_Valid_Secret_Key_Exception( __( 'Unable to authenticate the secret key. <a href="#" target="_blank">Technical details</a>', CPIWM_PLUGIN_NAME ) );
	}

	return true;
}

/**
 * Is scheduled backup?
 *
 * @return boolean
 */
function cpiwm_is_scheduled_backup() {
	if ( isset( $_GET['cpiwm_manual_export'] ) || isset( $_POST['cpiwm_manual_export'] ) ) {
		return false;
	}

	if ( isset( $_GET['cpiwm_manual_import'] ) || isset( $_POST['cpiwm_manual_import'] ) ) {
		return false;
	}

	if ( isset( $_GET['cpiwm_manual_restore'] ) || isset( $_POST['cpiwm_manual_restore'] ) ) {
		return false;
	}

	return true;
}

/**
 * PHP setup environment
 *
 * @return void
 */
function cpiwm_setup_environment() {
	// Set whether a client disconnect should abort script execution
	@ignore_user_abort( true );

	// Set maximum execution time
	@set_time_limit( 0 );

	// Set maximum time in seconds a script is allowed to parse input data
	@ini_set( 'max_input_time', '-1' );

	// Set maximum backtracking steps
	@ini_set( 'pcre.backtrack_limit', PHP_INT_MAX );

	// Set binary safe encoding
	if ( @function_exists( 'mb_internal_encoding' ) && ( @ini_get( 'mbstring.func_overload' ) & 2 ) ) {
		@mb_internal_encoding( 'ISO-8859-1' );
	}

	// Clean (erase) the output buffer and turn off output buffering
	if ( @ob_get_length() ) {
		@ob_end_clean();
	}

	// Set error handler
	@set_error_handler( 'Cpiwm_Handler::error' );

	// Set shutdown handler
	@register_shutdown_function( 'Cpiwm_Handler::shutdown' );
}

/**
 * Get WordPress time zone string
 *
 * @return string
 */
function cpiwm_get_timezone_string() {
	if ( ( $timezone_string = get_option( 'timezone_string' ) ) ) {
		return $timezone_string;
	}

	if ( ( $gmt_offset = get_option( 'gmt_offset' ) ) ) {
		if ( $gmt_offset > 0 ) {
			return sprintf( 'UTC+%s', abs( $gmt_offset ) );
		} elseif ( $gmt_offset < 0 ) {
			return sprintf( 'UTC-%s', abs( $gmt_offset ) );
		}
	}

	return 'UTC';
}

/**
 * Get WordPress filter hooks
 *
 * @param  string $tag The name of the filter hook
 * @return array
 */
function cpiwm_get_filters( $tag ) {
	global $wp_filter;

	// Get WordPress filter hooks
	$filters = array();
	if ( isset( $wp_filter[ $tag ] ) ) {
		if ( ( $filters = $wp_filter[ $tag ] ) ) {
			// WordPress 4.7 introduces new class for working with filters/actions called WP_Hook
			// which adds another level of abstraction and we need to address it.
			if ( isset( $filters->callbacks ) ) {
				$filters = $filters->callbacks;
			}
		}

		ksort( $filters );
	}

	return $filters;
}

/**
 * Get WordPress uploads directory
 *
 * @return string
 */
function cpiwm_get_uploads_dir() {
	if ( ( $upload_dir = wp_upload_dir() ) ) {
		if ( isset( $upload_dir['basedir'] ) ) {
			return $upload_dir['basedir'];
		}
	}
}

/**
 * i18n friendly version of basename()
 *
 * @param  string $path   File path
 * @param  string $suffix If the filename ends in suffix this will also be cut off
 * @return string
 */
function cpiwm_basename( $path, $suffix = '' ) {
	return urldecode( basename( str_replace( array( '%2F', '%5C' ), '/', urlencode( $path ) ), $suffix ) );
}

/**
 * i18n friendly version of dirname()
 *
 * @param  string $path File path
 * @return string
 */
function cpiwm_dirname( $path ) {
	return urldecode( dirname( str_replace( array( '%2F', '%5C' ), '/', urlencode( $path ) ) ) );
}
