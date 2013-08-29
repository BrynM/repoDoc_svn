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


//phpinfo();
/*
if [ $# -lt 2 ] # check number of args
then
        echo Usage: checkout_doc dest-dir repo-source [repo-type]
        echo   dest-dir     destination directory for the documentation
        echo   repo-source  network address of the repository
        echo   repo-type    "svn" or "cvs" - "svn" is the default
        exit 1
fi

destination=$1
echo Destination: $destination
repo=$2
repoHost=`echo $2 | sed -e '/[^\/]+/'`

echo $repoHost
#echo `ping -c 1 $2`
echo Repository: $repo
if [ $# -gt 2 ] # optional args
then
        repoType=svn
        if [ "$3" == "cvs" ]
        then
                repoType=cvs
        fi
        echo Repository Type: $repoType
fi
*/

#phpdoc -t /tmp/uioc -o HTML:frames:default -f /html_output/user_ioCleaner/user_ioCleanerInit.php -s

# plain default format
#phpdoc -t /tmp/uioc -o HTML:frames:default -d /html_output/user_ioCleaner -s

#echo --- Default Ready ---
#sleep 2

# phpEdit format
#phpdoc -t /tmp/uioc/phpedit -o HTML:frames:phpedit -d /html_output/user_ioCleaner -s

# HTML:DOM/default format
#phpdoc -t /tmp/uioc/dom -o HTML:frames:DOM/default -d /html_output/user_ioCleaner -s

# HTML:XML DocBook format
# phpdoc -t /tmp/uioc/xml -o XML:DocBook/peardoc2:default -d /html_output/user_ioCleaner -s

#chgrp -R webmasters /tmp/uioc
#chown -R bryn /tmp/uioc
#chmod -R o+r /tmp/uioc

?>