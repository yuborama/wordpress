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
define( 'AUTH_KEY',          'yQIHG1{2([:Bh3X4. $OXw4QZDbc{7k-O9],*yc^8wxE.y]R^}3:T<2T`c77^2XN' );
define( 'SECURE_AUTH_KEY',   'Q8wz]IP|]nM{st3p*:MnmP:X+Yp@.>Pv*]:^hVS=944)h[4&va]:M;gmp_/LXtQK' );
define( 'LOGGED_IN_KEY',     'H*e#U=DMo=4T]Pgm<cHcGB[JaoAx;fwD8}3&2q@PgjB6`(AyR/%7=bq87 RR*+~r' );
define( 'NONCE_KEY',         'o|7BJB]YM_jiFu%dk7kwY2sISXPi2+nf>uI`;Nb~Ao<8`1`M#Z]XS62U133iIaQz' );
define( 'AUTH_SALT',         'Oe9^|qH)gydnMA]z*[ I{;:J`F,#U?|AWDO<OHwB_NZlfFSpgqI#.(QVVJQy?pLt' );
define( 'SECURE_AUTH_SALT',  'g/2AS55$i!jr2.>@ 28w:@wRrAlu=53Xb#k6O:_a`s^}@j^wS-f#-Q;,jAR5@G7T' );
define( 'LOGGED_IN_SALT',    '##q$J;WwVyYt&IkH!vymr=oWa9%4mY,M~SWwe|Yx,i.:qgi9X#Q:LASHEx`YL8/R' );
define( 'NONCE_SALT',        '%DWOo`@C0yN@QcSds|[ZVVsYj;#q0C!(@R<7eoCT^;7](CKs9`?eP=noUGeV>38N' );
define( 'WP_CACHE_KEY_SALT', '5/H;61obs8PF;^xB?TO(L`t=FzG}zX(-eM4TNMiaKBT`~FhlUtCW=kpa4?qfpV5%' );


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
