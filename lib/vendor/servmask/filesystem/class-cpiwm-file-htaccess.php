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

class Cpiwm_File_Htaccess {

	/**
	 * Create .htaccess file (ServMask)
	 *
	 * @param  string  $path Path to file
	 * @return boolean
	 */
	public static function create( $path ) {
		return Cpiwm_File::create(
			$path,
			implode(
				PHP_EOL,
				array(
					'<IfModule mod_mime.c>',
					'AddType application/octet-stream .wpress',
					'</IfModule>',
					'<IfModule mod_dir.c>',
					'DirectoryIndex index.php',
					'</IfModule>',
					'<IfModule mod_autoindex.c>',
					'Options -Indexes',
					'</IfModule>',
				)
			)
		);
	}

	/**
	 * Create .htaccess file (LiteSpeed)
	 *
	 * @param  string  $path Path to file
	 * @return boolean
	 */
	public static function litespeed( $path ) {
		return Cpiwm_File::create_with_markers(
			$path,
			'LiteSpeed',
			array(
				'<IfModule Litespeed>',
				'SetEnv noabort 1',
				'</IfModule>',
			)
		);
	}
}
