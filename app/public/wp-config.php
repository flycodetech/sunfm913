<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',          'mN7JIm(R3iuqk{n*AoD>1;4m[*S/N@`H7y;VYC(n|V4ptRY0vX^RFdm7`=,{,C? ' );
define( 'SECURE_AUTH_KEY',   '1^8T(E*BwZqks>*^A0-3/xJm|j@y6DDQX7X2ML{$eO~#a&UwmQ}^B1Ko]y@B6BJ[' );
define( 'LOGGED_IN_KEY',     '3)3;fH4`wm4B~T:m;VbugOXofz-pX+S4YMDt!Q[?H[tCTg(Eai4#3Lc{5$;U}ic@' );
define( 'NONCE_KEY',         'Ffx0L_u;6*NY@En8N$lC`~re+k@<bGG=FD2c oyVggiA dVb(6sSD(AZ-If_gB9&' );
define( 'AUTH_SALT',         'DG#:%uQZOO6$1%r5,PS)[!2E405T@6gF)2[uSCxw;Tf,<i;HK/)~Fp1ORsxwkv6V' );
define( 'SECURE_AUTH_SALT',  '](%Xd/Lxth1`*.!JL/A1pL&~^}dj=#t]W$D[c^mh:Z;D+rI;Z>qsrln5c1]ms~y[' );
define( 'LOGGED_IN_SALT',    'tBUY97BV3:IB!<jnkI*O`x&q^TU^uTs#jO+JHGo~+Qg!w00/X&dKot=4[l?!nc7y' );
define( 'NONCE_SALT',        'ltVqXEC{@cPs<*rXCU~oSZG!7V{LrYRZ;B>O%+]8lp3]55 eGH$s=y6n@ubQX@Q:' );
define( 'WP_CACHE_KEY_SALT', 'JehZ#Wv[n3?L1P:UEiM!=%##<foO8H7Mx:}Ycm EXACmrN4!!yhJ;2X-;2odnN2<' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
