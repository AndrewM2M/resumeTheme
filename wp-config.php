<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */
 
// Include local configuration
if (file_exists(dirname(__FILE__) . '/local-config.php')) {
	include(dirname(__FILE__) . '/local-config.php');
}

// Global DB config
if (!defined('DB_NAME')) {
	define('DB_NAME', 'm2mdev');
}
if (!defined('DB_USER')) {
	define('DB_USER', 'm2mdev');
}
if (!defined('DB_PASSWORD')) {
	define('DB_PASSWORD', 'm2mdev-mysql');
}
if (!defined('DB_HOST')) {
	define('DB_HOST', 'localhost');
}

/** Database Charset to use in creating database tables. */
if (!defined('DB_CHARSET')) {
	define('DB_CHARSET', 'utf8');
}

/** The Database Collate type. Don't change this if in doubt. */
if (!defined('DB_COLLATE')) {
	define('DB_COLLATE', '');
}

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '+9p1y&.5:sAUGaXla@@Kn~3H:.c{i*D|TdL._Vr,+y{a0m{!W;Y%%`27w5+SBfQJ');
define('SECURE_AUTH_KEY',  'zr3=~.D{ql$8;<<A3`xB:kJ$F$AKj@+0@Rai`8^Em.GHtnC}$?[WBrx^4~EKB%-F');
define('LOGGED_IN_KEY',    'HR@AMW.pPto~Ok[ylTR]Wu,tks E.ZZHh((|WQ~LaqHw*#>a*M~(/F_WU.}714dB');
define('NONCE_KEY',        '%yIG=bfO~-mw!%J&?GOrvR9nAZ[uiSu]1P-f.mgZZ?Cu]3rmODg0!rk@OMxHAx;,');
define('AUTH_SALT',        'GR5kHt7kV2Hae?e(s1uHi[ZA4^j.}GiW*]qU=TY+Z?RdeTM,DF08J9+CPH%-7f6q');
define('SECURE_AUTH_SALT', 'LJ2=_f{gn-LU#pFQY4vp$cGnPj=*`l@GBB8_&{ (7,+k3Nd~1eVSKX=x{)x@x(m|');
define('LOGGED_IN_SALT',   '-BDZ=7-)AFmb46m@#*G+rGy4c8^3n#B=v#xby<4Uyv> [1-%Q(!-#DFV_c:RNwFi');
define('NONCE_SALT',       'e0(XO]hW1y |Ki[Q 3+X;6`)y$fNhXc j1%wRF#z|CFHW.O(8uE.9`$z IsIHUVv');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');


/**
 * Set custom paths
 *
 * These are required because wordpress is installed in a subdirectory.
 */
if (!defined('WP_SITEURL')) {
	define('WP_SITEURL', 'http://' . $_SERVER['SERVER_NAME'] . '/wordpress');
}
if (!defined('WP_HOME')) {
	define('WP_HOME',    'http://' . $_SERVER['SERVER_NAME'] . '');
}
if (!defined('WP_CONTENT_DIR')) {
	define('WP_CONTENT_DIR', dirname(__FILE__) . '/content');
}
if (!defined('WP_CONTENT_URL')) {
	define('WP_CONTENT_URL', 'http://' . $_SERVER['SERVER_NAME'] . '/content');
}


/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
if (!defined('WP_DEBUG')) {
	define('WP_DEBUG', true);
	define( 'WP_DEBUG_LOG', true );
	define( 'WP_DEBUG_DISPLAY', true );
	ini_set('display_errors', 1);
}

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
