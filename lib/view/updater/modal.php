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
?>

<div id="cpiwm-modal-dialog-<?php echo esc_attr( $modal ); ?>" class="cpiwm-modal-dialog">
	<div class="cpiwm-modal-container" role="dialog">
		<h2><?php _e( 'Enter your Purchase ID', CPIWM_PLUGIN_NAME ); ?></h2>
		<p><?php _e( 'To update your plugin/extension to the latest version, please fill your Purchase ID below.', CPIWM_PLUGIN_NAME ); ?></p>
		<p class="cpiwm-modal-error"></p>
		<p>
			<input type="text" class="cpiwm-purchase-id" placeholder="<?php _e( 'Purchase ID', CPIWM_PLUGIN_NAME ); ?>" />
			<input type="hidden" class="cpiwm-update-link" value="<?php echo esc_url( $url ); ?>" />
		</p>
		<p>
			<?php _e( "Don't have a Purchase ID? You can find your Purchase ID", CPIWM_PLUGIN_NAME ); ?>
			<a href="#" target="_blank" class="cpiwm-help-link"><?php _e( 'here', CPIWM_PLUGIN_NAME ); ?></a>
		</p>
		<p class="cpiwm-modal-buttons submitbox">
			<button type="button" class="cpiwm-purchase-add cpiwm-button-green">
				<?php _e( 'Save', CPIWM_PLUGIN_NAME ); ?>
			</button>
			<a href="#" class="submitdelete cpiwm-purchase-discard"><?php _e( 'Discard', CPIWM_PLUGIN_NAME ); ?></a>
		</p>
	</div>
</div>

<span id="cpiwm-update-section-<?php echo esc_attr( $modal ); ?>">
	<i class="cpiwm-icon-update"></i>
	<?php _e( 'There is an update available. To update, you must enter your', CPIWM_PLUGIN_NAME ); ?>
	<a href="#cpiwm-modal-dialog-<?php echo esc_attr( $modal ); ?>"><?php _e( 'Purchase ID', CPIWM_PLUGIN_NAME ); ?></a>.
</span>
