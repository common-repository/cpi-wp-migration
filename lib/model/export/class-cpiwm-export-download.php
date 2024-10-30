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

class Cpiwm_Export_Download {

	public static function execute( $params ) {

		// Set progress
		Cpiwm_Status::info( __( 'Renaming exported file...', CPIWM_PLUGIN_NAME ) );

		// Open the archive file for writing
		$archive = new Cpiwm_Compressor( cpiwm_archive_path( $params ) );

		// Append EOF block
		$archive->close( true );

		// Rename archive file
		if ( rename( cpiwm_archive_path( $params ), cpiwm_backup_path( $params ) ) ) {

			$blog_id = null;

			// Get subsite Blog ID
			if ( isset( $params['options']['sites'] ) && ( $sites = $params['options']['sites'] ) ) {
				if ( count( $sites ) === 1 ) {
					$blog_id = array_shift( $sites );
				}
			}

			// Set archive details
			$file = cpiwm_archive_name( $params );
			$link = cpiwm_backup_url( $params );
			$size = cpiwm_backup_size( $params );
			$name = cpiwm_site_name( $blog_id );

			// Set progress
			Cpiwm_Status::download(
				sprintf(
					__(
						'<a href="%s" class="cpiwm-button-green cpiwm-emphasize cpiwm-button-download" title="%s" download="%s">' .
						'<span>Download %s</span>' .
						'<em>Size: %s</em>' .
						'</a>',
						CPIWM_PLUGIN_NAME
					),
					$link,
					$name,
					$file,
					$name,
					$size
				)
			);
		}

		return $params;
	}
}
