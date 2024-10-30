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

<div class="cpiwm-report-problem">
	<div class="cpiwm-report-problem-dialog">
		<div class="cpiwm-field">
			<input placeholder="<?php _e( 'Enter your email address..', CPIWM_PLUGIN_NAME ); ?>" type="text" id="cpiwm-report-email" class="cpiwm-report-email" />
		</div>
		<div class="cpiwm-field">
			<textarea rows="3" id="cpiwm-report-message" class="cpiwm-report-message" placeholder="<?php _e( 'Please describe your problem here..', CPIWM_PLUGIN_NAME ); ?>"></textarea>
		</div>
		<div class="cpiwm-field cpiwm-report-terms-segment">
			<label for="cpiwm-report-terms">
				<input type="checkbox" class="cpiwm-report-terms" id="cpiwm-report-terms" />
				<?php _e( 'I agree that by filling in the contact form with my data, I authorize CPI WP Migration to use my <strong>email</strong> to reply to my requests for information. <a href="https://www.iubenda.com/privacy-policy/946881" target="_blank">Privacy policy</a>', CPIWM_PLUGIN_NAME ); ?>
			</label>
		</div>
		<div class="cpiwm-field">
			<div class="cpiwm-buttons">
				<a href="#" id="cpiwm-report-cancel" class="cpiwm-report-cancel"><?php _e( 'Cancel', CPIWM_PLUGIN_NAME ); ?></a>
				<button type="submit" id="cpiwm-report-submit" class="cpiwm-button-blue cpiwm-form-submit">
					<i class="cpiwm-icon-paperplane"></i>
					<?php _e( 'Send', CPIWM_PLUGIN_NAME ); ?>
				</button>
				<span class="spinner"></span>
				<div class="cpiwm-clear"></div>
			</div>
		</div>
	</div>
</div>
