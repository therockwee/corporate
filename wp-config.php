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
define('DB_NAME', 'db_corporate');

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
define('AUTH_KEY',         'E|KX?Fv_!)O>KyF)-7xB]GwZ}}/S8I;?CcKZB*&h7-/m@LPZ+,^C>/<;suKDr~[_');
define('SECURE_AUTH_KEY',  'raQA!0:}|/-#nXSs-*/Gvjmk3V|.RZDH9COoQGJ7?WF+WHs.ZmQjRw/Z-T-ef|2Z');
define('LOGGED_IN_KEY',    'b|V>A0{<?>BKM(p:H*8R&3|*8crr^zZP]-5V5LI+O@Qh`nz4O|VnE@c@AtL1c9C-');
define('NONCE_KEY',        '@q<`1)td:m;I,]%}[R{(W-xiSqlJlHg]qbb#2H<uO2keN=|?Kqo}ca&-.c->nsF[');
define('AUTH_SALT',        '-:!YosbiLAQAHtA+^N!%92&A?V~%zUcG21z#:GiX/n|/`~A$`Y@*4drkM~7>LGE4');
define('SECURE_AUTH_SALT', '`&@{phC%(L:)I..s?xaC:nyIu_*TfBu5d6wE/Qa=j._M[^`m7hcYv8{FFY6|[@)A');
define('LOGGED_IN_SALT',   '+cm=C&?|1S(u-+g$iZXuP0VLYFE~N_JHNY!:OTq/7^:nn+hLEaq-`{`*-23<]fy3');
define('NONCE_SALT',       'BR]).m)yTQe$h lhF7)ckb$Q2-~hWKa^*Kd;d=PrA+ftVPoS|w`Um .eYzR9GKhg');

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
