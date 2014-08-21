<?php
/**
 * EasyMVC
 * A fast lightweight Model View Controller framework
 *
 * Copyright (C) 2014  Paul Carlton
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @author      Paul Carlton
 * @category    Model View Controller Framework
 * @package     EasyMVC
 * @license     GNU license
 * @version     1.0
 * @link        my.public.repo
 * @since       File available since
 */

/**
 * !!!!!!!! IMPORTANT !!!!!!!!!
 * !!                        !!
 * !! YOU CAN EDIT THIS FILE !!
 * !! YOU CAN EDIT THIS FILE !!
 * !! YOU CAN EDIT THIS FILE !!
 * !!                        !!
 * !!!!!!!!!!!!!!!!!!!!!!!!!!!!
 *
 * This file you can edit to define your own
 * constants or change the constants around
 * of constants that run the Library
 */

/*****
 * BELOW ARE CONSTANTS YOU CAN NOT DELETE!
 * PLEASE DO NOT DELETE THESE CONSTANTS
 *
 * THESE CONSTANTS WILL CAN BE CHANGED WITH
 * SUBSEQUENT UPDATES
 *
 * PLEASE NOTE:
 *   The update script will not override this
 *   file if found.  Simply copy and paste the
 *   the constants that are found within the new
 *   file into the area below marking the beginning
 *   and end of the framework constants shown below
 */

/////////////////////////////////////////////////////////
//
//  BEGIN FRAMEWORK CONSTANTS
//
/////////////////////////////////////////////////////////

/**
 * Here you define whether or not you are in production
 */
define('PRODUCTION', false);
if (PRODUCTION) {
	error_reporting(0);
} else {
	error_reporting(E_ALL ^ E_NOTICE);
}
/**
 * This logic takes the root directory and makes
 * a constant out of the ending root
 *
 */
$tmp = explode("/", CUR_DIR);
define('LAST_ROOT_DIR', array_pop($tmp));

/**
 * If a controller is found as a page, setting
 * this to true will redirect the url with a
 * permanent redirect 303
 */
define('REDIRECT_SLASH', true);


/**
 * Here you define that you want strict autoloading
 * where if a file is not found, the
 */
define('REQUIRE_FAIL_ON_AUTOLOAD', true);


/**
 * Show easymvc framework if no user function is defined
 * for handling and this is set to true
 */
define('SHOW_HTML_ON_LAST_EXCEPTION', true);


/**
 * Define the default view
 */
define('DEFAULT_CONTROLLER', 'Landing');


/**
 * The controller as case sensitive
 *
 * !IMPORTANT!
 * Controller is case sensitive then we don't mess with
 * the controller casing which is based off the url
 * that is put into the browser.  If it is we force:
 * ucwords($controller_variable)
 *
 * The reason we force ucwords() on the controller page is
 * because the naming convention is an uppercase on the
 * file.  It is important to keep this convention throughout the
 * application.
 *
 * All files that are included and are namespaced for auto loading
 * classes SHOULD and SHOULD ALWAYS be proper case eg:
 * NewsClass.php
 * PeopleModule.php
 *
 * Etc...
 */
define('CONTROLLER_CASE_SENSITIVE', false);


///////////////////////////////////////////////////////////
//
// END FRAMEWORK CONSTANTS
//
///////////////////////////////////////////////////////////




// ---------------- USER DEFINED CONSTANTS BELOW THIS POINT
// ---------------- END USER DEFINED CONSTANTS