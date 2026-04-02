<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
define('DB_NAME', 'adlibrum');

/** MySQL database username */
define('DB_USER', 'adlibrum');

/** MySQL database password */
define('DB_PASSWORD', 'WZ2cZI7pTe8SjhQV');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/** define('WP_ALLOW_REPAIR', true); */
define('WP_ALLOW_REPAIR', true);

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'YYLJ44qNNOfj38WBHXnffpddFxqsjlvoyCs7Sczq56lKLQCFxwA1DyFuMxCHZqMt');
define('SECURE_AUTH_KEY',  '4sFkunzqoxJAywvHANYJbLtxKdPRQi55LhuQqPqBJHe0qx57zcat9FtzpgRLFWaj');
define('LOGGED_IN_KEY',    'Xm1uIBvICNyLjQAz774ebSbfpDbqaOca43JYlEXFY5KBg84hr29fsvVDt16Y98Wu');
define('NONCE_KEY',        'toY1RRpvH9dRMYLsm6BS0qfOx7BcTRbugZw10FmJ2tTPo0ni7nUzziVXJYuYKxK4');
define('AUTH_SALT',        'nLja1gw7JAfEl2zcq7r3h4YiteubHCrSwJbmy0dlwfM4txr4Zhk1uUWOSLNyGq5f');
define('SECURE_AUTH_SALT', 'dg6N5hxKUCuia8z4NagXAcpFdQU4NKxUwRUAOiPAcv7hHzn4fKwErY4C3YPp0eX0');
define('LOGGED_IN_SALT',   'qMLipyzWgUtLgBwtGvyvr7bnABOq105Powf1ufxBvgwKTMiuk7epFfzZSh1YkRyY');
define('NONCE_SALT',       '7zGnqzZslY5epAud0pwaDrNkvBiS75Lxjn4C6Pvv6K7XSTzh2dIrPaTma32FqElG');

/**
 * Other customizations.
 */
define('FS_METHOD','direct');define('FS_CHMOD_DIR',0755);define('FS_CHMOD_FILE',0644);
define('WP_TEMP_DIR',dirname(__FILE__).'/wp-content/uploads');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
