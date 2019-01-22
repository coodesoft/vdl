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
define('DB_NAME', 'vdl');

/** MySQL database username */
define('DB_USER', 'c00des0ft-vdl');

/** MySQL database password */
define('DB_PASSWORD', '**c00des0ft**');

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
define('AUTH_KEY',         ',_,8h5c4<<yTJ,`U^v(t+^HUTLfK:!s/H,VYDQHurg2.eloU|QvQN`.Q,1Aw^Ba;');
define('SECURE_AUTH_KEY',  'W0e*^Qh>(p!NA@pOGE%!<jMT)C~b0`4(R:Xs:wV3SD4O0+-qrNp6DXH6bsY,`N>=');
define('LOGGED_IN_KEY',    'N4;5o[/a17p7Fv:pNCKu;>xK_i-Jm68@[s[O3}%4:C_? ;=H),5(6Cp,aVs=-KJ<');
define('NONCE_KEY',        'h)rTD/0@AJxgo/m>=0CNU80#TZL[)}Sd>ond:d]c9@NT8SZq}3$p-ao=&>eVEy1.');
define('AUTH_SALT',        'p{vT&LQB$N|>VZLv4n3QM9HV/abAS_2QuGb.;UVLjmN|OE97d(r!zD+&y/%F.q3p');
define('SECURE_AUTH_SALT', ' 6rSpae1l+]TrcSAOO<6WaamJ_P6gp^;).HlT$~3$Cnn@k~7$1R`K%OQs6K|yg[;');
define('LOGGED_IN_SALT',   '(FH.UpF9)p{(wfK3,rw6St[=8C0Q$]kw=z F,@.XY)]joyK;rHcmf{LEFY6@;?YL');
define('NONCE_SALT',       'W}fjTDlvrc[WpT%cNVl##+b?BLFLxN;E)1v?[8nb=Sq<=7EQak`)KIdh^:-U9ek}');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
