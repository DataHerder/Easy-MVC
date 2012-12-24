<?php
/**
 * EasyMVC
 * A fast lightweight Model View Controller framework
 *
 * Copyright (C) 2012  Paul Carlton
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
 * @category    EasyMVC
 * @package     Library
 * @license     GNU license
 * @version     1.0
 * @link        my.public.repo
 * @since       File available since
 */

namespace EasyMVC;

abstract class BootstrapAbstract {
	abstract protected function _init();
}

/**
 * Bootstrap class
 *
 * Sets up the environment
 * @package Library
 * @subpackage Bootstrap
 */
class Bootstrap extends BootstrapAbstract {

	/**
	 * Defines the current controller and keeps track of the root
	 *
	 * @var array
	 * @access private
	 */
	private $globals = array();

	/**
	 * The root directory of the site, used for redirects
	 * and correct routing
	 *
	 * @var string
	 * @access public
	 */
	const ROOT_DIR = ROOT_DIR;

	/**
	 * An array of functions that customizes the namespace path
	 *
	 * @var array
	 * @access protected
	 */
	protected static $registerPaths = array();

	/**
	 * constructer function
	 */
	public function __construct()
	{
		$this->requireHelpers();
		$this->globals['root'] = 'index';
		$this->globals['default_controller'] = 'Landing';
		$this->_init();
		spl_autoload_register('EasyMVC\Bootstrap::requireLibrary');
	}

	/**
	 * Require Helpers requires the needed helper function
	 * classes made to make the developers life easier
	 *
	 * @access private
	 * @param null
	 * @return null
	 */
	private function requireHelpers()
	{
		require_once('Helpers/Functions/Array.php');
		require_once('Helpers/Functions/Request.php');
	}

	/**
	 *
	 *
	 *
	 */
	public function __get($name)
	{
		if (!isSet($this->globals[$name])) {
			return null;
		} else {
			return $this->globals[$name];
		}
	}

	/**
	 * The _init function is a user defined function
	 * able to take extra parameters and change
	 * behavior in the bootstrap
	 *
	 * @access public
	 * @param null
	 * @return null
	 */
	protected function _init()
	{
		// a shell for the user
	}



	/**
	 * Carries the paths needed to autoload classes
	 *
	 * @var array
	 * @access protected
	 */
	protected static $paths = array(
		//'/Library/',
		//'/Application/',
	);

	/**
	 * Require Library is an auto load function
	 * It is registered in when constructing the bootstrap
	 *
	 * @param String $class_name
	 * @return null
	 */
	public static function requireLibrary($class_name)
	{
		// for here we want to shift the first
		$dir = $_SERVER['DOCUMENT_ROOT'].self::ROOT_DIR;
		if (preg_match("@Api/?$@", $dir)) {
			$dir = preg_replace("@Api/?$@", "", $dir);
		}
		$parts = explode("\\", $class_name);
		if ($parts[0] == 'EasyMVC') {
			// We are taking of the package name EasyMVC
			array_shift($parts);
			array_unshift($parts,'Library');
		} elseif ($parts[0] == 'SqlBuilder') {
			array_unshift($parts,'Framework');
			array_unshift($parts,'Library');
		}
		if (!empty(self::$registerPaths)) {
			foreach (self::$registerPaths as $Func) {
				if (is_callable($Func)) {
					$Func($parts);
				}
			}
		}

		$file_dir = $dir.'/'.join("/", $parts).".php";
		if (is_readable($file_dir)) {
			require_once($file_dir);
		}
	}

	protected function registerPath($func)
	{
		if (is_callable($func)) {
			array_push(self::$registerPaths, $func);
		}
	}

}

/**
 * A shell class for bootstrap exception
 *
 */
class BootstrapException extends \Exception {}

