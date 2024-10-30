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

<div class="cpiwm-container">
	<div class="cpiwm-row">
		<div class="cpiwm-left">
			<div class="cpiwm-holder">
				<h1>
					<i class="cpiwm-icon-export"></i>
					<?php _e( 'Backups', CPIWM_PLUGIN_NAME ); ?>
				</h1>

				<?php include CPIWM_TEMPLATES_PATH . '/common/report-problem.php'; ?>

				<?php if ( is_readable( CPIWM_BACKUPS_PATH ) && is_writable( CPIWM_BACKUPS_PATH ) ) : ?>
					<div id="cpiwm-backups-list">
						<?php include CPIWM_TEMPLATES_PATH . '/backups/backups-list.php'; ?>
					</div>

					<form action="" method="post" id="cpiwm-export-form" class="cpiwm-clear">
						<div id="cpiwm-backups-create">
							<p class="cpiwm-backups-empty-spinner-holder cpiwm-hide">
								<span class="spinner"></span>
								<?php _e( 'Refreshing backup list...', CPIWM_PLUGIN_NAME ); ?>
							</p>
							<p class="cpiwm-backups-empty <?php echo empty( $backups ) ? null : 'cpiwm-hide'; ?>">
								<?php _e( 'There are no backups available at this time, why not create a new one?', CPIWM_PLUGIN_NAME ); ?>
							</p>
							<p>
								<a href="#" id="cpiwm-create-backup" class="cpiwm-button-green">
									<i class="cpiwm-icon-export"></i>
									<?php _e( 'Create backup', CPIWM_PLUGIN_NAME ); ?>
								</a>
							</p>
						</div>
						<input type="hidden" name="cpiwm_manual_export" value="1" />
					</form>

					<?php do_action( 'cpiwm_backups_left_end' ); ?>

				<?php else : ?>

					<?php include CPIWM_TEMPLATES_PATH . '/backups/backups-permissions.php'; ?>

				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
