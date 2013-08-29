<?PHP
/**
 * repoDoc functions file
 * I stole some of this code from the XMail Log Archiver (myself - I plan to eventually sue myself for being a jerk about the negotiations someday).
 * To see where it came from, take a look at http://xmlogarch.sourceforge.net.
 *
 * @package repoDoc
 * @author Bryn Mosher
 */

// keep this away from web servers
if ( array_key_exists( 'SERVER_SIGNATURE', $_SERVER ) ) {
	header("HTTP/1.0 501 Not Implemented");
	exit(501);
}

#
# PHP < 5 versions of PHP 5 functions
# see comment at the end of this file for a complete list of functions to watch out for

if ( !function_exists( "scandir" ) ) {
	/**
	 * This implements scandir() for those this PHP < 5
	 */
	function scandir ( $directory, $sorting_order = 0 ) { # note that the context option is not implemented
		# sorting order can be true or false (true for descending alpha order )
		$retVal = FALSE;
		if ( $opDir = opendir( $directory ) ) {
			while ( ( $file = readdir( $opDir ) ) !==  FALSE ) {
				$retVal[] = $file;
			}
			if ( $sorting_order ) {
				rsort( $retVal );
			} else {
				sort( $retVal );
			}
		}
		return $retVal;
	}
}

if ( !function_exists( "array_combine" ) ) {
	/**
	 * This implements array_combine() for those this PHP < 5
	 */
	function array_combine ( $keys, $values ) {
		$retVal = false;
		if ( is_array( $keys ) ) {
			if ( is_array( $values ) ) {
				if ( count( $keys ) == count( $values ) ) {
					$keyNames = array_values( $keys );
					$keyVals = array_values( $values );
					$keepUp = 0;
					while ( $keepUp < count( $keys ) ) {
						$thiskey = $keyNames[$keepUp];
						$retVal[$thiskey] = $keyVals[$keepUp];
						$keepUp++;
					}
				} else {
					debug_backtrace();
					$trace = debug_backtrace();
					$log = " array_combine(): Both parameters should have equal number of elements in " . $trace[0]["file"] . " on line " . $trace[0]["line"] . " triggered";
					trigger_error( $log, E_USER_WARNING );
				}
			} else {
				debug_backtrace();
				$trace = debug_backtrace();
				$log = "array_combine() expects parameter 2 to be array, " . gettype( $keys ) . " given in " . $trace[0]["file"] . " on line " . $trace[0]["line"] . " triggered";
				trigger_error( $log, E_USER_WARNING );
			}
		} else {
			debug_backtrace();
			$trace = debug_backtrace();
			$log = "array_combine() expects parameter 1 to be array, " . gettype( $keys ) . " given in " . $trace[0]["file"] . " on line " . $trace[0]["line"] . " triggered";
			trigger_error( $log, E_USER_WARNING );
		}
		return $retVal;
	}
}

/**
 * Checkout source from CVS
 */
function checkout_cvs ( $repos = FALSE, $destination = FALSE ) {
	$retVal = FALSE;
//	exec( $cmd, $execOut, $errLvl );
//	switch ( $errLvl ) {
//	}
# see http://us3.php.net/manual/en/function.proc-open.php
	return $retVal;
}

/**
 * Checkout source from Subversion
 */
function checkout_svn ( $repos = FALSE, $destination = FALSE ) {
	$retVal = FALSE;
//	exec( $cmd, $execOut, $errLvl );
//	switch ( $errLvl ) {
//	}
# see http://us3.php.net/manual/en/function.proc-open.php
	return $retVal;
}

/**
 * Array of command line arguments to stored code and help text.
 * A function is a handy container just in case someone wants to do more reactive things.
 * Since this information is also only really called from within cmdLine(), it won't stay persistant. 
 * Thus it can grow to be as large as it needs without fear of eating ram during other processing after startup.
 */
function cmdArgs () {
	# each of these is an array of ( code to execute, usage, help text, required parm, optional even with parm )
	# SVN example:
	# svn co https://svn.sourceforge.net/svnroot/phpmyadmin/trunk/phpmyadmin phpmyadmin
	# CVS example:
	# cvs -z3 -d:pserver:anonymous@webextreme.cvs.sourceforge.net:/cvsroot/webextreme co -P modulename
	$retVal = array(
		"-c" => array( '
			if ( isset( $_SERVER["argv"][$parmCount + 1] ) ) {
				$GLOBALS["usedParms"][$parmCount] = $cmdParm . " " . $_SERVER["argv"][$parmCount + 1];
				$GLOBALS["cvsRepos"] = trim( $_SERVER["argv"][$parmCount + 1] );
			} else {
				pIt( "Bad parameter passed to " . $cmdParm . " (" . $_SERVER["argv"][$parmCount + 1] . "). Bad CVS repository..", -1, 1 );
				helpThem(1);
			}',
				"[-c|--cvs]",
				"CVS repository path to check out. Please provide the full path to remote repositories. For example, STUFF \"-c THINGS\".",
				"location" ),
		"-s" => array( '
			if ( isset( $_SERVER["argv"][$parmCount + 1] ) ) {
				$GLOBALS["usedParms"][$parmCount] = $cmdParm . " " . $_SERVER["argv"][$parmCount + 1];
				$GLOBALS["svnRepos"] = trim( $_SERVER["argv"][$parmCount + 1] );
			} else {
				pIt( "Bad parameter passed to " . $cmdParm . " (" . $_SERVER["argv"][$parmCount + 1] . "). Bad subversion repository.", -1, 1 );
				helpThem(1);
			}',
				"[-s|--svn]",
				"Subversion repository path to check out. Please provide the full path to remote repositories. For example, \"-s svn+ssh://somehost/svn/project/trunk\".",
				"location" ),
		"-d" => array( '
			if ( isset( $_SERVER["argv"][$parmCount + 1] ) && is_dir( $_SERVER["argv"][$parmCount + 1] ) ) {
				$GLOBALS["usedParms"][$parmCount] = $cmdParm . " " . $_SERVER["argv"][$parmCount + 1];
				$GLOBALS["doxDestination"] = trim( $_SERVER["argv"][$parmCount + 1] );
			} else {
				pIt( "Bad parameter passed to " . $cmdParm . " (" . $_SERVER["argv"][$parmCount + 1] . "). Destination for phpDocumentor output is invalid or does not exist.", -1, 1 );
				helpThem(1);
			}',
				"[-d|--dest|--destination]",
				"Destination of the pdpDocumentor output.",
				"directory" ),
		"-f" => array( '
			if ( isset( $_SERVER["argv"][$parmCount + 1] ) ) {
				$GLOBALS["usedParms"][$parmCount] = $cmdParm . " " . $_SERVER["argv"][$parmCount + 1];
				$GLOBALS["phpdocFormat"] = trim( $_SERVER["argv"][$parmCount + 1] );
			} else {
				pIt( "Bad parameter passed to " . $cmdParm . " (" . $_SERVER["argv"][$parmCount + 1] . "). Bad phpDoc output format.", -1, 1 );
				helpThem();
			}',
				"[-f|--format]",
				"phpDoc output format. The default is \"HTML:frames:default\". Only one format is allowed (for now).",
				"location",
				"optional"
				),
		"-k" => array( '
			$GLOBALS["usedParms"][$parmCount] = $cmdParm;
			$GLOBALS["keep"] = TRUE;
			',
				"[-k|--keep]",
				"Keep checked out working copy from repository",
				NULL,
				"optional"
				),
		"-l" => array( '
			if ( isset( $_SERVER["argv"][$parmCount + 1] ) && ( $GLOBALS["logResource"] = fopen($_SERVER["argv"][$parmCount + 1], "x" ) ) ) {
				$GLOBALS["usedParms"][$parmCount] = $cmdParm . " " . $_SERVER["argv"][$parmCount + 1];
				$GLOBALS["logfile"] = trim( $_SERVER["argv"][$parmCount + 1] );
			} else {
				pIt( "Bad parameter passed to " . $cmdParm . " (" . $_SERVER["argv"][$parmCount + 1] . "). Bad log file name", -1, 1 );
				helpThem(1);
			}',
				"[-l|--log]",
				"Output repository fetch and phpDoc command output to filename. The default filname is \"repodoc.log\" in the current working directory.",
				"(filename)",
				"optional"
				),
		"-n" => array( '
			if ( isset( $_SERVER["argv"][$parmCount + 1] ) && is_dir( $_SERVER["argv"][$parmCount + 1] ) ) {
				$GLOBALS["usedParms"][$parmCount] = $cmdParm . " " . $_SERVER["argv"][$parmCount + 1];
				$GLOBALS["sourceLocal"] = trim( $_SERVER["argv"][$parmCount + 1] );
			} else {
				pIt( "Bad parameter passed to " . $cmdParm . " (" . $_SERVER["argv"][$parmCount + 1] . "). Source directory for phpDocumentor input is invalid or does not exist.", -1, 1 );
				helpThem(1);
			}',
				"[-n|--nocheckout]",
				"Do not attempt any revisioning operations and assume source to parse documantation from is directory.",
				"directory",
				"optional"
				),
		"-q" => array( '
			$GLOBALS["usedParms"][$parmCount] = $cmdParm;
			$GLOBALS["quiet"] = trim( $_SERVER["argv"][$parmCount] );
			',
				"(-q|--quiet)",
				"Quiet mode. Supresses console output of external utilities.",
				),
		"-h" => array( '# -h is used in cmdLine() as a switch example',
				"(-h|--help)",
				"Display help text and exit." ),
	);
	// these are the long form equivalents of the above
	$retVal["--cvs"] = array( $retVal["-c"][0] );
	$retVal["--destination"] = array( $retVal["-d"][0] );
	$retVal["--dest"] = array( $retVal["-d"][0] );
	$retVal["--keep"] = array( $retVal["-k"][0] );
	$retVal["--log"] = array( $retVal["-l"][0] );
	$retVal["--nocheckout"] = array( $retVal["-n"][0] );
	$retVal["--quiet"] = array( $retVal["-q"][0] );
	$retVal["--svn"] = array( $retVal["-s"][0] );
	$retVal["--help"] = array( $retVal["-h"][0] );
	return $retVal;
}

function cmdLine () {
	$valid = cmdArgs();
	$parmCount = 0;
	$retVal = FALSE;
	foreach ( $_SERVER['argv'] as $cmdParm ) {
		switch ( $cmdParm ) { # for testing
			case "-h":
			case "--help":
				helpThem();
				exit( 0 );
				break;
		}
		$lowParm = strtolower( $cmdParm );
		if ( isset( $valid[$lowParm] ) ) {
			eval( $valid[$lowParm][0]);
		}
		#catch report directves
		$parmCount++;
	}
	if ( count( $_SERVER["argc"] ) > 0 ) {
		$fullLine = "Command Line: '" . implode( " ", $_SERVER['argv'] ) . "'";
		$useLine = "Using Parameters: '" . implode( " ", $GLOBALS["usedParms"] ) . "'";
		$retVal = array( $fullLine, $useLine );
	}
	return $retVal;
}

function helpThem ( $exitVal = FALSE ) {
	$valid = cmdArgs();
	$options = "Options:" . PHP_EOL;
	$useLine = "";
	foreach ( $valid as $cArg ) {
		if ( array_key_exists( 1, $cArg ) ) {
			$text = "";
			if ( array_key_exists( 3, $cArg ) ) {
				$useLine .= ( array_key_exists( 4, $cArg ) ) ? " (" . $cArg[1] . " " . $cArg[3] . ")" : " [" . $cArg[1] . " " . $cArg[3] . "]";
			} else {
				$useLine .= " " . $cArg[1];
			}
			$optage = str_replace( "|", ", ", $cArg[1] );
			$optage = str_replace( array( "(", ")" ) , "", $optage );
			$optage = "  " . str_replace( array( "[", "]" ) , "", $optage );
			if ( array_key_exists( 2, $cArg ) ) {
				$text .= str_pad( $optage, 29, " ", STR_PAD_RIGHT );
				$firstLine = substr( $cArg[2], 0, strpos( wordwrap( $cArg[2], 50, PHP_EOL ) . PHP_EOL, PHP_EOL ) );
				$text .= $firstLine . PHP_EOL;
				$rest = str_replace( $firstLine, "",  $cArg[2] );
				if ( array_key_exists( 3, $cArg ) && is_string( $cArg[3] ) ) {
					$rest .= "\nREQUIRED: " . $cArg[3] . PHP_EOL;
				}
				if ( !( trim( $rest ) == "" ) ) {
					$doc = trim( wordwrap( $rest, 49, PHP_EOL ) );
					$textExp = explode( PHP_EOL, $doc );
					foreach( $textExp as $key => $textLine ) {
						$text .= str_repeat( " " , 31 ) . $textLine . PHP_EOL ;
					}
				}
			} else {
				$text .= str_pad( $optage, 29, " ", STR_PAD_RIGHT );
				$text .= "No documentation written." . PHP_EOL;
			}
			$options .= trim( $text, PHP_EOL ) . PHP_EOL;
		}
	}
	if ( getenv("wpid") ) {
		$usage = wordwrap( "Bash Wrapper Usage: repoDoc" . $useLine . PHP_EOL, 78, PHP_EOL . "  " );
		$finale = wordwrap( "Alternate Usage: This script can also be run directly from a shell with the CLI version of PHP." . PHP_EOL, 78, PHP_EOL . "  " );
		$finale .= wordwrap( "PHP CLI Usage: php -f " . basename( $_SERVER['SCRIPT_NAME'] ) . " --" . $useLine . PHP_EOL, 78, PHP_EOL . "  " );
	} else {
		$usage = wordwrap( "PHP CLI Usage: php -f " . basename( $_SERVER['SCRIPT_NAME'] ) . " --" . $useLine . PHP_EOL, 78, PHP_EOL . "  " );
		$finale = wordwrap( "Alternate Usage: This script can also be run with a bash wrapper called 'repoDoc'." . PHP_EOL, 78, PHP_EOL . "  " );
		$finale .= wordwrap( "Bash Wrapper Usage: repoDoc" . $useLine . PHP_EOL, 78, PHP_EOL . "  " );
	}
	$description = "This script will attempt to check out either Subversion or CVS repository, run phpDocumentor against it and then clean up after itself.";
	print wordwrap( $description, 78, PHP_EOL . "  " ) . PHP_EOL;
	print $usage;
	print $options;
	if ( $finale ) {
		print $finale;
	}
	if ( !$exitVal === FALSE ) {
		exit($exitVal);
	}
}

function pIt( $pri, $verbose = NULL, $errorPrint = FALSE ) {
	if ( $verbose === NULL ) {
		$verbose = $GLOBALS['verbose'];
	}
	if ( $errorPrint == TRUE ) {
		$pri= PHP_EOL . "ERROR: " . $pri . PHP_EOL . PHP_EOL;
	}
	if ( ( $verbose == -1 ) or ( $verbose == TRUE ) ){ //error flag is -1 *always print*
		print $pri;
	}
}
?>