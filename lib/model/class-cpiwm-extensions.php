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

class Cpiwm_Extensions {

	/**
	 * Get active extensions
	 *
	 * @return array
	 */
	public static function get() {
		$extensions = array();

		// Add Microsoft Azure Extension
		if ( defined( 'CPIWMZE_PLUGIN_NAME' ) ) {
			$extensions[ CPIWMZE_PLUGIN_NAME ] = array(
				'key'      => CPIWMZE_PLUGIN_KEY,
				'title'    => CPIWMZE_PLUGIN_TITLE,
				'about'    => CPIWMZE_PLUGIN_ABOUT,
				'basename' => CPIWMZE_PLUGIN_BASENAME,
				'version'  => CPIWMZE_VERSION,
				'requires' => '1.19',
				'short'    => CPIWMZE_PLUGIN_SHORT,
			);
		}

		// Add Backblaze B2 Extension
		if ( defined( 'CPIWMAE_PLUGIN_NAME' ) ) {
			$extensions[ CPIWMAE_PLUGIN_NAME ] = array(
				'key'      => CPIWMAE_PLUGIN_KEY,
				'title'    => CPIWMAE_PLUGIN_TITLE,
				'about'    => CPIWMAE_PLUGIN_ABOUT,
				'basename' => CPIWMAE_PLUGIN_BASENAME,
				'version'  => CPIWMAE_VERSION,
				'requires' => '1.23',
				'short'    => CPIWMAE_PLUGIN_SHORT,
			);
		}

		// Add Box Extension
		if ( defined( 'CPIWMBE_PLUGIN_NAME' ) ) {
			$extensions[ CPIWMBE_PLUGIN_NAME ] = array(
				'key'      => CPIWMBE_PLUGIN_KEY,
				'title'    => CPIWMBE_PLUGIN_TITLE,
				'about'    => CPIWMBE_PLUGIN_ABOUT,
				'basename' => CPIWMBE_PLUGIN_BASENAME,
				'version'  => CPIWMBE_VERSION,
				'requires' => '1.31',
				'short'    => CPIWMBE_PLUGIN_SHORT,
			);
		}

		// Add DigitalOcean Spaces Extension
		if ( defined( 'CPIWMIE_PLUGIN_NAME' ) ) {
			$extensions[ CPIWMIE_PLUGIN_NAME ] = array(
				'key'      => CPIWMIE_PLUGIN_KEY,
				'title'    => CPIWMIE_PLUGIN_TITLE,
				'about'    => CPIWMIE_PLUGIN_ABOUT,
				'basename' => CPIWMIE_PLUGIN_BASENAME,
				'version'  => CPIWMIE_VERSION,
				'requires' => '1.30',
				'short'    => CPIWMIE_PLUGIN_SHORT,
			);
		}

		// Add Direct Extension
		if ( defined( 'CPIWMXE_PLUGIN_NAME' ) ) {
			$extensions[ CPIWMXE_PLUGIN_NAME ] = array(
				'key'      => CPIWMXE_PLUGIN_KEY,
				'title'    => CPIWMXE_PLUGIN_TITLE,
				'about'    => CPIWMXE_PLUGIN_ABOUT,
				'basename' => CPIWMXE_PLUGIN_BASENAME,
				'version'  => CPIWMXE_VERSION,
				'requires' => '1.0',
				'short'    => CPIWMXE_PLUGIN_SHORT,
			);
		}

		// Add Dropbox Extension
		if ( defined( 'CPIWMDE_PLUGIN_NAME' ) ) {
			$extensions[ CPIWMDE_PLUGIN_NAME ] = array(
				'key'      => CPIWMDE_PLUGIN_KEY,
				'title'    => CPIWMDE_PLUGIN_TITLE,
				'about'    => CPIWMDE_PLUGIN_ABOUT,
				'basename' => CPIWMDE_PLUGIN_BASENAME,
				'version'  => CPIWMDE_VERSION,
				'requires' => '3.50',
				'short'    => CPIWMDE_PLUGIN_SHORT,
			);
		}

		// Add File Extension
		if ( defined( 'CPIWMTE_PLUGIN_NAME' ) ) {
			$extensions[ CPIWMTE_PLUGIN_NAME ] = array(
				'key'      => CPIWMTE_PLUGIN_KEY,
				'title'    => CPIWMTE_PLUGIN_TITLE,
				'about'    => CPIWMTE_PLUGIN_ABOUT,
				'basename' => CPIWMTE_PLUGIN_BASENAME,
				'version'  => CPIWMTE_VERSION,
				'requires' => '1.5',
				'short'    => CPIWMTE_PLUGIN_SHORT,
			);
		}

		// Add FTP Extension
		if ( defined( 'CPIWMFE_PLUGIN_NAME' ) ) {
			$extensions[ CPIWMFE_PLUGIN_NAME ] = array(
				'key'      => CPIWMFE_PLUGIN_KEY,
				'title'    => CPIWMFE_PLUGIN_TITLE,
				'about'    => CPIWMFE_PLUGIN_ABOUT,
				'basename' => CPIWMFE_PLUGIN_BASENAME,
				'version'  => CPIWMFE_VERSION,
				'requires' => '2.55',
				'short'    => CPIWMFE_PLUGIN_SHORT,
			);
		}

		// Add Google Cloud Storage Extension
		if ( defined( 'CPIWMCE_PLUGIN_NAME' ) ) {
			$extensions[ CPIWMCE_PLUGIN_NAME ] = array(
				'key'      => CPIWMCE_PLUGIN_KEY,
				'title'    => CPIWMCE_PLUGIN_TITLE,
				'about'    => CPIWMCE_PLUGIN_ABOUT,
				'basename' => CPIWMCE_PLUGIN_BASENAME,
				'version'  => CPIWMCE_VERSION,
				'requires' => '1.20',
				'short'    => CPIWMCE_PLUGIN_SHORT,
			);
		}

		// Add Google Drive Extension
		if ( defined( 'CPIWMGE_PLUGIN_NAME' ) ) {
			$extensions[ CPIWMGE_PLUGIN_NAME ] = array(
				'key'      => CPIWMGE_PLUGIN_KEY,
				'title'    => CPIWMGE_PLUGIN_TITLE,
				'about'    => CPIWMGE_PLUGIN_ABOUT,
				'basename' => CPIWMGE_PLUGIN_BASENAME,
				'version'  => CPIWMGE_VERSION,
				'requires' => '2.54',
				'short'    => CPIWMGE_PLUGIN_SHORT,
			);
		}

		// Add Amazon Glacier Extension
		if ( defined( 'CPIWMRE_PLUGIN_NAME' ) ) {
			$extensions[ CPIWMRE_PLUGIN_NAME ] = array(
				'key'      => CPIWMRE_PLUGIN_KEY,
				'title'    => CPIWMRE_PLUGIN_TITLE,
				'about'    => CPIWMRE_PLUGIN_ABOUT,
				'basename' => CPIWMRE_PLUGIN_BASENAME,
				'version'  => CPIWMRE_VERSION,
				'requires' => '1.19',
				'short'    => CPIWMRE_PLUGIN_SHORT,
			);
		}

		// Add Mega Extension
		if ( defined( 'CPIWMEE_PLUGIN_NAME' ) ) {
			$extensions[ CPIWMEE_PLUGIN_NAME ] = array(
				'key'      => CPIWMEE_PLUGIN_KEY,
				'title'    => CPIWMEE_PLUGIN_TITLE,
				'about'    => CPIWMEE_PLUGIN_ABOUT,
				'basename' => CPIWMEE_PLUGIN_BASENAME,
				'version'  => CPIWMEE_VERSION,
				'requires' => '1.28',
				'short'    => CPIWMEE_PLUGIN_SHORT,
			);
		}

		// Add Multisite Extension
		if ( defined( 'CPIWMME_PLUGIN_NAME' ) ) {
			$extensions[ CPIWMME_PLUGIN_NAME ] = array(
				'key'      => CPIWMME_PLUGIN_KEY,
				'title'    => CPIWMME_PLUGIN_TITLE,
				'about'    => CPIWMME_PLUGIN_ABOUT,
				'basename' => CPIWMME_PLUGIN_BASENAME,
				'version'  => CPIWMME_VERSION,
				'requires' => '3.82',
				'short'    => CPIWMME_PLUGIN_SHORT,
			);
		}

		// Add OneDrive Extension
		if ( defined( 'CPIWMOE_PLUGIN_NAME' ) ) {
			$extensions[ CPIWMOE_PLUGIN_NAME ] = array(
				'key'      => CPIWMOE_PLUGIN_KEY,
				'title'    => CPIWMOE_PLUGIN_TITLE,
				'about'    => CPIWMOE_PLUGIN_ABOUT,
				'basename' => CPIWMOE_PLUGIN_BASENAME,
				'version'  => CPIWMOE_VERSION,
				'requires' => '1.42',
				'short'    => CPIWMOE_PLUGIN_SHORT,
			);
		}

		// Add pCloud Extension
		if ( defined( 'CPIWMPE_PLUGIN_NAME' ) ) {
			$extensions[ CPIWMPE_PLUGIN_NAME ] = array(
				'key'      => CPIWMPE_PLUGIN_KEY,
				'title'    => CPIWMPE_PLUGIN_TITLE,
				'about'    => CPIWMPE_PLUGIN_ABOUT,
				'basename' => CPIWMPE_PLUGIN_BASENAME,
				'version'  => CPIWMPE_VERSION,
				'requires' => '1.17',
				'short'    => CPIWMPE_PLUGIN_SHORT,
			);
		}

		// Add S3 Client Extension
		if ( defined( 'CPIWMNE_PLUGIN_NAME' ) ) {
			$extensions[ CPIWMNE_PLUGIN_NAME ] = array(
				'key'      => CPIWMNE_PLUGIN_KEY,
				'title'    => CPIWMNE_PLUGIN_TITLE,
				'about'    => CPIWMNE_PLUGIN_ABOUT,
				'basename' => CPIWMNE_PLUGIN_BASENAME,
				'version'  => CPIWMNE_VERSION,
				'requires' => '1.14',
				'short'    => CPIWMNE_PLUGIN_SHORT,
			);
		}

		// Add Amazon S3 Extension
		if ( defined( 'CPIWMSE_PLUGIN_NAME' ) ) {
			$extensions[ CPIWMSE_PLUGIN_NAME ] = array(
				'key'      => CPIWMSE_PLUGIN_KEY,
				'title'    => CPIWMSE_PLUGIN_TITLE,
				'about'    => CPIWMSE_PLUGIN_ABOUT,
				'basename' => CPIWMSE_PLUGIN_BASENAME,
				'version'  => CPIWMSE_VERSION,
				'requires' => '3.48',
				'short'    => CPIWMSE_PLUGIN_SHORT,
			);
		}

		// Add Unlimited Extension
		if ( defined( 'CPIWMUE_PLUGIN_NAME' ) ) {
			$extensions[ CPIWMUE_PLUGIN_NAME ] = array(
				'key'      => CPIWMUE_PLUGIN_KEY,
				'title'    => CPIWMUE_PLUGIN_TITLE,
				'about'    => CPIWMUE_PLUGIN_ABOUT,
				'basename' => CPIWMUE_PLUGIN_BASENAME,
				'version'  => CPIWMUE_VERSION,
				'requires' => '2.31',
				'short'    => CPIWMUE_PLUGIN_SHORT,
			);
		}

		// Add URL Extension
		if ( defined( 'CPIWMLE_PLUGIN_NAME' ) ) {
			$extensions[ CPIWMLE_PLUGIN_NAME ] = array(
				'key'      => CPIWMLE_PLUGIN_KEY,
				'title'    => CPIWMLE_PLUGIN_TITLE,
				'about'    => CPIWMLE_PLUGIN_ABOUT,
				'basename' => CPIWMLE_PLUGIN_BASENAME,
				'version'  => CPIWMLE_VERSION,
				'requires' => '2.41',
				'short'    => CPIWMLE_PLUGIN_SHORT,
			);
		}

		// Add WebDAV Extension
		if ( defined( 'CPIWMWE_PLUGIN_NAME' ) ) {
			$extensions[ CPIWMWE_PLUGIN_NAME ] = array(
				'key'      => CPIWMWE_PLUGIN_KEY,
				'title'    => CPIWMWE_PLUGIN_TITLE,
				'about'    => CPIWMWE_PLUGIN_ABOUT,
				'basename' => CPIWMWE_PLUGIN_BASENAME,
				'version'  => CPIWMWE_VERSION,
				'requires' => '1.16',
				'short'    => CPIWMWE_PLUGIN_SHORT,
			);
		}

		return $extensions;
	}
}
