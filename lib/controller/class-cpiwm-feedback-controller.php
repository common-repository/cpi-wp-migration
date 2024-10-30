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

class Cpiwm_Feedback_Controller {

	public static function feedback( $params = array() ) {
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

		// Set type
		$type = null;
		if ( isset( $params['cpiwm_type'] ) ) {
			$type = trim( $params['cpiwm_type'] );
		}

		// Set e-mail
		$email = null;
		if ( isset( $params['cpiwm_email'] ) ) {
			$email = trim( $params['cpiwm_email'] );
		}

		// Set message
		$message = null;
		if ( isset( $params['cpiwm_message'] ) ) {
			$message = trim( $params['cpiwm_message'] );
		}

		// Set terms
		$terms = false;
		if ( isset( $params['cpiwm_terms'] ) ) {
			$terms = (bool) $params['cpiwm_terms'];
		}

		try {
			// Ensure that unauthorized people cannot access feedback action
			cpiwm_verify_secret_key( $secret_key );
		} catch ( Cpiwm_Not_Valid_Secret_Key_Exception $e ) {
			exit;
		}

		$extensions = Cpiwm_Extensions::get();

		// Exclude File Extension
		if ( defined( 'CPIWMTE_PLUGIN_NAME' ) ) {
			unset( $extensions[ CPIWMTE_PLUGIN_NAME ] );
		}

		$purchases = array();
		foreach ( $extensions as $extension ) {
			if ( ( $uuid = get_option( $extension['key'] ) ) ) {
				$purchases[] = $uuid;
			}
		}

		try {
			Cpiwm_Feedback::add( $type, $email, $message, $terms, implode( PHP_EOL, $purchases ) );
		} catch ( Cpiwm_Feedback_Exception $e ) {
			echo json_encode( array( 'errors' => array( $e->getMessage() ) ) );
			exit;
		}

		echo json_encode( array( 'errors' => array() ) );
		exit;
	}
}
