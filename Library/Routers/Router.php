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
 * @package     Routers
 * @license     GNU license
 * @version     1.0
 * @link        my.public.repo
 * @since       File available since
 */

namespace EasyMVC\Routers;

/**
 * The Router class routes URLs to the correct destination and controller
 * 
 * @package Routers
 * @subpackage Router
 */
final class Router {

	/**
	 * 
	 * @var array
	 * @access private
	 */
	private $route = array();

	/**
	 * 
	 * @var \EasyMVC\Views\Errors\Error
	 * @access private
	 */
	private $Error = null;

	/**
	 * 
	 * @var \EasyMVC\Bootstrap
	 * 
	 */
	protected $Boostrap = null;

	/**
	 * Sets the route and variables
	 * needed by the router
	 * 
	 * @param \EasyMVC\Bootstrap
	 */
	public function __construct(\EasyMVC\Bootstrap $Bootstrap)
	{
		//debug_array($_GET);
		$route = $_GET['__library_router_route'];
		unset($_GET['__library_router_route']);
		$this->dir = $_SERVER['DOCUMENT_ROOT'].$Bootstrap::ROOT_DIR;
		$this->route = explode("/", $route);
		$this->Bootstrap = $Bootstrap;
		$this->Error = new \EasyMVC\Views\Errors\Error;
	}

	/**
	 * Gets the the controller needed to finish the request
	 * 
	 * If controller not found, throws a not found router exception
	 * 
	 * @throws \EasyMVC\Routers\RouterException
	 */
	public function getController()
	{
		list($file_name, $controller, $path) = $this->_traverseRoute();
		if (!empty($path)) {
			$route_dir = 'Application\Controllers\\'.join("\\", array_map('ucwords',$path));
		} else {
			$route_dir = 'Application\Controllers';
		}

		// assign the default controller
		if ($controller == '' || $controller == null) {
			$controller = $this->Bootstrap->default_controller;
		}

		// assign the file name root class to instantiate if exists
		$_controller = preg_replace("@/$@", '', $controller);
		$file_root_class = $route_dir.'\\'.ucwords($_controller).'\\'.$file_name;
		$controller_root_class = $route_dir.'\\'.ucwords($_controller);

		// check that the controller exists
		$root_dir = $this->dir.'/Application/Controllers/'.implode("/", array_map('ucwords', $path)).'/';
		$filename_root = $root_dir . ucwords($_controller) . '/' . $file_name;
		$controller_root = $root_dir . ucwords($_controller).'.php';


		if (is_readable($filename_root)) {
			return new $file_root_class;
		} elseif (is_readable($controller_root)) {
			return new $controller_root_class;
		} else {
			// oooohh... we may have filename controller
			$tmp1 = explode(".", $file_library);
			array_pop($tmp1);
			$tmp2 = explode(".", $file_application);
			array_pop($tmp2);
			$file_library = $file_library.'/'.join(".", $tmp1).'/'.$file_name.".php";
			$file_application = $file_application.'/'.join(".", $tmp2).'/'.$file_name.".php";
			if (is_readable($file_libaray)) {
				return new $controller_root_class . '\\' . $file_name;
			} elseif (is_readable($file_application)) {
				return new $controller_root_class . '\\' . $file_name;
			}
			throw new \EasyMVC\Routers\RouterException('Document not found');
		}

	}

	/**
	 * Helper function to get file name, controller and route
	 * from the request
	 * 
	 * @return array
	 */
	private function _traverseRoute()
	{
		$route = $this->route;
		$last = end($route);
		if (count($this->route) == 1) {
			$file_name = array_pop($route);
			$controller = 'Landing'; //default controller
			return array($file_name, $controller, $route);
		} elseif (count($this->route) > 1) {
			$file_name = array_pop($route);
			$controller = array_pop($route);
			return array($file_name, $controller, $route);
		} else {
			return array('', '', $route);
		}

	}

	/**
	 * Gets the file name from traversing the route
	 * 
	 * @return string
	 */
	public function getFileName()
	{
		list($file_name, $controller, $path) = $this->_traverseRoute();
		if ($file_name == '') {
			return $this->Bootstrap->root;
		} else {
			return $file_name;
		}
	}

}

/**
 * Shell for the router exception thrown
 */
class RouterException extends \Exception {}


