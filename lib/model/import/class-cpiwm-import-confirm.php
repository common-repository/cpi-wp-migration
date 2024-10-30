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

class Cpiwm_Import_Confirm {

	public static function execute( $params ) {

		$messages = array();

		// Read package.json file
		$handle = cpiwm_open( cpiwm_package_path( $params ), 'r' );

		// Parse package.json file
		$package = cpiwm_read( $handle, filesize( cpiwm_package_path( $params ) ) );
		$package = json_decode( $package, true );

		// Close handle
		cpiwm_close( $handle );

		// Confirm message
		if ( defined( 'WP_CLI' ) ) {
			$messages[] = __(
				'The import process will overwrite your website including the database, media, plugins, and themes. ' .
				'Are you sure to proceed?',
				CPIWM_PLUGIN_NAME
			);
		} else {
			$messages[] = __(
				'The import process will overwrite your website including the database, media, plugins, and themes. ' .
				'Please ensure that you have a backup of your data before proceeding to the next step.',
				CPIWM_PLUGIN_NAME
			);
		}

		// Check compatibility of PHP versions
		if ( isset( $package['PHP']['Version'] ) ) {
			if ( version_compare( $package['PHP']['Version'], '7.0.0', '<' ) && version_compare( PHP_VERSION, '7.0.0', '>=' ) ) {
				if ( defined( 'WP_CLI' ) ) {
					$messages[] = __(
						'Your backup is from a PHP 5 but the site that you are importing to is PHP 7. ' .
						'This could cause the import to fail.',
						CPIWM_PLUGIN_NAME
					);
				} else {
					$messages[] = __(
						'<i class="cpiwm-import-info">Your backup is from a PHP 5 but the site that you are importing to is PHP 7. ' .
						'This could cause the import to fail. <a href="#" target="_blank">Technical details</a></i>',
						CPIWM_PLUGIN_NAME
					);
				}
			}
		}

		if ( defined( 'WP_CLI' ) ) {
			$assoc_args = array();
			if ( isset( $params['cli_args'] ) ) {
				$assoc_args = $params['cli_args'];
			}

			WP_CLI::confirm( implode( $messages ), $assoc_args );

			return $params;
		}

		// Set progress
		Cpiwm_Status::confirm( implode( $messages ) );
		exit;
	}
}
