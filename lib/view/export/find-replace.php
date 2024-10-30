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

<ul id="cpiwm-queries">
	<li class="cpiwm-query cpiwm-expandable">
		<p>
			<span>
				<strong><?php _e( 'Find', CPIWM_PLUGIN_NAME ); ?></strong>
				<small class="cpiwm-query-find-text cpiwm-tooltip" title="Search the database for this text"><?php echo esc_html( __( '<text>', CPIWM_PLUGIN_NAME ) ); ?></small>
				<strong><?php _e( 'Replace with', CPIWM_PLUGIN_NAME ); ?></strong>
				<small class="cpiwm-query-replace-text cpiwm-tooltip" title="Replace the database with this text"><?php echo esc_html( __( '<another-text>', CPIWM_PLUGIN_NAME ) ); ?></small>
				<strong><?php _e( 'in the database', CPIWM_PLUGIN_NAME ); ?></strong>
			</span>
			<span class="cpiwm-query-arrow cpiwm-icon-chevron-right"></span>
		</p>
		<div>
			<input class="cpiwm-query-find-input" type="text" placeholder="<?php _e( 'Find', CPIWM_PLUGIN_NAME ); ?>" name="options[replace][old_value][]" />
			<input class="cpiwm-query-replace-input" type="text" placeholder="<?php _e( 'Replace with', CPIWM_PLUGIN_NAME ); ?>" name="options[replace][new_value][]" />
		</div>
	</li>
</ul>
