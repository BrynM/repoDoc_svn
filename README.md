repoDoc_svn
===========

An old wrapper for Subversion and PHPDocumentor combined featuring temp checkouts and other such niceties. Someday to have git integrated... maybe.

Be Warned
===========

This was written many years ago and may seem a little antiquated. The last commit to the old repo was in 2008. repoDoc_functions.php had a last modified date in 2006 on my machine.

Also CVS support was never fully integrated and probably doesn't work at all.

Usage
===========

    [brynm@git /repoDoc_svn]# repoDoc -- -h
    This script will attempt to check out either Subversion or CVS repository, run
      phpDocumentor against it and then clean up after itself.
    PHP CLI Usage: php -f repoDoc.php -- [[-c|--cvs] location] [[-s|--svn]
      location] [[-d|--dest|--destination] directory] ([-f|--format] location)
      ([-k|--keep] ) ([-l|--log] (filename)) ([-n|--nocheckout] directory)
      (-q|--quiet) (-h|--help)
    Options:
      -c, --cvs                  CVS repository path to check out. Please provide
                                   the full path to remote repositories. For
                                   example, STUFF "-c THINGS".
    REQUIRED: location
      -s, --svn                  Subversion repository path to check out. Please
                                   provide the full path to remote repositories.
                                   For example, "-s
                                   svn+ssh://somehost/svn/project/trunk".
    REQUIRED:
                                   location
      -d, --dest, --destination  Destination of the pdpDocumentor output.
                                   REQUIRED: directory
      -f, --format               phpDoc output format. The default is
                                   "HTML:frames:default". Only one format is
                                   allowed (for now).
    REQUIRED: location
      -k, --keep                 Keep checked out working copy from repository
      -l, --log                  Output repository fetch and phpDoc command output
                                   to filename. The default filname is
                                   "repodoc.log" in the current working
                                   directory.
    REQUIRED: (filename)
      -n, --nocheckout           Do not attempt any revisioning operations and
                                   assume source to parse documantation from is
                                   directory.
    REQUIRED: directory
      -q, --quiet                Quiet mode. Supresses console output of external
                                   utilities.
      -h, --help                 Display help text and exit.
    Alternate Usage: This script can also be run with a bash wrapper called
      'repoDoc' if in a *nix environment.
    Bash Wrapper Usage: repoDoc [[-c|--cvs] location] [[-s|--svn] location]
      [[-d|--dest|--destination] directory] ([-f|--format] location) ([-k|--keep] )
      ([-l|--log] (filename)) ([-n|--nocheckout] directory) (-q|--quiet)
      (-h|--help)
    
    [brynm@git /repoDoc_svn]#
