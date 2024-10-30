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

class Cpiwm_Import_Done {

	public static function execute( $params ) {

		// Check multisite.json file
		if ( true === is_file( cpiwm_multisite_path( $params ) ) ) {

			// Read multisite.json file
			$handle = cpiwm_open( cpiwm_multisite_path( $params ), 'r' );

			// Parse multisite.json file
			$multisite = cpiwm_read( $handle, filesize( cpiwm_multisite_path( $params ) ) );
			$multisite = json_decode( $multisite, true );

			// Close handle
			cpiwm_close( $handle );

			// Activate WordPress plugins
			if ( isset( $multisite['Plugins'] ) && ( $plugins = $multisite['Plugins'] ) ) {
				cpiwm_activate_plugins( $plugins );
			}

			// Deactivate WordPress SSL plugins
			if ( ! is_ssl() ) {
				cpiwm_deactivate_plugins(
					array(
						cpiwm_discover_plugin_basename( 'really-simple-ssl/rlrsssl-really-simple-ssl.php' ),
						cpiwm_discover_plugin_basename( 'wordpress-https/wordpress-https.php' ),
						cpiwm_discover_plugin_basename( 'wp-force-ssl/wp-force-ssl.php' ),
						cpiwm_discover_plugin_basename( 'force-https-littlebizzy/force-https.php' ),
					)
				);
			}

			// Deactivate WordPress plugins
			cpiwm_deactivate_plugins(
				array(
					cpiwm_discover_plugin_basename( 'invisible-recaptcha/invisible-recaptcha.php' ),
					cpiwm_discover_plugin_basename( 'wps-hide-login/wps-hide-login.php' ),
					cpiwm_discover_plugin_basename( 'hide-my-wp/index.php' ),
					cpiwm_discover_plugin_basename( 'hide-my-wordpress/index.php' ),
					cpiwm_discover_plugin_basename( 'mycustomwidget/my_custom_widget.php' ),
					cpiwm_discover_plugin_basename( 'lockdown-wp-admin/lockdown-wp-admin.php' ),
					cpiwm_discover_plugin_basename( 'rename-wp-login/rename-wp-login.php' ),
					cpiwm_discover_plugin_basename( 'wp-simple-firewall/icwp-wpsf.php' ),
					cpiwm_discover_plugin_basename( 'join-my-multisite/joinmymultisite.php' ),
					cpiwm_discover_plugin_basename( 'multisite-clone-duplicator/multisite-clone-duplicator.php' ),
					cpiwm_discover_plugin_basename( 'wordpress-mu-domain-mapping/domain_mapping.php' ),
					cpiwm_discover_plugin_basename( 'pro-sites/pro-sites.php' ),
				)
			);

			// Deactivate Revolution Slider
			cpiwm_deactivate_revolution_slider( cpiwm_discover_plugin_basename( 'revslider/revslider.php' ) );

			// Deactivate Jetpack modules
			cpiwm_deactivate_jetpack_modules( array( 'photon', 'sso' ) );

			// Flush Elementor cache
			cpiwm_elementor_cache_flush();

		} else {

			// Check package.json file
			if ( true === is_file( cpiwm_package_path( $params ) ) ) {

				// Read package.json file
				$handle = cpiwm_open( cpiwm_package_path( $params ), 'r' );

				// Parse package.json file
				$package = cpiwm_read( $handle, filesize( cpiwm_package_path( $params ) ) );
				$package = json_decode( $package, true );

				// Close handle
				cpiwm_close( $handle );

				// Activate WordPress plugins
				if ( isset( $package['Plugins'] ) && ( $plugins = $package['Plugins'] ) ) {
					cpiwm_activate_plugins( $plugins );
				}

				// Activate WordPress template
				if ( isset( $package['Template'] ) && ( $template = $package['Template'] ) ) {
					cpiwm_activate_template( $template );
				}

				// Activate WordPress stylesheet
				if ( isset( $package['Stylesheet'] ) && ( $stylesheet = $package['Stylesheet'] ) ) {
					cpiwm_activate_stylesheet( $stylesheet );
				}

				// Deactivate WordPress SSL plugins
				if ( ! is_ssl() ) {
					cpiwm_deactivate_plugins(
						array(
							cpiwm_discover_plugin_basename( 'really-simple-ssl/rlrsssl-really-simple-ssl.php' ),
							cpiwm_discover_plugin_basename( 'wordpress-https/wordpress-https.php' ),
							cpiwm_discover_plugin_basename( 'wp-force-ssl/wp-force-ssl.php' ),
							cpiwm_discover_plugin_basename( 'force-https-littlebizzy/force-https.php' ),
						)
					);
				}

				// Deactivate WordPress plugins
				cpiwm_deactivate_plugins(
					array(
						cpiwm_discover_plugin_basename( 'invisible-recaptcha/invisible-recaptcha.php' ),
						cpiwm_discover_plugin_basename( 'wps-hide-login/wps-hide-login.php' ),
						cpiwm_discover_plugin_basename( 'hide-my-wp/index.php' ),
						cpiwm_discover_plugin_basename( 'hide-my-wordpress/index.php' ),
						cpiwm_discover_plugin_basename( 'mycustomwidget/my_custom_widget.php' ),
						cpiwm_discover_plugin_basename( 'lockdown-wp-admin/lockdown-wp-admin.php' ),
						cpiwm_discover_plugin_basename( 'rename-wp-login/rename-wp-login.php' ),
						cpiwm_discover_plugin_basename( 'wp-simple-firewall/icwp-wpsf.php' ),
						cpiwm_discover_plugin_basename( 'join-my-multisite/joinmymultisite.php' ),
						cpiwm_discover_plugin_basename( 'multisite-clone-duplicator/multisite-clone-duplicator.php' ),
						cpiwm_discover_plugin_basename( 'wordpress-mu-domain-mapping/domain_mapping.php' ),
						cpiwm_discover_plugin_basename( 'pro-sites/pro-sites.php' ),
					)
				);

				// Deactivate Revolution Slider
				cpiwm_deactivate_revolution_slider( cpiwm_discover_plugin_basename( 'revslider/revslider.php' ) );

				// Deactivate Jetpack modules
				cpiwm_deactivate_jetpack_modules( array( 'photon', 'sso' ) );

				// Flush Elementor cache
				cpiwm_elementor_cache_flush();
			}
		}

		// Check blogs.json file
		if ( true === is_file( cpiwm_blogs_path( $params ) ) ) {

			// Read blogs.json file
			$handle = cpiwm_open( cpiwm_blogs_path( $params ), 'r' );

			// Parse blogs.json file
			$blogs = cpiwm_read( $handle, filesize( cpiwm_blogs_path( $params ) ) );
			$blogs = json_decode( $blogs, true );

			// Close handle
			cpiwm_close( $handle );

			// Loop over blogs
			foreach ( $blogs as $blog ) {

				// Activate WordPress plugins
				if ( isset( $blog['New']['Plugins'] ) && ( $plugins = $blog['New']['Plugins'] ) ) {
					cpiwm_activate_plugins( $plugins );
				}

				// Activate WordPress template
				if ( isset( $blog['New']['Template'] ) && ( $template = $blog['New']['Template'] ) ) {
					cpiwm_activate_template( $template );
				}

				// Activate WordPress stylesheet
				if ( isset( $blog['New']['Stylesheet'] ) && ( $stylesheet = $blog['New']['Stylesheet'] ) ) {
					cpiwm_activate_stylesheet( $stylesheet );
				}

				// Deactivate WordPress SSL plugins
				if ( ! is_ssl() ) {
					cpiwm_deactivate_plugins(
						array(
							cpiwm_discover_plugin_basename( 'really-simple-ssl/rlrsssl-really-simple-ssl.php' ),
							cpiwm_discover_plugin_basename( 'wordpress-https/wordpress-https.php' ),
							cpiwm_discover_plugin_basename( 'wp-force-ssl/wp-force-ssl.php' ),
							cpiwm_discover_plugin_basename( 'force-https-littlebizzy/force-https.php' ),
						)
					);
				}

				// Deactivate WordPress plugins
				cpiwm_deactivate_plugins(
					array(
						cpiwm_discover_plugin_basename( 'invisible-recaptcha/invisible-recaptcha.php' ),
						cpiwm_discover_plugin_basename( 'wps-hide-login/wps-hide-login.php' ),
						cpiwm_discover_plugin_basename( 'hide-my-wp/index.php' ),
						cpiwm_discover_plugin_basename( 'hide-my-wordpress/index.php' ),
						cpiwm_discover_plugin_basename( 'mycustomwidget/my_custom_widget.php' ),
						cpiwm_discover_plugin_basename( 'lockdown-wp-admin/lockdown-wp-admin.php' ),
						cpiwm_discover_plugin_basename( 'rename-wp-login/rename-wp-login.php' ),
						cpiwm_discover_plugin_basename( 'wp-simple-firewall/icwp-wpsf.php' ),
						cpiwm_discover_plugin_basename( 'join-my-multisite/joinmymultisite.php' ),
						cpiwm_discover_plugin_basename( 'multisite-clone-duplicator/multisite-clone-duplicator.php' ),
						cpiwm_discover_plugin_basename( 'wordpress-mu-domain-mapping/domain_mapping.php' ),
						cpiwm_discover_plugin_basename( 'pro-sites/pro-sites.php' ),
					)
				);

				// Deactivate Revolution Slider
				cpiwm_deactivate_revolution_slider( cpiwm_discover_plugin_basename( 'revslider/revslider.php' ) );

				// Deactivate Jetpack modules
				cpiwm_deactivate_jetpack_modules( array( 'photon', 'sso' ) );

				// Flush Elementor cache
				cpiwm_elementor_cache_flush();
			}
		}

		// Set progress
		Cpiwm_Status::done(
			__(
				'Your site has been imported successfully!',
				CPIWM_PLUGIN_NAME
			),
			sprintf(
				__(
					'',
					CPIWM_PLUGIN_NAME
				),
				admin_url( 'options-permalink.php#submit' )
			)
		);

		return $params;
	}
}
