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

class Cpiwm_Compatibility {

	public static function get( $params ) {
		$extensions = Cpiwm_Extensions::get();

		foreach ( $extensions as $extension_name => $extension_data ) {
			if ( ! isset( $params[ $extension_data['short'] ] ) ) {
				unset( $extensions[ $extension_name ] );
			}
		}

		// Get updater URL
		$updater_url = add_query_arg( array( 'cpiwm_check_for_updates' => 1, 'cpiwm_nonce' => wp_create_nonce( 'cpiwm_check_for_updates' ) ), network_admin_url( 'plugins.php' ) );

		// If no extension is used, update everything that is available
		if ( empty( $extensions ) ) {
			$extensions = Cpiwm_Extensions::get();
		}

		$messages = array();
		foreach ( $extensions as $extension_name => $extension_data ) {
			if ( ! Cpiwm_Compatibility::check( $extension_data ) ) {
				if ( defined( 'WP_CLI' ) ) {
					$messages[] = sprintf( __( '%s is not the latest version. You must update the plugin before you can use it. ', CPIWM_PLUGIN_NAME ), $extension_data['title'] );
				} else {
					$messages[] = sprintf( __( '<strong>%s</strong> is not the latest version. You must <a href="%s">update the plugin</a> before you can use it. <br />', CPIWM_PLUGIN_NAME ), $extension_data['title'], $updater_url );
				}
			}
		}

		return $messages;
	}

	public static function check( $extension ) {
		if ( $extension['version'] !== 'develop' ) {
			if ( version_compare( $extension['version'], $extension['requires'], '<' ) ) {
				return false;
			}
		}

		return true;
	}
}
