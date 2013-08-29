<?PHP
/**
 * repoDoc main execution file
 *
 * This should work with PHP >= Version 4.1.2
 * If there are any problems on a version, email me at bugs@brynmosher.com.
 * Even 
 *
 * @package repoDoc
 * @author Bryn Mosher
 */

// keep this away from web servers
if ( array_key_exists( 'SERVER_SIGNATURE', $_SERVER ) ) {
	header("HTTP/1.0 501 Not Implemented");
	exit(501);
}

// set some surefire things that need to be done
ini_set("html_errors", 0 );
ini_set( "display_errors", 1 );
error_reporting( E_ALL );
if ( !defined( "PHP_EOL" ) ) {
	/**
	* PHP_EOL for PHP versions older than 4.3.x
	*/
	if ( preg_match( "/windows/i", $_SERVER["OS"] ) ) {
		define( "PHP_EOL", "\r\n" );
	} else {
		define( "PHP_EOL", "\n" );
	}
}

/**
* pdpDoc destination
*/
$GLOBALS["doxDestination"] = FALSE;
/**
* CVS repository to check out
*/
$GLOBALS["cvsRepos"] = FALSE;
/**
* logfile file name
*/
$GLOBALS["logfile"] = FALSE;
/**
* log file resource handle
*/
$GLOBALS["logResource"] = FALSE;
/**
* Local sources to have phpDoc parse (from --nocheckout)
*/
$GLOBALS["sourceLocal"] = FALSE;
/**
* Subversion repository to check out
*/
$GLOBALS["svnRepos"] = FALSE;

/**
 * Require the functions file
 */
require_once( dirname( __FILE__ ) . "/repoDoc_functions.php" );
if ( array_key_exists( 'argc', $_SERVER ) ){
	$usedParms = array();
	if ( !$cmdOut = cmdLine() ) {
		pIt( "Could not parse arguments!", -1, 1 );
		helpThem( 1 );
	}
	if ( $cmdOut ) {
		if ( ($GLOBALS["doxDestination"] === FALSE ) ) {
			pIt( "No destination given. See --destination.", -1, 1 );
			helpThem( 1 );
		}
		if ( ( $GLOBALS["svnRepos"] === FALSE ) && ( $GLOBALS["cvsRepos"] === FALSE ) && ( $GLOBALS["sourceLocal"] === FALSE ) ) {
			pIt( PHP_EOL . "No repository or source given. See --cvs, --svn or --nocheckout." . PHP_EOL, -1 );
			helpThem( 1 );
		}
		pIt( $cmdOut[0] . PHP_EOL );
		pIt( $cmdOut[1] . PHP_EOL );
	}
} else {
	pIt( "Could not get arguments!", -1, 1 );
	helpThem( 1 );
}

