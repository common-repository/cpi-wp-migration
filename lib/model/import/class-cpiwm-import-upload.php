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

class Cpiwm_Import_Upload {

	private static function validate() {
		if ( ! array_key_exists( 'upload-file', $_FILES ) || ! is_array( $_FILES['upload-file'] ) ) {
			throw new Cpiwm_Import_Retry_Exception( __( 'Missing upload file.', CPIWM_PLUGIN_NAME ), 400 );
		}

		if ( ! array_key_exists( 'error', $_FILES['upload-file'] ) ) {
			throw new Cpiwm_Import_Retry_Exception( __( 'Missing error key in upload file.', CPIWM_PLUGIN_NAME ), 400 );
		}

		if ( ! array_key_exists( 'tmp_name', $_FILES['upload-file'] ) ) {
			throw new Cpiwm_Import_Retry_Exception( __( 'Missing tmp_name in upload file.', CPIWM_PLUGIN_NAME ), 400 );
		}
	}

	public static function execute( $params ) {
		self::validate();

		$error   = $_FILES['upload-file']['error'];
		$upload  = $_FILES['upload-file']['tmp_name'];
		$archive = cpiwm_archive_path( $params );

		switch ( $error ) {
			case UPLOAD_ERR_OK:
				try {
					cpiwm_copy( $upload, $archive );
					cpiwm_unlink( $upload );
				} catch ( Exception $e ) {
					throw new Cpiwm_Import_Retry_Exception( sprintf( __( 'Unable to upload the file because %s', CPIWM_PLUGIN_NAME ), $e->getMessage() ), 400 );
				}
				break;

			case UPLOAD_ERR_INI_SIZE:
			case UPLOAD_ERR_FORM_SIZE:
			case UPLOAD_ERR_PARTIAL:
			case UPLOAD_ERR_NO_FILE:
				// File is too large
				throw new Cpiwm_Import_Retry_Exception( __( 'The file is too large for this server.', CPIWM_PLUGIN_NAME ), 413 );

			case UPLOAD_ERR_NO_TMP_DIR:
				throw new Cpiwm_Import_Retry_Exception( __( 'Missing a temporary folder.', CPIWM_PLUGIN_NAME ), 400 );

			case UPLOAD_ERR_CANT_WRITE:
				throw new Cpiwm_Import_Retry_Exception( __( 'Failed to write file to disk.', CPIWM_PLUGIN_NAME ), 400 );

			case UPLOAD_ERR_EXTENSION:
				throw new Cpiwm_Import_Retry_Exception( __( 'A PHP extension stopped the file upload.', CPIWM_PLUGIN_NAME ), 400 );

			default:
				throw new Cpiwm_Import_Retry_Exception( sprintf( __( 'Unrecognized error %s during upload.', CPIWM_PLUGIN_NAME ), $error ), 400 );
		}

		echo json_encode( array( 'errors' => array() ) );
		exit;
	}
}
