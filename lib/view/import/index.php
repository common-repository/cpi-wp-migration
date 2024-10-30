`<?php
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

if (!defined('ABSPATH')) {
    die('Kangaroos cannot jump here');
}
?>

<div class="cpiwm-container">
	<div class="cpiwm-row">
		<div class="cpiwm-left">
			<div class="cpiwm-holder">
				<h1>
					<i class="cpiwm-icon-publish"></i>
					<?php _e('Import Site', CPIWM_PLUGIN_NAME);?>
				</h1>

				<?php include CPIWM_TEMPLATES_PATH . '/common/report-problem.php';?>

				<?php if (is_readable(CPIWM_STORAGE_PATH) && is_writable(CPIWM_STORAGE_PATH)): ?>

					<form action="" method="post" id="cpiwm-import-form" class="cpiwm-clear" enctype="multipart/form-data">

						<?php do_action('cpiwm_import_left_options');?>

						<?php include CPIWM_TEMPLATES_PATH . '/import/import-buttons.php';?>

						<input type="hidden" name="cpiwm_manual_import" value="1" />

					</form>

					<?php do_action('cpiwm_import_left_end');?>

				<?php else: ?>

					<?php include CPIWM_TEMPLATES_PATH . '/import/import-permissions.php';?>

				<?php endif;?>
			</div>
		</div>
	</div>
</div>
