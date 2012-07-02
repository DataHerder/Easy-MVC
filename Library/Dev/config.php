<?php 

/**
 * This config file sets up the necessary
 * environment for you
 * 
 */

/**
 * Define the root directory
 * 
 */
define('ROOT_DIR', dirname($_SERVER['PHP_SELF']));
define('PRODUCTION', false);

/**
 * This logic takes the root directory and makes
 * a constant out of the ending root
 * 
 */
$tmp = explode("/", ROOT_DIR);
define('LAST_ROOT_DIR', array_pop($tmp));

///////////////////////////////////
// 
// Do not touch below this point!
// Internally set constants
//
///////////////////////////////////

if (PRODUCTION) {
	define('DEBUG', false);
} else {
	define('DEBUG', true);
}