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
/** The name of the database for WordPress */
define('DB_NAME', 'wordpress-maserati');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         'E+`%l0YeWc(2sTrA3J@aLx.>tt<Oyfr(i|>(*%1R`<@+m%~pSL#crA+I#Q{u[z.k');
define('SECURE_AUTH_KEY',  'uwvb[42;Fay9p[OHaIOSIcnp>:TQ{cv^,OIyj1(jo4)6DXHJLy v6!2}E{L?$4D5');
define('LOGGED_IN_KEY',    'AgvsBN&OUgau]j,Wmu$GXBkQ^fryZ70dn0G:9CFH_OZptvoKx{`$]d0<Q|{y?oP[');
define('NONCE_KEY',        'Xiae%k~9ejor$e7iU{O[r|s6cZ[6 i~pS!xU^7~RX3v,Gv|{3x^hmwsgZF1R.|f7');
define('AUTH_SALT',        'rB7nHN?Gz[g_U#~iT*=9S#~wdrn4x}5i(BUqf<T>1-fsN E~JY_ WyVNT8JyRoCA');
define('SECURE_AUTH_SALT', 'G|E,:D+n0,f8#{@ZfU(?0t>!Q0O3m1/,x;0bVfatWzs80s7_EvWB4Vu+8HLE<m n');
define('LOGGED_IN_SALT',   '#KfqP,[JjIQ {OFb9!ouk?!.K>l~B#d1tGh+7<g!) [1@<Ak!/L8i8mMHq@#m;xK');
define('NONCE_SALT',       'g/_.EP-LI:<*%#^OM#afGX}K{!m|U2FKT]]l-~#)$k=t.)13!XRNA%gCvlr6/l>o');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wordpress';

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
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
