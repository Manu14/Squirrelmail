<?php
/** SquirrelSpell Configuration file. **/

// Just for poor wretched souls with E_ALL. :)
global $username, $data_dir;

/** 
   SPELL-CHECKING APPLICATIONS:
   ----------------------------
   This feature was added/changed in 0.3. Use this array to set up
   which dictionaries are available to users. If you only have 
   English spellchecker on your system, then let this line be:

   $SQSPELL_APP = array("English" => "ispell -a");

   or

   $SQSPELL_APP = array("English" => "/usr/local/bin/aspell -a");

   Sometimes you have to specify full path for PHP to find it.
   Aspell is a better spell-checker than Ispell, so you're encouraged
   to use it.

   If you want to have more than one dictionary available to users,
   configure the array to look something like this:

   $SQSPELL_APP = array(
			"English" => "aspell -a",
                        "Russian" => "ispell -d russian -a",
			...
			"Swahili" => "ispell -d swahili -a"
		       );
   
   Watch the commas, making sure there isn't one after your last
   dictionary declaration. Also, make sure all these dictionaries
   are available on your system before you specify them here.
   
   Whatever your setting is, don't omit the "-a" flag.

								**/
$SQSPELL_APP = array("English" => "ispell -a");

/**
   DEFAULT DICTIONARY
   -------------------
   Even if you're only running one dictionary, still specify which one 
   is the default. Watch the case -- it has to be exactly as in array
   you declared in $SQSPELL_APP.	
   								**/
$SQSPELL_APP_DEFAULT="English";

/**
   USER DICTIONARY:
   -----------------
   $SQSPELL_WORDS_FILE is a location and mask of a user dictionary file. 
   The default setting should be OK for most everyone. Read PRIVACY and
   CRYPTO in the "doc" directory.
								**/
$SQSPELL_WORDS_FILE = "$data_dir/$username.words";

/**
   CASE SENSITIVITY:
   ------------------
   Use $SQSPELL_EREG="ereg" for case-sensitive matching of user 
   dictionary, or $SQSPELL_EREG="eregi" for case-insensitive 
   matching. It is advised to use case-sensitive matching.
   								**/
$SQSPELL_EREG="ereg";

/**
   SOUP NAZI (AVOIDING BAD BROWSERS)
   -------------------------------------
   Since some browsers choke on JavaScript, here is an option to disable the
   browsers with known problems. All you do is add some part of an USER_AGENT 
   string of an offending browser which you want to disable and users will not
   know about this plugin. E.g. browsers with "Mozilla/4.61 (Macintosh, I, PPC)"
   USER_AGENT string will get weeded out if you provide "Macintosh" in the 
   config string.
  
   Mozilla/2 -- You're kidding, right?
   Mozilla/3 -- known not to work
   Opera -- known not to work
   Macintosh -- Netscape 4.x on Macintosh chokes for some reason. 
                Adding until resolved.
								**/
$SQSPELL_SOUP_NAZI = "Mozilla/3, Mozilla/2, Opera, Macintosh";

/** 
   VERSION:
   ---------
   SquirrelSpell version. Don't modify, since it identifies the format
   of the user dictionary files and messing with this can do ugly 
   stuff. :)
   								**/
$SQSPELL_VERSION="v0.3b";

?>
