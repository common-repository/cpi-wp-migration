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

if (!defined('ABSPATH')) {
    die('Kangaroos cannot jump here');
}
?>

<div class="cpiwm-import-messages"></div>

<div class="cpiwm-import-form">
	<div class="hide-if-no-js">
		<div class="cpiwm-drag-drop-area" id="cpiwm-drag-drop-area">
			<div id="cpiwm-import-init">
				<p>
					<i class="cpiwm-icon-cloud-upload"></i><br />
					<?php _e('Drag & Drop a backup to import it', CPIWM_PLUGIN_NAME);?>
				</p>
			</div>
		</div>

		<a href="#" aria-label="To choose a file please go inside the link and click on the browse button." id="cpiwm-import-file" class="cpiwm-button-green"><i class="cpiwm-icon-publish"></i>
	Import From File	<input type="file" id="cpiwm-select-file"></a>
	</div>
</div>
<p style="margin: 0;"><?php echo apply_filters('cpiwm_pro', ''); ?></p>
