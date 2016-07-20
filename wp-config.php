<?php


// ** MySQL settings ** //
/** The name of the database for WordPress */
define('DB_NAME', 'menusdev');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

define('AUTH_KEY',         'qj sr7`HS<Ji~qC5)TvtO4wWr13Tz>nO|eKeypw!0m:W3+W/oV7PCy=5<P.uxh1]');
define('SECURE_AUTH_KEY',  '=/L&+Xcu?#Y<{Y+c6PL{&pSzt+`|Yl9/bB+[E4&|Z-P,|Q+)MFe%1gTJsai{d)#)');
define('LOGGED_IN_KEY',    'al!+C!{RKAtXR$2eH<+$(57vy=d0;-:Tzg3iB>#YN}{+{{C_BsG=p<ZK-AY$b] -');
define('NONCE_KEY',        '-yO-<QKYrF `z,/q8$MWDG,?*vid)tm%uCW:]-)L=E~r*b6E,[=c3j93Cqyy+j=S');
define('AUTH_SALT',        ';:*1&7cSc35nD^Wa0~ H@|6Zn@tONm1f_{21Ppjxx8h&sCKL1o!ZSp8i|-Db_Lt-');
define('SECURE_AUTH_SALT', '<4.LI+#fyMs3HCuY:m?|*^Srd+G4*7#/tnLjow;E)Cw|_Pk@izK=R.f XtXZ167M');
define('LOGGED_IN_SALT',   'onA w4?8zDFp2uWN.$^#_-wo+]D-?z-xo!IlYp#wm/e0qpl%J|LT/6^z-55hgCB`');
define('NONCE_SALT',       'a)OgC-g,[(SaU(0c}L)h@08^7/:(Nou~N|@cmRw(O-~<idw4|Rv)C9N^*_=oSIjH');


$table_prefix = 'wp_';





/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
