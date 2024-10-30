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

<div class="cpiwm-field-set">
	<div class="cpiwm-accordion cpiwm-expandable">
		<ul>
			<li>
				<label for="cpiwm-no-spam-comments">
					<input type="checkbox" id="cpiwm-no-spam-comments" name="options[no_spam_comments]" />
					<?php _e( 'Do <strong>not</strong> export spam comments', CPIWM_PLUGIN_NAME ); ?>
				</label>
			</li>
			<li>
				<label for="cpiwm-no-post-revisions">
					<input type="checkbox" id="cpiwm-no-post-revisions" name="options[no_post_revisions]" />
					<?php _e( 'Do <strong>not</strong> export post revisions', CPIWM_PLUGIN_NAME ); ?>
				</label>
			</li>
			<li>
				<label for="cpiwm-no-media">
					<input type="checkbox" id="cpiwm-no-media" name="options[no_media]" />
					<?php _e( 'Do <strong>not</strong> export media library (files)', CPIWM_PLUGIN_NAME ); ?>
				</label>
			</li>
			<li>
				<label for="cpiwm-no-themes">
					<input type="checkbox" id="cpiwm-no-themes" name="options[no_themes]" />
					<?php _e( 'Do <strong>not</strong> export themes (files)', CPIWM_PLUGIN_NAME ); ?>
				</label>
			</li>

			<?php do_action( 'cpiwm_export_inactive_themes' ); ?>

			<li>
				<label for="cpiwm-no-muplugins">
					<input type="checkbox" id="cpiwm-no-muplugins" name="options[no_muplugins]" />
					<?php _e( 'Do <strong>not</strong> export must-use plugins (files)', CPIWM_PLUGIN_NAME ); ?>
				</label>
			</li>

			<li>
				<label for="cpiwm-no-plugins">
					<input type="checkbox" id="cpiwm-no-plugins" name="options[no_plugins]" />
					<?php _e( 'Do <strong>not</strong> export plugins (files)', CPIWM_PLUGIN_NAME ); ?>
				</label>
			</li>

			<?php do_action( 'cpiwm_export_inactive_plugins' ); ?>

			<?php do_action( 'cpiwm_export_cache_files' ); ?>

			<li>
				<label for="cpiwm-no-database">
					<input type="checkbox" id="cpiwm-no-database" name="options[no_database]" />
					<?php _e( 'Do <strong>not</strong> export database (sql)', CPIWM_PLUGIN_NAME ); ?>
				</label>
			</li>
			<li>
				<label for="cpiwm-no-email-replace">
					<input type="checkbox" id="cpiwm-no-email-replace" name="options[no_email_replace]" />
					<?php _e( 'Do <strong>not</strong> replace email domain (sql)', CPIWM_PLUGIN_NAME ); ?>
				</label>
			</li>

			<?php do_action( 'cpiwm_export_advanced_settings' ); ?>
		</ul>
	</div>
</div>
