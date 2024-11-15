<?php
define( 'WP_CACHE', true );

/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'brh_wp' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

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
define( 'AUTH_KEY',         'R^|xi)9OaM1t|$D@_v/q>Pg.o~s`kJ|*iN=XGNRUhl |:g},_Do--p$(a}Crn?PB' );
define( 'SECURE_AUTH_KEY',  '(Q~ $1))EyQhH(]=^@!JZT}CW+G>0q6J><8yy1yNj!I>(B{_V4j&V#aPvUcWJP`t' );
define( 'LOGGED_IN_KEY',    'D !c#L$C<PmkNm1Hax6},0<4%2b*` T*yzhPry4p.pdg!^ONh&N8Pf:~%vRzL+te' );
define( 'NONCE_KEY',        'gJOqjm>eekp5)d6|{9)W*`.0~eZv~/,FF8 l4_1(%:4?FzpN%C|XN#do3U#b+OBN' );
define( 'AUTH_SALT',        '/t{`4$pt?bY2lrWDIm7d1/|)7<~pB%Y{DKMtPJs(0=k1`Ys5yIuc95nzT9Rhf%!~' );
define( 'SECURE_AUTH_SALT', '3IcaivNJH_{G=f^f-I@[|&ed}S,FRVT4Retg}C?U3QY]t!U<t$g-;)d&br/B([D8' );
define( 'LOGGED_IN_SALT',   '+bHy4r<X[hdEDK]3*Sp-3bX];G0c#l/X;U>3)a-C14~>urmRe_l&Tb+w]HaxF_]0' );
define( 'NONCE_SALT',       'Z<Fzn3-SMqj.%`_=C1M7kRLMYeSK[?tY,Q,@<p&+fo8.t>v.RGm^3Yk-t}5b)%Hs' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'brh_';

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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
