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

<div class="cpiwm-feedback">
	<ul class="cpiwm-feedback-types">
		<li>
			<input type="radio" class="cpiwm-flat-radio-button cpiwm-feedback-type" id="cpiwm-feedback-type-1" name="cpiwm_feedback_type" value="suggestions" />
			<a id="cpiwm-feedback-type-link-1" href="https://feedback.wp-migration.com" target="_blank">
				<i></i>
				<span><?php _e( 'I have ideas to improve this plugin', CPIWM_PLUGIN_NAME ); ?></span>
			</a>
		</li>
		<li>
			<input type="radio" class="cpiwm-flat-radio-button cpiwm-feedback-type" id="cpiwm-feedback-type-2" name="cpiwm_feedback_type" value="help-needed" />
			<label for="cpiwm-feedback-type-2">
				<i></i>
				<span><?php _e( 'I need help with this plugin', CPIWM_PLUGIN_NAME ); ?></span>
			</label>
		</li>
	</ul>

	<div class="cpiwm-feedback-form">
		<div class="cpiwm-field">
			<input placeholder="<?php _e( 'Enter your email address..', CPIWM_PLUGIN_NAME ); ?>" type="text" id="cpiwm-feedback-email" class="cpiwm-feedback-email" />
		</div>
		<div class="cpiwm-field">
			<textarea rows="3" id="cpiwm-feedback-message" class="cpiwm-feedback-message" placeholder="<?php _e( 'Leave plugin developers any feedback here..', CPIWM_PLUGIN_NAME ); ?>"></textarea>
		</div>
		<div class="cpiwm-field cpiwm-feedback-terms-segment">
			<label for="cpiwm-feedback-terms">
				<input type="checkbox" class="cpiwm-feedback-terms" id="cpiwm-feedback-terms" />
				<?php _e( 'I agree that by filling in the contact form with my data, I authorize CPI WP Migration to use my <strong>email</strong> to reply to my requests for information. <a href="https://www.iubenda.com/privacy-policy/946881" target="_blank">Privacy policy</a>', CPIWM_PLUGIN_NAME ); ?>
			</label>
		</div>
		<div class="cpiwm-field">
			<div class="cpiwm-buttons">
				<a class="cpiwm-feedback-cancel" id="cpiwm-feedback-cancel" href="#"><?php _e( 'Cancel', CPIWM_PLUGIN_NAME ); ?></a>
				<button type="submit" id="cpiwm-feedback-submit" class="cpiwm-button-blue cpiwm-form-submit">
					<i class="cpiwm-icon-paperplane"></i>
					<?php _e( 'Send', CPIWM_PLUGIN_NAME ); ?>
				</button>
				<span class="spinner"></span>
				<div class="cpiwm-clear"></div>
			</div>
		</div>
	</div>
</div>
