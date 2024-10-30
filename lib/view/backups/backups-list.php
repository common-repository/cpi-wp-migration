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

<?php if ( $backups ) : ?>
	<form action="" method="post" id="cpiwm-backups-form" class="cpiwm-clear">
		<table class="cpiwm-backups">
			<thead>
				<tr>
					<th class="cpiwm-column-name"><?php _e( 'Name', CPIWM_PLUGIN_NAME ); ?></th>
					<th class="cpiwm-column-date"><?php _e( 'Date', CPIWM_PLUGIN_NAME ); ?></th>
					<th class="cpiwm-column-size"><?php _e( 'Size', CPIWM_PLUGIN_NAME ); ?></th>
					<th class="cpiwm-column-actions"></th>
				</tr>
			</thead>
			<tbody>
				<tr class="cpiwm-backups-list-spinner-holder cpiwm-hide">
					<td colspan="4" class="cpiwm-backups-list-spinner">
						<span class="spinner"></span>
						<?php _e( 'Refreshing backup list...', CPIWM_PLUGIN_NAME ); ?>
					</td>
				</tr>

				<?php foreach ( $backups as $backup ) : ?>
				<tr>
					<td class="cpiwm-column-name">
						<?php if ( ! empty( $backup['path'] ) ) : ?>
							<i class="cpiwm-icon-folder"></i>
							<?php echo esc_html( $backup['path'] ); ?>
							<br />
						<?php endif; ?>
						<i class="cpiwm-icon-file-zip"></i>
						<span class="cpiwm-backup-filename">
							<?php echo esc_html( basename( $backup['filename'] ) ); ?>
						</span>
						<span class="cpiwm-backup-label-description cpiwm-hide <?php echo empty( $labels[ $backup['filename'] ] ) ? null : 'cpiwm-backup-label-selected'; ?>">
							<br />
							<?php _e( 'Click to set a label for this backup', CPIWM_PLUGIN_NAME ); ?>
							<i class="cpiwm-icon-edit-pencil cpiwm-hide"></i>
						</span>
						<span class="cpiwm-backup-label-text <?php echo empty( $labels[ $backup['filename'] ] ) ? 'cpiwm-hide' : null; ?>">
							<br />
							<span class="cpiwm-backup-label-colored">
								<?php if ( ! empty( $labels[ $backup['filename'] ] ) ) : ?>
									<?php echo esc_html( $labels[ $backup['filename'] ] ); ?>
								<?php endif; ?>
							</span>
							<i class="cpiwm-icon-edit-pencil cpiwm-hide"></i>
						</span>
						<span class="cpiwm-backup-label-holder cpiwm-hide">
							<br />
							<input type="text" class="cpiwm-backup-label-field" data-archive="<?php echo esc_attr( $backup['filename'] ); ?>" data-value="<?php echo empty( $labels[ $backup['filename'] ] ) ? null : esc_attr( $labels[ $backup['filename'] ] ); ?>" value="<?php echo empty( $labels[ $backup['filename'] ] ) ? null : esc_attr( $labels[ $backup['filename'] ] ); ?>" />
						</span>
					</td>
					<td class="cpiwm-column-date">
						<?php echo esc_html( sprintf( __( '%s ago', CPIWM_PLUGIN_NAME ), human_time_diff( $backup['mtime'] ) ) ); ?>
					</td>
					<td class="cpiwm-column-size">
						<?php if ( ! is_null( $backup['size'] ) ) : ?>
							<?php echo cpiwm_size_format( $backup['size'], 2 ); ?>
						<?php else : ?>
							<?php _e( '2GB+', CPIWM_PLUGIN_NAME ); ?>
						<?php endif; ?>
					</td>
					<td class="cpiwm-column-actions cpiwm-backup-actions">
						<a href="<?php echo esc_url( cpiwm_backup_url( array( 'archive' => $backup['filename'] ) ) ); ?>" class="cpiwm-button-green cpiwm-backup-download" download="<?php echo esc_attr( $backup['filename'] ); ?>" aria-label="<?php _e( 'Download backup', CPIWM_PLUGIN_NAME ); ?>">
							<i class="cpiwm-icon-arrow-down"></i>
							<span><?php _e( 'Download', CPIWM_PLUGIN_NAME ); ?></span>
						</a>
						<a href="#" data-archive="<?php echo esc_attr( $backup['filename'] ); ?>" class="cpiwm-button-red cpiwm-backup-delete" aria-label="<?php _e( 'Delete backup', CPIWM_PLUGIN_NAME ); ?>">
							<i class="cpiwm-icon-close"></i>
							<span><?php _e( 'Delete', CPIWM_PLUGIN_NAME ); ?></span>
						</a>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<input type="hidden" name="cpiwm_manual_restore" value="1" />
	</form>
<?php endif; ?>
