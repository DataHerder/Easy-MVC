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
 * @package     Framework/Redirect
 * @license     GNU license
 * @version     1.0
 * @link        my.public.repo
 * @since       File available since
 */

namespace Framework\Redirect;

/**
 * This class is primarily used for defining relative paths.
 * For instance... your web url is:
 * www.something.com/1/2/3/something/else
 * and you wanted to get to 3, Redirect will calculate that for you
 * and give you the relative path
 * 
 * ex:
 * <?php $rel = \Redirect::get(); ?>
 * <a href="<?=$rel?>some_other_url">Some Other Url</a>
 * 
 * @package Framework
 * @subpackage Redirect
 */
final class Redirect {

	/** constructor is private as a static class **/
	private function __construct(){}

	/**
	 * 
	 * @var string
	 * @access public
	 * @static
	 */
	public static $redirect = null;

	/**
	 * Gets the redirect value of a relative path in context to the root
	 * you may want to define
	 * 
	 * If you don't define a root, it will go to the root of your url
	 * If you do, then it will go to that directory instead of the root url
	 * 
	 * @access public
	 * @param string|null $root
	 * @return string|boolean false on failure
	 */
	public static function get($root = null)
	{
		self::calc($root);
		return self::$redirect;
	}

	/**
	 * Calculates the relative path
	 * 
	 * @access private
	 * @param string|null $root
	 * @return string|boolean false on failure
	 */
	private static function calc($root = null)
	{
		if ($root == null) {
				$root = LAST_ROOT_DIR;
		}
		if (self::$redirect == null) {
			$directories = explode("/", $_SERVER['REQUEST_URI']);
			$i = $r = 0;
			// loop through and count how many subdirectories there are to the
			// root path
			while ($i == 0) {
				$arg = array_pop($directories);
				if ($arg == $root) {
					$i++;
				} else {
					$r++;
				}
				if ($r > 10) {
					$i++;
				}
			}
			// return the relative path by directories
			self::$redirect = str_repeat('../', abs($r-1));
		}
	}
}
