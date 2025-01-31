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

class Cpiwm_Export_Config {

	public static function execute( $params ) {
		global $table_prefix, $wp_version, $wpdb;

		// Set progress
		Cpiwm_Status::info( __( 'Preparing configuration file...', CPIWM_PLUGIN_NAME ) );

		// Get options
		$options = wp_load_alloptions();

		// Get database client
		if ( empty( $wpdb->use_mysqli ) ) {
			$mysql = new Cpiwm_Database_Mysql( $wpdb );
		} else {
			$mysql = new Cpiwm_Database_Mysqli( $wpdb );
		}

		$config = array();

		// Set site URL
		$config['SiteURL'] = site_url();

		// Set home URL
		$config['HomeURL'] = home_url();

		// Set internal site URL
		if ( isset( $options['siteurl'] ) && ( untrailingslashit( $options['siteurl'] ) !== site_url() ) ) {
			$config['InternalSiteURL'] = untrailingslashit( $options['siteurl'] );
		}

		// Set internal home URL
		if ( isset( $options['home'] ) && ( untrailingslashit( $options['home'] ) !== home_url() ) ) {
			$config['InternalHomeURL'] = untrailingslashit( $options['home'] );
		}

		// Set replace old and new values
		if ( isset( $params['options']['replace'] ) && ( $replace = $params['options']['replace'] ) ) {
			for ( $i = 0; $i < count( $replace['old_value'] ); $i++ ) {
				if ( ! empty( $replace['old_value'][ $i ] ) && ! empty( $replace['new_value'][ $i ] ) ) {
					$config['Replace']['OldValues'][] = $replace['old_value'][ $i ];
					$config['Replace']['NewValues'][] = $replace['new_value'][ $i ];
				}
			}
		}

		// Set no spam comments
		if ( isset( $params['options']['no_spam_comments'] ) ) {
			$config['NoSpamComments'] = true;
		}

		// Set no post revisions
		if ( isset( $params['options']['no_post_revisions'] ) ) {
			$config['NoPostRevisions'] = true;
		}

		// Set no media
		if ( isset( $params['options']['no_media'] ) ) {
			$config['NoMedia'] = true;
		}

		// Set no themes
		if ( isset( $params['options']['no_themes'] ) ) {
			$config['NoThemes'] = true;
		}

		// Set no inactive themes
		if ( isset( $params['options']['no_inactive_themes'] ) ) {
			$config['NoInactiveThemes'] = true;
		}

		// Set no must-use plugins
		if ( isset( $params['options']['no_muplugins'] ) ) {
			$config['NoMustUsePlugins'] = true;
		}

		// Set no plugins
		if ( isset( $params['options']['no_plugins'] ) ) {
			$config['NoPlugins'] = true;
		}

		// Set no inactive plugins
		if ( isset( $params['options']['no_inactive_plugins'] ) ) {
			$config['NoInactivePlugins'] = true;
		}

		// Set no cache
		if ( isset( $params['options']['no_cache'] ) ) {
			$config['NoCache'] = true;
		}

		// Set no database
		if ( isset( $params['options']['no_database'] ) ) {
			$config['NoDatabase'] = true;
		}

		// Set no email replace
		if ( isset( $params['options']['no_email_replace'] ) ) {
			$config['NoEmailReplace'] = true;
		}

		// Set plugin version
		$config['Plugin'] = array( 'Version' => CPIWM_VERSION );

		// Set WordPress version and content
		$config['WordPress'] = array( 'Version' => $wp_version, 'Content' => WP_CONTENT_DIR, 'Plugins' => WP_PLUGIN_DIR, 'Themes' => get_theme_root(), 'Uploads' => cpiwm_get_uploads_dir() );

		// Set database version
		$config['Database'] = array( 'Version' => $mysql->version(), 'Charset' => DB_CHARSET, 'Collate' => DB_COLLATE, 'Prefix' => $table_prefix );

		// Set PHP version
		$config['PHP'] = array( 'Version' => PHP_VERSION, 'System' => PHP_OS, 'Integer' => PHP_INT_SIZE );

		// Set active plugins
		$config['Plugins'] = array_values( array_diff( cpiwm_active_plugins(), cpiwm_active_servmask_plugins() ) );

		// Set active template
		$config['Template'] = cpiwm_active_template();

		// Set active stylesheet
		$config['Stylesheet'] = cpiwm_active_stylesheet();

		// Save package.json file
		$handle = cpiwm_open( cpiwm_package_path( $params ), 'w' );
		cpiwm_write( $handle, json_encode( $config ) );
		cpiwm_close( $handle );

		// Set progress
		Cpiwm_Status::info( __( 'Done preparing configuration file.', CPIWM_PLUGIN_NAME ) );

		return $params;
	}
}
