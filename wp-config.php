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

/** MySQL database username yogawje8_WPEJ5 */

define('DB_USER',       'yogawje8_WPEJ5');

/** MySQL database password */

define('DB_PASSWORD',       'Tzj3&8w9');

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

define('AUTH_KEY',       'HVSzMYMMg*OX4f6pg42Q9Kj%#Nx7F^G03U6wk%rNJmNIX(zuplLbqyYBQCgr(mJK');

define('SECURE_AUTH_KEY',       'FCVIdPsT%t6Xu2x1Kkb8KzbePo!zBl4MX%79ehrDA&!q4y)SlW*@n0BKTGnSdCEk');

define('LOGGED_IN_KEY',       'k@^#(I%2c7W2VLNrzTNHfH#eZsBs3n84zvrzuyCRbkFC3A0iOhj%!pON6LXdQkKD');

define('NONCE_KEY',       'BE1&dlxDzNhQpMi(WpyWuF5VIR99onV@QBo8B5CUYY^)cQ(&%O)eK)602(OTHe0k');

define('AUTH_SALT',       '#ZZi5ga)z*&osxcUADJc%5djkLaTIM4qzmCyLpu)LO1oK^eq0H9XaappUxrKyUR&');

define('SECURE_AUTH_SALT',       '4xPb&!YMvY#0qAakaCh96B9MpciiSHkQ4KyZoD!V9SnCJS1bsn6Hm22jC#Hj1@7z');

define('LOGGED_IN_SALT',       '2waM7AJ6frdZThoN7QLUCu1rTrN^cRIDn1Y3AhVVdvjV^QSduA&@VtsgCQtUk6TK');

define('NONCE_SALT',       'h*YC%IfpR!eU9qXbAmKN*ujyOwOZ0GHVG*&8kEqcM%kIYRcLHAmgL8WXnAFtDw7@');

/**#@-*/

/**

 * WordPress Database Table prefix.

 *

 * You can have multiple installations in one database if you give each

 * a unique prefix. Only numbers, letters, and underscores please!

 */

$table_prefix = 'gzq_';

// define('WP_CRON_LOCK_TIMEOUT', 120);

// define('AUTOSAVE_INTERVAL', 300);

// define('WP_POST_REVISIONS', 5);

// define('EMPTY_TRASH_DAYS', 7);

// define('WP_AUTO_UPDATE_CORE', true);

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

// Enable Debug logging to the /wp-content/debug.log file
define( 'WP_DEBUG_LOG', true );

define( 'WP_DEBUG_DISPLAY', true );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */

if ( ! defined( 'ABSPATH' ) ) {

	define( 'ABSPATH', __DIR__ . '/' );

}


// define('ADMIN_COOKIE_PATH', '/');

// define('COOKIE_DOMAIN', '');

// define('COOKIEPATH', '');

// define('SITECOOKIEPATH', '');


/** Sets up WordPress vars and included files. */

require_once ABSPATH . 'wp-settings.php';