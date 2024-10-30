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

class Cpiwm_Report {

	/**
	 * Submit customer report to servmask.com
	 *
	 * @param  string  $email   User e-mail
	 * @param  string  $message User message
	 * @param  integer $terms   User accept terms
	 *
	 * @return array
	 */
	public static function add( $email, $message, $terms ) {
		// Validate email
		if ( filter_var( $email, FILTER_VALIDATE_EMAIL ) === false ) {
			throw new Cpiwm_Report_Exception( __( 'Your email is not valid.', CPIWM_PLUGIN_NAME ) );
		}

		// Validate message
		if ( empty( $message ) ) {
			throw new Cpiwm_Report_Exception( __( 'Please enter comments in the text area.', CPIWM_PLUGIN_NAME ) );
		}

		// Validate terms
		if ( empty( $terms ) ) {
			throw new Cpiwm_Report_Exception( __( 'Please accept report term conditions.', CPIWM_PLUGIN_NAME ) );
		}

		$response = wp_remote_post(
			CPIWM_REPORT_URL,
			array(
				'timeout' => 15,
				'body'    => array(
					'email'   => $email,
					'message' => $message,
				),
			)
		);

		if ( is_wp_error( $response ) ) {
			throw new Cpiwm_Report_Exception( sprintf( __( 'Something went wrong: %s', CPIWM_PLUGIN_NAME ), $response->get_error_message() ) );
		}

		return $response;
	}
}
