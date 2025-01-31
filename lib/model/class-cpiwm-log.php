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

class Cpiwm_Log {

	public static function export( $params ) {
		$data = array();

		// Add date
		$data[] = date( 'M d Y H:i:s' );

		// Add params
		$data[] = json_encode( $params );

		// Add empty line
		$data[] = PHP_EOL;

		// Write log data
		if ( $handle = cpiwm_open( cpiwm_export_path( $params ), 'a' ) ) {
			cpiwm_write( $handle, implode( PHP_EOL, $data ) );
			cpiwm_close( $handle );
		}
	}

	public static function import( $params ) {
		$data = array();

		// Add date
		$data[] = date( 'M d Y H:i:s' );

		// Add params
		$data[] = json_encode( $params );

		// Add empty line
		$data[] = PHP_EOL;

		// Write log data
		if ( $handle = cpiwm_open( cpiwm_import_path( $params ), 'a' ) ) {
			cpiwm_write( $handle, implode( PHP_EOL, $data ) );
			cpiwm_close( $handle );
		}
	}

	public static function error( $params ) {
		$data = array();

		// Add date
		$data[] = date( 'M d Y H:i:s' );

		// Add params
		$data[] = json_encode( $params );

		// Add empty line
		$data[] = PHP_EOL;

		// Write log data
		if ( $handle = cpiwm_open( cpiwm_error_path(), 'a' ) ) {
			cpiwm_write( $handle, implode( PHP_EOL, $data ) );
			cpiwm_close( $handle );
		}
	}
}
