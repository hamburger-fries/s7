<?php
define('WP_AUTO_UPDATE_CORE', 'minor');// This setting is required to make sure that WordPress updates can be properly managed in WordPress Toolkit. Remove this line if this WordPress website is not managed by WordPress Toolkit anymore.
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

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 's72_wprasta');

/** MySQL database username */
define('DB_USER', 's72_ocean');

/** MySQL database password */
define('DB_PASSWORD', 'hardnugs');

/** MySQL hostname */
define('DB_HOST', 'mysql');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '+{$%&.kniFSy^$}KxuYOWw@86*szH9ZLl%R4K/*z#$;1!rrsz3Um*y]7t0loTIYe');
define('SECURE_AUTH_KEY',  '>R+3h|OV5/WbC,Lvv(_c0TJR/B6=(KIm&c3/fVU3f)$9gQt0RZt=+}}6tSC5%Zl;');
define('LOGGED_IN_KEY',    '?]@.Ec4(5UbEP]h4PGY[-_du;2lU)24+J~*Pz+ #WF0I)z2_f:2+O|#`q42X5V^t');
define('NONCE_KEY',        'H2EN9uM*|PU0$(eOeCYUyhN:0c3g.Hct OK_>1S:xjAgCW~@z,$RW`^Q?;-KFJ.2');
define('AUTH_SALT',        '=u.xOM2qYFP 7.W[TIu=AkRi#)pp#Z1_+H3KE!A>Xs4=<k0&eh.C.WI<r|S}?: 2');
define('SECURE_AUTH_SALT', '4cWzE}~x-3/2Bogf5g|+=]:u(n);I1L+z,3#f^y8t(s,)wgH#u%pVa/WzoykTs~`');
define('LOGGED_IN_SALT',   'iWHaa6pcLGjr ^uYaFK?Ffi69Q@t!<vcWd aa2@B9n+K}~9[=Q4@Eyzs|fNX-N9m');
define('NONCE_SALT',       '^`%gZwi`jJN_W/<0hC@.!-y4qI par(A+2m19(FCWm8r+JIp/7q_C_KjEF{2WF~X');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'ulw_';

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
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
