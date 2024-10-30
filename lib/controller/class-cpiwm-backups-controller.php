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

class Cpiwm_Backups_Controller {

	public static function index() {
        if (get_bloginfo('version') < 4.9) {
            die('<h3 style="color:red;">' . __('Please upgrade WordPress to version 4.9 or higher', CPIWM_PLUGIN_NAME) . '</h3>');
        }
		Cpiwm_Template::render(
			'backups/index',
			array(
				'backups'  => Cpiwm_Backups::get_files(),
				'labels'   => Cpiwm_Backups::get_labels(),
				'username' => get_option( CPIWM_AUTH_USER ),
				'password' => get_option( CPIWM_AUTH_PASSWORD ),
			)
		);
	}

	public static function delete( $params = array() ) {
		cpiwm_setup_environment();

		// Set params
		if ( empty( $params ) ) {
			$params = stripslashes_deep( $_POST );
		}

		// Set secret key
		$secret_key = null;
		if ( isset( $params['secret_key'] ) ) {
			$secret_key = trim( $params['secret_key'] );
		}

		// Set archive
		$archive = null;
		if ( isset( $params['archive'] ) ) {
			$archive = trim( $params['archive'] );
		}

		try {
			// Ensure that unauthorized people cannot access delete action
			cpiwm_verify_secret_key( $secret_key );
		} catch ( Cpiwm_Not_Valid_Secret_Key_Exception $e ) {
			exit;
		}

		try {
			Cpiwm_Backups::delete_file( $archive );
			Cpiwm_Backups::delete_label( $archive );
		} catch ( Cpiwm_Backups_Exception $e ) {
			echo json_encode( array( 'errors' => array( $e->getMessage() ) ) );
			exit;
		}

		echo json_encode( array( 'errors' => array() ) );
		exit;
	}

	public static function add_label( $params = array() ) {
		cpiwm_setup_environment();

		// Set params
		if ( empty( $params ) ) {
			$params = stripslashes_deep( $_POST );
		}

		// Set secret key
		$secret_key = null;
		if ( isset( $params['secret_key'] ) ) {
			$secret_key = trim( $params['secret_key'] );
		}

		// Set archive
		$archive = null;
		if ( isset( $params['archive'] ) ) {
			$archive = trim( $params['archive'] );
		}

		// Set backup label
		$label = null;
		if ( isset( $params['label'] ) ) {
			$label = trim( $params['label'] );
		}

		try {
			// Ensure that unauthorized people cannot access add label action
			cpiwm_verify_secret_key( $secret_key );
		} catch ( Cpiwm_Not_Valid_Secret_Key_Exception $e ) {
			exit;
		}

		try {
			Cpiwm_Backups::set_label( $archive, $label );
		} catch ( Cpiwm_Backups_Exception $e ) {
			echo json_encode( array( 'errors' => array( $e->getMessage() ) ) );
			exit;
		}

		echo json_encode( array( 'errors' => array() ) );
		exit;
	}

	public static function backup_list( $params = array() ) {
		cpiwm_setup_environment();

		// Set params
		if ( empty( $params ) ) {
			$params = stripslashes_deep( $_GET );
		}

		// Set secret key
		$secret_key = null;
		if ( isset( $params['secret_key'] ) ) {
			$secret_key = trim( $params['secret_key'] );
		}

		try {
			// Ensure that unauthorized people cannot access backups list action
			cpiwm_verify_secret_key( $secret_key );
		} catch ( Cpiwm_Not_Valid_Secret_Key_Exception $e ) {
			exit;
		}

		Cpiwm_Template::render(
			'backups/backups-list',
			array(
				'backups' => Cpiwm_Backups::get_files(),
				'labels'  => Cpiwm_Backups::get_labels(),
			)
		);
		exit;
	}
}
