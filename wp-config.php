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

 * @link https://wordpress.org/support/article/editing-wp-config-php/

 *

 * @package WordPress

 */

// ** MySQL settings - You can get this info from your web host ** //

/** The name of the database for WordPress */



define('DB_NAME', 'yogawje8_WPEJ5');

/** MySQL database username */

define('DB_USER', 'yogawje8_WPEJ5');

/** MySQL database password */

define('DB_PASSWORD', 'ClGn(WIxe<%tJ*[A-');

/** MySQL hostname */

define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */

define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */

define( 'DB_COLLATE', '' );

/**#@+

 * Authentication Unique Keys and Salts.

 *

 * Change these to different unique phrases!

 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}

 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.

 *

 * @since 2.6.0

 */

define('AUTH_KEY', 'b09437e0dfde4f39cb12e2041b589b01226083ffd36425027c1e7f3f959d9991');

define('SECURE_AUTH_KEY', 'df48eb14abc5c2d9adad65686fef50546b8f5f98fe24741309b7035d96193e43');

define('LOGGED_IN_KEY', 'b6fb7e81e83a98e3365198b583e9839b0ed6df44b79e269b64e49b6be8c58863');

define('NONCE_KEY', '435ea578f56f80b430c6489e7b2996c26396eb6f004cdecb6bc5c0e5825c380f');

define('AUTH_SALT', '2ed4222f730c4c85acf9e2fb80d0aa9754db4c5790baf401a3312020aa1bee1d');

define('SECURE_AUTH_SALT', '63b061df3715dd72442408b71329dbe34be958da242cf18643903ab232f96ddd');

define('LOGGED_IN_SALT', '12075eb571832e9a65e05c1f015930c995e5696ad014638fc320668e7861fc91');

define('NONCE_SALT', '0ac3bf239fe04a8cecf9da3783219aa3a1c63032c9f7390eacc473dd6e324fbb');

/**#@-*/

/**

 * WordPress Database Table prefix.

 *

 * You can have multiple installations in one database if you give each

 * a unique prefix. Only numbers, letters, and underscores please!

 */

$table_prefix = 'gzq_';

define('WP_CRON_LOCK_TIMEOUT', 120);

define('AUTOSAVE_INTERVAL', 300);

define('WP_POST_REVISIONS', 5);

define('EMPTY_TRASH_DAYS', 7);

define('WP_AUTO_UPDATE_CORE', true);

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

define( 'WP_DEBUG', false );

define( 'WP_DEBUG_DISPLAY', false );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */

if ( ! defined( 'ABSPATH' ) ) {

	define( 'ABSPATH', __DIR__ . '/' );

}


define('ADMIN_COOKIE_PATH', '/');

define('COOKIE_DOMAIN', '');

define('COOKIEPATH', '');

define('SITECOOKIEPATH', '');


/** Sets up WordPress vars and included files. */

require_once ABSPATH . 'wp-settings.php';