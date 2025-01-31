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

class Cpiwm_Import_Plugins {

	public static function execute( $params, $mysql = null ) {
		global $wpdb;

		// Set progress
		Cpiwm_Status::info( __( 'Preparing plugins...', CPIWM_PLUGIN_NAME ) );

		// Get database client
		if ( is_null( $mysql ) ) {
			if ( empty( $wpdb->use_mysqli ) ) {
				$mysql = new Cpiwm_Database_Mysql( $wpdb );
			} else {
				$mysql = new Cpiwm_Database_Mysqli( $wpdb );
			}
		}

		$tables = $mysql->get_tables();

		// Get base prefix
		$base_prefix = cpiwm_table_prefix();

		// Get mainsite prefix
		$mainsite_prefix = cpiwm_table_prefix( 'mainsite' );

		// Check WP sitemeta table exists
		if ( in_array( "{$mainsite_prefix}sitemeta", $tables ) ) {

			// Get fs_accounts option value (Freemius)
			$result = $mysql->query( "SELECT meta_value FROM `{$mainsite_prefix}sitemeta` WHERE meta_key = 'fs_accounts'" );
			if ( $row = $mysql->fetch_assoc( $result ) ) {
				$fs_accounts = get_option( 'fs_accounts', array() );
				$meta_value  = maybe_unserialize( $row['meta_value'] );

				// Update fs_accounts option value (Freemius)
				if ( ( $fs_accounts = array_merge( $fs_accounts, $meta_value ) ) ) {
					if ( isset( $fs_accounts['users'], $fs_accounts['sites'] ) ) {
						update_option( 'fs_accounts', $fs_accounts );
					} else {
						delete_option( 'fs_accounts' );
						delete_option( 'fs_dbg_accounts' );
						delete_option( 'fs_active_plugins' );
						delete_option( 'fs_api_cache' );
						delete_option( 'fs_dbg_api_cache' );
						delete_option( 'fs_debug_mode' );
					}
				}
			}
		}

		// Set progress
		Cpiwm_Status::info( __( 'Done preparing plugins.', CPIWM_PLUGIN_NAME ) );

		return $params;
	}
}
