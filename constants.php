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

// ================
// = Plugin Debug =
// ================
define( 'CPIWM_DEBUG', false );

// ==================
// = Plugin Version =
// ==================
define( 'CPIWM_VERSION', '7.14' );

// ===============
// = Plugin Name =
// ===============
define( 'CPIWM_PLUGIN_NAME', 'cpi-wp-migration' );

// ============================
// = Directory index.php File =
// ============================
define( 'CPIWM_DIRECTORY_INDEX', 'index.php' );

// ================
// = Storage Path =
// ================
define( 'CPIWM_STORAGE_PATH', CPIWM_PATH . DIRECTORY_SEPARATOR . 'storage' );

// ==================
// = Error Log Path =
// ==================
define( 'CPIWM_ERROR_FILE', CPIWM_STORAGE_PATH . DIRECTORY_SEPARATOR . 'error.log' );

// ===============
// = Status Path =
// ===============
define( 'CPIWM_STATUS_FILE', CPIWM_STORAGE_PATH . DIRECTORY_SEPARATOR . 'status.js' );

// ============
// = Lib Path =
// ============
define( 'CPIWM_LIB_PATH', CPIWM_PATH . DIRECTORY_SEPARATOR . 'lib' );

// ===================
// = Controller Path =
// ===================
define( 'CPIWM_CONTROLLER_PATH', CPIWM_LIB_PATH . DIRECTORY_SEPARATOR . 'controller' );

// ==============
// = Model Path =
// ==============
define( 'CPIWM_MODEL_PATH', CPIWM_LIB_PATH . DIRECTORY_SEPARATOR . 'model' );

// ===============
// = Export Path =
// ===============
define( 'CPIWM_EXPORT_PATH', CPIWM_MODEL_PATH . DIRECTORY_SEPARATOR . 'export' );

// ===============
// = Import Path =
// ===============
define( 'CPIWM_IMPORT_PATH', CPIWM_MODEL_PATH . DIRECTORY_SEPARATOR . 'import' );

// =============
// = View Path =
// =============
define( 'CPIWM_TEMPLATES_PATH', CPIWM_LIB_PATH . DIRECTORY_SEPARATOR . 'view' );

// ===================
// = Set Bandar Path =
// ===================
define( 'BANDAR_TEMPLATES_PATH', CPIWM_TEMPLATES_PATH );

// ===============
// = Vendor Path =
// ===============
define( 'CPIWM_VENDOR_PATH', CPIWM_LIB_PATH . DIRECTORY_SEPARATOR . 'vendor' );

// =========================
// = ServMask Feedback URL =
// =========================
define( 'CPIWM_FEEDBACK_URL', '#' );

// =======================
// = ServMask Report URL =
// =======================
define( 'CPIWM_REPORT_URL', '#' );

// ==============================
// = ServMask Archive Tools URL =
// ==============================
define( 'CPIWM_ARCHIVE_TOOLS_URL', '#' );

// =========================
// = ServMask Table Prefix =
// =========================
define( 'CPIWM_TABLE_PREFIX', 'SERVMASK_PREFIX_' );

// ========================
// = Archive Backups Name =
// ========================
define( 'CPIWM_BACKUPS_NAME', 'cpiwm-backups' );

// =========================
// = Archive Database Name =
// =========================
define( 'CPIWM_DATABASE_NAME', 'database.sql' );

// ========================
// = Archive Package Name =
// ========================
define( 'CPIWM_PACKAGE_NAME', 'package.json' );

// ==========================
// = Archive Multisite Name =
// ==========================
define( 'CPIWM_MULTISITE_NAME', 'multisite.json' );

// ======================
// = Archive Blogs Name =
// ======================
define( 'CPIWM_BLOGS_NAME', 'blogs.json' );

// =========================
// = Archive Settings Name =
// =========================
define( 'CPIWM_SETTINGS_NAME', 'settings.json' );

// ==========================
// = Archive Multipart Name =
// ==========================
define( 'CPIWM_MULTIPART_NAME', 'multipart.list' );

// ========================
// = Archive Filemap Name =
// ========================
define( 'CPIWM_FILEMAP_NAME', 'filemap.list' );

// =================================
// = Archive Must-Use Plugins Name =
// =================================
define( 'CPIWM_MUPLUGINS_NAME', 'mu-plugins' );

// =============================
// = Less Cache Extension Name =
// =============================
define( 'CPIWM_LESS_CACHE_NAME', '.less.cache' );

// ============================
// = Elementor CSS Cache Name =
// ============================
define( 'CPIWM_ELEMENTOR_CSS_NAME', 'uploads' . DIRECTORY_SEPARATOR . 'elementor' . DIRECTORY_SEPARATOR . 'css' );

// =============================
// = Endurance Page Cache Name =
// =============================
define( 'CPIWM_ENDURANCE_PAGE_CACHE_NAME', 'endurance-page-cache.php' );

// ===========================
// = Endurance PHP Edge Name =
// ===========================
define( 'CPIWM_ENDURANCE_PHP_EDGE_NAME', 'endurance-php-edge.php' );

// ================================
// = Endurance Browser Cache Name =
// ================================
define( 'CPIWM_ENDURANCE_BROWSER_CACHE_NAME', 'endurance-browser-cache.php' );

// =========================
// = GD System Plugin Name =
// =========================
define( 'CPIWM_GD_SYSTEM_PLUGIN_NAME', 'gd-system-plugin.php' );

// =======================
// = WP Stack Cache Name =
// =======================
define( 'CPIWM_WP_STACK_CACHE_NAME', 'wp-stack-cache.php' );

// ===========================
// = WP.com Site Helper Name =
// ===========================
define( 'CPIWM_WP_COMSH_LOADER_NAME', 'wpcomsh-loader.php' );

// ================================
// = WP Engine System Plugin Name =
// ================================
define( 'CPIWM_WP_ENGINE_SYSTEM_PLUGIN_NAME', 'mu-plugin.php' );

// ===========================
// = WPE Sign On Plugin Name =
// ===========================
define( 'CPIWM_WPE_SIGN_ON_PLUGIN_NAME', 'wpe-wp-sign-on-plugin.php' );

// ===================================
// = WP Engine Security Auditor Name =
// ===================================
define( 'CPIWM_WP_ENGINE_SECURITY_AUDITOR_NAME', 'wpengine-security-auditor.php' );

// ===================
// = Export Log Name =
// ===================
define( 'CPIWM_EXPORT_NAME', 'export.log' );

// ===================
// = Import Log Name =
// ===================
define( 'CPIWM_IMPORT_NAME', 'import.log' );

// ==================
// = Error Log Name =
// ==================
define( 'CPIWM_ERROR_NAME', 'error.log' );

// ==============
// = Secret Key =
// ==============
define( 'CPIWM_SECRET_KEY', 'cpiwm_secret_key' );

// =============
// = Auth User =
// =============
define( 'CPIWM_AUTH_USER', 'cpiwm_auth_user' );

// =================
// = Auth Password =
// =================
define( 'CPIWM_AUTH_PASSWORD', 'cpiwm_auth_password' );

// ============
// = Site URL =
// ============
define( 'CPIWM_SITE_URL', 'siteurl' );

// ============
// = Home URL =
// ============
define( 'CPIWM_HOME_URL', 'home' );

// ==================
// = Active Plugins =
// ==================
define( 'CPIWM_ACTIVE_PLUGINS', 'active_plugins' );

// ===========================
// = Active Sitewide Plugins =
// ===========================
define( 'CPIWM_ACTIVE_SITEWIDE_PLUGINS', 'active_sitewide_plugins' );

// ==========================
// = Jetpack Active Modules =
// ==========================
define( 'CPIWM_JETPACK_ACTIVE_MODULES', 'jetpack_active_modules' );

// ======================
// = MS Files Rewriting =
// ======================
define( 'CPIWM_MS_FILES_REWRITING', 'ms_files_rewriting' );

// ===================
// = Active Template =
// ===================
define( 'CPIWM_ACTIVE_TEMPLATE', 'template' );

// =====================
// = Active Stylesheet =
// =====================
define( 'CPIWM_ACTIVE_STYLESHEET', 'stylesheet' );

// ===================
// = Backups Labels  =
// ===================
define( 'CPIWM_BACKUPS_LABELS', 'cpiwm_backups_labels' );

// ===============
// = Sites Links =
// ===============
define( 'CPIWM_SITES_LINKS', 'cpiwm_sites_links' );

// ============
// = Cron Key =
// ============
define( 'CPIWM_CRON', 'cron' );

// ===============
// = Updater Key =
// ===============
define( 'CPIWM_UPDATER', 'cpiwm_updater' );

// ==============
// = Status Key =
// ==============
define( 'CPIWM_STATUS', 'cpiwm_status' );

// ================
// = Messages Key =
// ================
define( 'CPIWM_MESSAGES', 'cpiwm_messages' );

// =================
// = Support Email =
// =================
define( 'CPIWM_SUPPORT_EMAIL', '' );

// =================
// = Max File Size =
// =================
define( 'CPIWM_MAX_FILE_SIZE', 2 << 28 );

// =================
// = Max File Import Size =
// =================
define( 'CPIWM_MAX_FILE_IMPORT_SIZE', 10 * 1024 * 1024 * 1024 );

// ==================
// = Max Chunk Size =
// ==================
define( 'CPIWM_MAX_CHUNK_SIZE', 5 * 1024 * 1024 );

// =====================
// = Max Chunk Retries =
// =====================
define( 'CPIWM_MAX_CHUNK_RETRIES', 10 );

// ===========================
// = Max Transaction Queries =
// ===========================
define( 'CPIWM_MAX_TRANSACTION_QUERIES', 1000 );

// ======================
// = Max Select Records =
// ======================
define( 'CPIWM_MAX_SELECT_RECORDS', 1000 );

// =======================
// = Max Storage Cleanup =
// =======================
define( 'CPIWM_MAX_STORAGE_CLEANUP', 24 * 60 * 60 );

// =====================
// = Disk Space Factor =
// =====================
define( 'CPIWM_DISK_SPACE_FACTOR', 2 );

// ====================
// = Disk Space Extra =
//=====================
define( 'CPIWM_DISK_SPACE_EXTRA', 300 * 1024 * 1024 );

// ===========================
// = WP_CONTENT_DIR Constant =
// ===========================
if ( ! defined( 'WP_CONTENT_DIR' ) ) {
	define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content' );
}

// ================
// = Uploads Path =
// ================
define( 'CPIWM_UPLOADS_PATH', 'uploads' );

// ==============
// = Blogs Path =
// ==============
define( 'CPIWM_BLOGSDIR_PATH', 'blogs.dir' );

// ==============
// = Sites Path =
// ==============
define( 'CPIWM_SITES_PATH', CPIWM_UPLOADS_PATH . DIRECTORY_SEPARATOR . 'sites' );

// ================
// = Backups Path =
// ================
define( 'CPIWM_BACKUPS_PATH', WP_CONTENT_DIR . DIRECTORY_SEPARATOR . 'cpiwm-backups' );

// ==========================
// = Storage index.php File =
// ==========================
define( 'CPIWM_STORAGE_INDEX', CPIWM_STORAGE_PATH . DIRECTORY_SEPARATOR . 'index.php' );

// ==========================
// = Backups index.php File =
// ==========================
define( 'CPIWM_BACKUPS_INDEX', CPIWM_BACKUPS_PATH . DIRECTORY_SEPARATOR . 'index.php' );

// ==========================
// = Backups .htaccess File =
// ==========================
define( 'CPIWM_BACKUPS_HTACCESS', CPIWM_BACKUPS_PATH . DIRECTORY_SEPARATOR . '.htaccess' );

// ===========================
// = Backups web.config File =
// ===========================
define( 'CPIWM_BACKUPS_WEBCONFIG', CPIWM_BACKUPS_PATH . DIRECTORY_SEPARATOR . 'web.config' );

// ============================
// = WordPress .htaccess File =
// ============================
define( 'CPIWM_WORDPRESS_HTACCESS', ABSPATH . DIRECTORY_SEPARATOR . '.htaccess' );

// ================================
// = WP Migration Plugin Base Dir =
// ================================
if ( defined( 'CPIWM_PLUGIN_BASENAME' ) ) {
	define( 'CPIWM_PLUGIN_BASEDIR', dirname( CPIWM_PLUGIN_BASENAME ) );
} else {
	define( 'CPIWM_PLUGIN_BASEDIR', 'cpi-wp-migration' );
}

// ======================================
// = Microsoft Azure Extension Base Dir =
// ======================================
if ( defined( 'CPIWMZE_PLUGIN_BASENAME' ) ) {
	define( 'CPIWMZE_PLUGIN_BASEDIR', dirname( CPIWMZE_PLUGIN_BASENAME ) );
} else {
	define( 'CPIWMZE_PLUGIN_BASEDIR', 'cpi-wp-migration-azure-storage-extension' );
}

// ===================================
// = Microsoft Azure Extension Title =
// ===================================
if ( ! defined( 'CPIWMZE_PLUGIN_TITLE' ) ) {
	define( 'CPIWMZE_PLUGIN_TITLE', 'Microsoft Azure Storage Extension' );
}

// ===================================
// = Microsoft Azure Extension About =
// ===================================
if ( ! defined( 'CPIWMZE_PLUGIN_ABOUT' ) ) {
	define( 'CPIWMZE_PLUGIN_ABOUT', '#' );
}

// =================================
// = Microsoft Azure Extension Key =
// =================================
if ( ! defined( 'CPIWMZE_PLUGIN_KEY' ) ) {
	define( 'CPIWMZE_PLUGIN_KEY', 'cpiwmze_plugin_key' );
}

// ===================================
// = Microsoft Azure Extension Short =
// ===================================
if ( ! defined( 'CPIWMZE_PLUGIN_SHORT' ) ) {
	define( 'CPIWMZE_PLUGIN_SHORT', 'azure-storage' );
}

// ===================================
// = Backblaze B2 Extension Base Dir =
// ===================================
if ( defined( 'CPIWMAE_PLUGIN_BASENAME' ) ) {
	define( 'CPIWMAE_PLUGIN_BASEDIR', dirname( CPIWMAE_PLUGIN_BASENAME ) );
} else {
	define( 'CPIWMAE_PLUGIN_BASEDIR', 'cpi-wp-migration-b2-extension' );
}

// ================================
// = Backblaze B2 Extension Title =
// ================================
if ( ! defined( 'CPIWMAE_PLUGIN_TITLE' ) ) {
	define( 'CPIWMAE_PLUGIN_TITLE', 'Backblaze B2 Extension' );
}

// ================================
// = Backblaze B2 Extension About =
// ================================
if ( ! defined( 'CPIWMAE_PLUGIN_ABOUT' ) ) {
	define( 'CPIWMAE_PLUGIN_ABOUT', '#' );
}

// ==============================
// = Backblaze B2 Extension Key =
// ==============================
if ( ! defined( 'CPIWMAE_PLUGIN_KEY' ) ) {
	define( 'CPIWMAE_PLUGIN_KEY', 'cpiwmae_plugin_key' );
}

// ================================
// = Backblaze B2 Extension Short =
// ================================
if ( ! defined( 'CPIWMAE_PLUGIN_SHORT' ) ) {
	define( 'CPIWMAE_PLUGIN_SHORT', 'b2' );
}

// ==========================
// = Box Extension Base Dir =
// ==========================
if ( defined( 'CPIWMBE_PLUGIN_BASENAME' ) ) {
	define( 'CPIWMBE_PLUGIN_BASEDIR', dirname( CPIWMBE_PLUGIN_BASENAME ) );
} else {
	define( 'CPIWMBE_PLUGIN_BASEDIR', 'cpi-wp-migration-box-extension' );
}

// =======================
// = Box Extension Title =
// =======================
if ( ! defined( 'CPIWMBE_PLUGIN_TITLE' ) ) {
	define( 'CPIWMBE_PLUGIN_TITLE', 'Box Extension' );
}

// =======================
// = Box Extension About =
// =======================
if ( ! defined( 'CPIWMBE_PLUGIN_ABOUT' ) ) {
	define( 'CPIWMBE_PLUGIN_ABOUT', '#' );
}

// =====================
// = Box Extension Key =
// =====================
if ( ! defined( 'CPIWMBE_PLUGIN_KEY' ) ) {
	define( 'CPIWMBE_PLUGIN_KEY', 'cpiwmbe_plugin_key' );
}

// =======================
// = Box Extension Short =
// =======================
if ( ! defined( 'CPIWMBE_PLUGIN_SHORT' ) ) {
	define( 'CPIWMBE_PLUGIN_SHORT', 'box' );
}

// ==========================================
// = DigitalOcean Spaces Extension Base Dir =
// ==========================================
if ( defined( 'CPIWMIE_PLUGIN_BASENAME' ) ) {
	define( 'CPIWMIE_PLUGIN_BASEDIR', dirname( CPIWMIE_PLUGIN_BASENAME ) );
} else {
	define( 'CPIWMIE_PLUGIN_BASEDIR', 'cpi-wp-migration-digitalocean-extension' );
}

// =======================================
// = DigitalOcean Spaces Extension Title =
// =======================================
if ( ! defined( 'CPIWMIE_PLUGIN_TITLE' ) ) {
	define( 'CPIWMIE_PLUGIN_TITLE', 'DigitalOcean Spaces Extension' );
}

// =======================================
// = DigitalOcean Spaces Extension About =
// =======================================
if ( ! defined( 'CPIWMIE_PLUGIN_ABOUT' ) ) {
	define( 'CPIWMIE_PLUGIN_ABOUT', '#' );
}

// =====================================
// = DigitalOcean Spaces Extension Key =
// =====================================
if ( ! defined( 'CPIWMIE_PLUGIN_KEY' ) ) {
	define( 'CPIWMIE_PLUGIN_KEY', 'cpiwmie_plugin_key' );
}

// =======================================
// = DigitalOcean Spaces Extension Short =
// =======================================
if ( ! defined( 'CPIWMIE_PLUGIN_SHORT' ) ) {
	define( 'CPIWMIE_PLUGIN_SHORT', 'digitalocean' );
}

// =============================
// = Direct Extension Base Dir =
// =============================
if ( defined( 'CPIWMXE_PLUGIN_BASENAME' ) ) {
	define( 'CPIWMXE_PLUGIN_BASEDIR', dirname( CPIWMXE_PLUGIN_BASENAME ) );
} else {
	define( 'CPIWMXE_PLUGIN_BASEDIR', 'cpi-wp-migration-direct-extension' );
}
// ==========================
// = Direct Extension Title =
// ==========================
if ( ! defined( 'CPIWMXE_PLUGIN_TITLE' ) ) {
	define( 'CPIWMXE_PLUGIN_TITLE', 'Direct Extension' );
}
// ==========================
// = Direct Extension About =
// ==========================
if ( ! defined( 'CPIWMXE_PLUGIN_ABOUT' ) ) {
	define( 'CPIWMXE_PLUGIN_ABOUT', '#' );
}
// ========================
// = Direct Extension Key =
// ========================
if ( ! defined( 'CPIWMXE_PLUGIN_KEY' ) ) {
	define( 'CPIWMXE_PLUGIN_KEY', 'cpiwmxe_plugin_key' );
}
// ==========================
// = Direct Extension Short =
// ==========================
if ( ! defined( 'CPIWMXE_PLUGIN_SHORT' ) ) {
	define( 'CPIWMXE_PLUGIN_SHORT', 'direct' );
}

// ==============================
// = Dropbox Extension Base Dir =
// ==============================
if ( defined( 'CPIWMDE_PLUGIN_BASENAME' ) ) {
	define( 'CPIWMDE_PLUGIN_BASEDIR', dirname( CPIWMDE_PLUGIN_BASENAME ) );
} else {
	define( 'CPIWMDE_PLUGIN_BASEDIR', 'cpi-wp-migration-dropbox-extension' );
}

// ===========================
// = Dropbox Extension Title =
// ===========================
if ( ! defined( 'CPIWMDE_PLUGIN_TITLE' ) ) {
	define( 'CPIWMDE_PLUGIN_TITLE', 'Dropbox Extension' );
}

// ===========================
// = Dropbox Extension About =
// ===========================
if ( ! defined( 'CPIWMDE_PLUGIN_ABOUT' ) ) {
	define( 'CPIWMDE_PLUGIN_ABOUT', '#' );
}

// =========================
// = Dropbox Extension Key =
// =========================
if ( ! defined( 'CPIWMDE_PLUGIN_KEY' ) ) {
	define( 'CPIWMDE_PLUGIN_KEY', 'cpiwmde_plugin_key' );
}

// ===========================
// = Dropbox Extension Short =
// ===========================
if ( ! defined( 'CPIWMDE_PLUGIN_SHORT' ) ) {
	define( 'CPIWMDE_PLUGIN_SHORT', 'dropbox' );
}

// ===========================
// = File Extension Base Dir =
// ===========================
if ( defined( 'CPIWMTE_PLUGIN_BASENAME' ) ) {
	define( 'CPIWMTE_PLUGIN_BASEDIR', dirname( CPIWMTE_PLUGIN_BASENAME ) );
} else {
	define( 'CPIWMTE_PLUGIN_BASEDIR', 'cpi-wp-migration-file-extension' );
}

// ========================
// = File Extension Title =
// ========================
if ( ! defined( 'CPIWMTE_PLUGIN_TITLE' ) ) {
	define( 'CPIWMTE_PLUGIN_TITLE', 'File Extension' );
}

// ========================
// = File Extension About =
// ========================
if ( ! defined( 'CPIWMTE_PLUGIN_ABOUT' ) ) {
	define( 'CPIWMTE_PLUGIN_ABOUT', 'https://import.wp-migration.com/file-extension.json' );
}

// ======================
// = File Extension Key =
// ======================
if ( ! defined( 'CPIWMTE_PLUGIN_KEY' ) ) {
	define( 'CPIWMTE_PLUGIN_KEY', 'cpiwmte_plugin_key' );
}

// ========================
// = File Extension Short =
// ========================
if ( ! defined( 'CPIWMTE_PLUGIN_SHORT' ) ) {
	define( 'CPIWMTE_PLUGIN_SHORT', 'file' );
}

// ==========================
// = FTP Extension Base Dir =
// ==========================
if ( defined( 'CPIWMFE_PLUGIN_BASENAME' ) ) {
	define( 'CPIWMFE_PLUGIN_BASEDIR', dirname( CPIWMFE_PLUGIN_BASENAME ) );
} else {
	define( 'CPIWMFE_PLUGIN_BASEDIR', 'cpi-wp-migration-ftp-extension' );
}

// =======================
// = FTP Extension Title =
// =======================
if ( ! defined( 'CPIWMFE_PLUGIN_TITLE' ) ) {
	define( 'CPIWMFE_PLUGIN_TITLE', 'FTP Extension' );
}

// =======================
// = FTP Extension About =
// =======================
if ( ! defined( 'CPIWMFE_PLUGIN_ABOUT' ) ) {
	define( 'CPIWMFE_PLUGIN_ABOUT', '#' );
}

// =====================
// = FTP Extension Key =
// =====================
if ( ! defined( 'CPIWMFE_PLUGIN_KEY' ) ) {
	define( 'CPIWMFE_PLUGIN_KEY', 'cpiwmfe_plugin_key' );
}

// =======================
// = FTP Extension Short =
// =======================
if ( ! defined( 'CPIWMFE_PLUGIN_SHORT' ) ) {
	define( 'CPIWMFE_PLUGIN_SHORT', 'ftp' );
}

// ===========================================
// = Google Cloud Storage Extension Base Dir =
// ===========================================
if ( defined( 'CPIWMCE_PLUGIN_BASENAME' ) ) {
	define( 'CPIWMCE_PLUGIN_BASEDIR', dirname( CPIWMCE_PLUGIN_BASENAME ) );
} else {
	define( 'CPIWMCE_PLUGIN_BASEDIR', 'cpi-wp-migration-gcloud-storage-extension' );
}

// ========================================
// = Google Cloud Storage Extension Title =
// ========================================
if ( ! defined( 'CPIWMCE_PLUGIN_TITLE' ) ) {
	define( 'CPIWMCE_PLUGIN_TITLE', 'Google Cloud Storage Extension' );
}

// ========================================
// = Google Cloud Storage Extension About =
// ========================================
if ( ! defined( 'CPIWMCE_PLUGIN_ABOUT' ) ) {
	define( 'CPIWMCE_PLUGIN_ABOUT', '#' );
}

// ======================================
// = Google Cloud Storage Extension Key =
// ======================================
if ( ! defined( 'CPIWMCE_PLUGIN_KEY' ) ) {
	define( 'CPIWMCE_PLUGIN_KEY', 'cpiwmce_plugin_key' );
}

// ========================================
// = Google Cloud Storage Extension Short =
// ========================================
if ( ! defined( 'CPIWMCE_PLUGIN_SHORT' ) ) {
	define( 'CPIWMCE_PLUGIN_SHORT', 'gcloud-storage' );
}

// ===================================
// = Google Drive Extension Base Dir =
// ===================================
if ( defined( 'CPIWMGE_PLUGIN_BASENAME' ) ) {
	define( 'CPIWMGE_PLUGIN_BASEDIR', dirname( CPIWMGE_PLUGIN_BASENAME ) );
} else {
	define( 'CPIWMGE_PLUGIN_BASEDIR', 'cpi-wp-migration-gdrive-extension' );
}

// ================================
// = Google Drive Extension Title =
// ================================
if ( ! defined( 'CPIWMGE_PLUGIN_TITLE' ) ) {
	define( 'CPIWMGE_PLUGIN_TITLE', 'Google Drive Extension' );
}

// ================================
// = Google Drive Extension About =
// ================================
if ( ! defined( 'CPIWMGE_PLUGIN_ABOUT' ) ) {
	define( 'CPIWMGE_PLUGIN_ABOUT', '#' );
}

// ==============================
// = Google Drive Extension Key =
// ==============================
if ( ! defined( 'CPIWMGE_PLUGIN_KEY' ) ) {
	define( 'CPIWMGE_PLUGIN_KEY', 'cpiwmge_plugin_key' );
}

// ================================
// = Google Drive Extension Short =
// ================================
if ( ! defined( 'CPIWMGE_PLUGIN_SHORT' ) ) {
	define( 'CPIWMGE_PLUGIN_SHORT', 'gdrive' );
}

// =====================================
// = Amazon Glacier Extension Base Dir =
// =====================================
if ( defined( 'CPIWMRE_PLUGIN_BASENAME' ) ) {
	define( 'CPIWMRE_PLUGIN_BASEDIR', dirname( CPIWMRE_PLUGIN_BASENAME ) );
} else {
	define( 'CPIWMRE_PLUGIN_BASEDIR', 'cpi-wp-migration-glacier-extension' );
}

// ==================================
// = Amazon Glacier Extension Title =
// ==================================
if ( ! defined( 'CPIWMRE_PLUGIN_TITLE' ) ) {
	define( 'CPIWMRE_PLUGIN_TITLE', 'Amazon Glacier Extension' );
}

// ==================================
// = Amazon Glacier Extension About =
// ==================================
if ( ! defined( 'CPIWMRE_PLUGIN_ABOUT' ) ) {
	define( 'CPIWMRE_PLUGIN_ABOUT', '#' );
}

// ================================
// = Amazon Glacier Extension Key =
// ================================
if ( ! defined( 'CPIWMRE_PLUGIN_KEY' ) ) {
	define( 'CPIWMRE_PLUGIN_KEY', 'cpiwmre_plugin_key' );
}

// ==================================
// = Amazon Glacier Extension Short =
// ==================================
if ( ! defined( 'CPIWMRE_PLUGIN_SHORT' ) ) {
	define( 'CPIWMRE_PLUGIN_SHORT', 'glacier' );
}

// ===========================
// = Mega Extension Base Dir =
// ===========================
if ( defined( 'CPIWMEE_PLUGIN_BASENAME' ) ) {
	define( 'CPIWMEE_PLUGIN_BASEDIR', dirname( CPIWMEE_PLUGIN_BASENAME ) );
} else {
	define( 'CPIWMEE_PLUGIN_BASEDIR', 'cpi-wp-migration-mega-extension' );
}

// ========================
// = Mega Extension Title =
// ========================
if ( ! defined( 'CPIWMEE_PLUGIN_TITLE' ) ) {
	define( 'CPIWMEE_PLUGIN_TITLE', 'Mega Extension' );
}

// ========================
// = Mega Extension About =
// ========================
if ( ! defined( 'CPIWMEE_PLUGIN_ABOUT' ) ) {
	define( 'CPIWMEE_PLUGIN_ABOUT', '#' );
}

// ======================
// = Mega Extension Key =
// ======================
if ( ! defined( 'CPIWMEE_PLUGIN_KEY' ) ) {
	define( 'CPIWMEE_PLUGIN_KEY', 'cpiwmee_plugin_key' );
}

// ========================
// = Mega Extension Short =
// ========================
if ( ! defined( 'CPIWMEE_PLUGIN_SHORT' ) ) {
	define( 'CPIWMEE_PLUGIN_SHORT', 'mega' );
}

// ================================
// = Multisite Extension Base Dir =
// ================================
if ( defined( 'CPIWMME_PLUGIN_BASENAME' ) ) {
	define( 'CPIWMME_PLUGIN_BASEDIR', dirname( CPIWMME_PLUGIN_BASENAME ) );
} else {
	define( 'CPIWMME_PLUGIN_BASEDIR', 'cpi-wp-migration-multisite-extension' );
}

// =============================
// = Multisite Extension Title =
// =============================
if ( ! defined( 'CPIWMME_PLUGIN_TITLE' ) ) {
	define( 'CPIWMME_PLUGIN_TITLE', 'Multisite Extension' );
}

// =============================
// = Multisite Extension About =
// =============================
if ( ! defined( 'CPIWMME_PLUGIN_ABOUT' ) ) {
	define( 'CPIWMME_PLUGIN_ABOUT', '#' );
}

// ===========================
// = Multisite Extension Key =
// ===========================
if ( ! defined( 'CPIWMME_PLUGIN_KEY' ) ) {
	define( 'CPIWMME_PLUGIN_KEY', 'cpiwmme_plugin_key' );
}

// =============================
// = Multisite Extension Short =
// =============================
if ( ! defined( 'CPIWMME_PLUGIN_SHORT' ) ) {
	define( 'CPIWMME_PLUGIN_SHORT', 'multisite' );
}

// ===============================
// = OneDrive Extension Base Dir =
// ===============================
if ( defined( 'CPIWMOE_PLUGIN_BASENAME' ) ) {
	define( 'CPIWMOE_PLUGIN_BASEDIR', dirname( CPIWMOE_PLUGIN_BASENAME ) );
} else {
	define( 'CPIWMOE_PLUGIN_BASEDIR', 'cpi-wp-migration-onedrive-extension' );
}

// ============================
// = OneDrive Extension Title =
// ============================
if ( ! defined( 'CPIWMOE_PLUGIN_TITLE' ) ) {
	define( 'CPIWMOE_PLUGIN_TITLE', 'OneDrive Extension' );
}

// ============================
// = OneDrive Extension About =
// ============================
if ( ! defined( 'CPIWMOE_PLUGIN_ABOUT' ) ) {
	define( 'CPIWMOE_PLUGIN_ABOUT', '#' );
}

// ==========================
// = OneDrive Extension Key =
// ==========================
if ( ! defined( 'CPIWMOE_PLUGIN_KEY' ) ) {
	define( 'CPIWMOE_PLUGIN_KEY', 'cpiwmoe_plugin_key' );
}

// ============================
// = OneDrive Extension Short =
// ============================
if ( ! defined( 'CPIWMOE_PLUGIN_SHORT' ) ) {
	define( 'CPIWMOE_PLUGIN_SHORT', 'onedrive' );
}

// =============================
// = pCloud Extension Base Dir =
// =============================
if ( defined( 'CPIWMPE_PLUGIN_BASENAME' ) ) {
	define( 'CPIWMPE_PLUGIN_BASEDIR', dirname( CPIWMPE_PLUGIN_BASENAME ) );
} else {
	define( 'CPIWMPE_PLUGIN_BASEDIR', 'cpi-wp-migration-pcloud-extension' );
}

// ==========================
// = pCloud Extension Title =
// ==========================
if ( ! defined( 'CPIWMPE_PLUGIN_TITLE' ) ) {
	define( 'CPIWMPE_PLUGIN_TITLE', 'pCloud Extension' );
}

// ==========================
// = pCloud Extension About =
// ==========================
if ( ! defined( 'CPIWMPE_PLUGIN_ABOUT' ) ) {
	define( 'CPIWMPE_PLUGIN_ABOUT', '#' );
}

// ========================
// = pCloud Extension Key =
// ========================
if ( ! defined( 'CPIWMPE_PLUGIN_KEY' ) ) {
	define( 'CPIWMPE_PLUGIN_KEY', 'cpiwmpe_plugin_key' );
}

// ==========================
// = pCloud Extension short =
// ==========================
if ( ! defined( 'CPIWMPE_PLUGIN_SHORT' ) ) {
	define( 'CPIWMPE_PLUGIN_SHORT', 'pcloud' );
}

// ================================
// = S3 Client Extension Base Dir =
// ================================
if ( defined( 'CPIWMNE_PLUGIN_BASENAME' ) ) {
	define( 'CPIWMNE_PLUGIN_BASEDIR', dirname( CPIWMNE_PLUGIN_BASENAME ) );
} else {
	define( 'CPIWMNE_PLUGIN_BASEDIR', 'cpi-wp-migration-s3-client-extension' );
}

// =============================
// = S3 Client Extension Title =
// =============================
if ( ! defined( 'CPIWMNE_PLUGIN_TITLE' ) ) {
	define( 'CPIWMNE_PLUGIN_TITLE', 'S3 Client Extension' );
}

// =============================
// = S3 Client Extension About =
// =============================
if ( ! defined( 'CPIWMNE_PLUGIN_ABOUT' ) ) {
	define( 'CPIWMNE_PLUGIN_ABOUT', '#' );
}

// ===========================
// = S3 Client Extension Key =
// ===========================
if ( ! defined( 'CPIWMNE_PLUGIN_KEY' ) ) {
	define( 'CPIWMNE_PLUGIN_KEY', 'cpiwmne_plugin_key' );
}

// =============================
// = S3 Client Extension Short =
// =============================
if ( ! defined( 'CPIWMNE_PLUGIN_SHORT' ) ) {
	define( 'CPIWMNE_PLUGIN_SHORT', 's3-client' );
}

// ================================
// = Amazon S3 Extension Base Dir =
// ================================
if ( defined( 'CPIWMSE_PLUGIN_BASENAME' ) ) {
	define( 'CPIWMSE_PLUGIN_BASEDIR', dirname( CPIWMSE_PLUGIN_BASENAME ) );
} else {
	define( 'CPIWMSE_PLUGIN_BASEDIR', 'cpi-wp-migration-s3-extension' );
}

// =============================
// = Amazon S3 Extension Title =
// =============================
if ( ! defined( 'CPIWMSE_PLUGIN_TITLE' ) ) {
	define( 'CPIWMSE_PLUGIN_TITLE', 'Amazon S3 Extension' );
}

// =============================
// = Amazon S3 Extension About =
// =============================
if ( ! defined( 'CPIWMSE_PLUGIN_ABOUT' ) ) {
	define( 'CPIWMSE_PLUGIN_ABOUT', '#' );
}

// ===========================
// = Amazon S3 Extension Key =
// ===========================
if ( ! defined( 'CPIWMSE_PLUGIN_KEY' ) ) {
	define( 'CPIWMSE_PLUGIN_KEY', 'cpiwmse_plugin_key' );
}

// =============================
// = Amazon S3 Extension Short =
// =============================
if ( ! defined( 'CPIWMSE_PLUGIN_SHORT' ) ) {
	define( 'CPIWMSE_PLUGIN_SHORT', 's3' );
}

// ================================
// = Unlimited Extension Base Dir =
// ================================
if ( defined( 'CPIWMUE_PLUGIN_BASENAME' ) ) {
	define( 'CPIWMUE_PLUGIN_BASEDIR', dirname( CPIWMUE_PLUGIN_BASENAME ) );
} else {
	define( 'CPIWMUE_PLUGIN_BASEDIR', 'cpi-wp-migration-unlimited-extension' );
}

// =============================
// = Unlimited Extension Title =
// =============================
if ( ! defined( 'CPIWMUE_PLUGIN_TITLE' ) ) {
	define( 'CPIWMUE_PLUGIN_TITLE', 'Unlimited Extension' );
}

// =============================
// = Unlimited Extension About =
// =============================
if ( ! defined( 'CPIWMUE_PLUGIN_ABOUT' ) ) {
	define( 'CPIWMUE_PLUGIN_ABOUT', '#' );
}

// ===========================
// = Unlimited Extension Key =
// ===========================
if ( ! defined( 'CPIWMUE_PLUGIN_KEY' ) ) {
	define( 'CPIWMUE_PLUGIN_KEY', 'cpiwmue_plugin_key' );
}

// =============================
// = Unlimited Extension Short =
// =============================
if ( ! defined( 'CPIWMUE_PLUGIN_SHORT' ) ) {
	define( 'CPIWMUE_PLUGIN_SHORT', 'unlimited' );
}

// ==========================
// = URL Extension Base Dir =
// ==========================
if ( defined( 'CPIWMLE_PLUGIN_BASENAME' ) ) {
	define( 'CPIWMLE_PLUGIN_BASEDIR', dirname( CPIWMLE_PLUGIN_BASENAME ) );
} else {
	define( 'CPIWMLE_PLUGIN_BASEDIR', 'cpi-wp-migration-url-extension' );
}

// =======================
// = URL Extension Title =
// =======================
if ( ! defined( 'CPIWMLE_PLUGIN_TITLE' ) ) {
	define( 'CPIWMLE_PLUGIN_TITLE', 'URL Extension' );
}

// =======================
// = URL Extension About =
// =======================
if ( ! defined( 'CPIWMLE_PLUGIN_ABOUT' ) ) {
	define( 'CPIWMLE_PLUGIN_ABOUT', '#' );
}

// =====================
// = URL Extension Key =
// =====================
if ( ! defined( 'CPIWMLE_PLUGIN_KEY' ) ) {
	define( 'CPIWMLE_PLUGIN_KEY', 'cpiwmle_plugin_key' );
}

// =======================
// = URL Extension Short =
// =======================
if ( ! defined( 'CPIWMLE_PLUGIN_SHORT' ) ) {
	define( 'CPIWMLE_PLUGIN_SHORT', 'url' );
}

// =============================
// = WebDAV Extension Base Dir =
// =============================
if ( defined( 'CPIWMWE_PLUGIN_BASENAME' ) ) {
	define( 'CPIWMWE_PLUGIN_BASEDIR', dirname( CPIWMWE_PLUGIN_BASENAME ) );
} else {
	define( 'CPIWMWE_PLUGIN_BASEDIR', 'cpi-wp-migration-webdav-extension' );
}

// ==========================
// = WebDAV Extension Title =
// ==========================
if ( ! defined( 'CPIWMWE_PLUGIN_TITLE' ) ) {
	define( 'CPIWMWE_PLUGIN_TITLE', 'WebDAV Extension' );
}

// ==========================
// = WebDAV Extension About =
// ==========================
if ( ! defined( 'CPIWMWE_PLUGIN_ABOUT' ) ) {
	define( 'CPIWMWE_PLUGIN_ABOUT', '#' );
}

// ========================
// = WebDAV Extension Key =
// ========================
if ( ! defined( 'CPIWMWE_PLUGIN_KEY' ) ) {
	define( 'CPIWMWE_PLUGIN_KEY', 'cpiwmwe_plugin_key' );
}

// ==========================
// = WebDAV Extension Short =
// ==========================
if ( ! defined( 'CPIWMWE_PLUGIN_SHORT' ) ) {
	define( 'CPIWMWE_PLUGIN_SHORT', 'webdav' );
}
