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
 * @package     Controllers
 * @license     GNU license
 * @version     1.0
 * @link        my.public.repo
 * @since       File available since
 */
namespace EasyMVC\Controllers;


/**
 * Abstract controller class
 * Constructs the needed classes and calls the page
 * 
 * @package Controllers
 * @subpackage ControllerAbstract
 */
abstract class ControllerAbstract
{

	/**
	 * Loader class - used to load view primarily
	 * ex: 
	 *  // $this is in Controller context
	 *  $this->Load->view("hi");
	 * 
	 * @var EasyMVC\Views\Loader
	 * @access public
	 */
	public $Load = null;

	/**
	 * Loader Class
	 * 
	 * @var EasyMVC\Views\Errors\Error
	 * @access protected
	 */
	protected $Error = null;

	/**
	 * 
	 * @var EasyMVC\Bootstrap
	 * @access protected
	 */
	protected $Bootstrap = null;

	/**
	 * Constructor
	 * Loads the classes on instantiation
	 */
	public function __construct()
	{
		$this->Error = new \EasyMVC\Views\Errors\Error;
		$this->Load = new \EasyMVC\Views\Loader;
	}

	/**
	 * Calls the Page
	 * 
	 * @param Router $Router
	 */
	public function callPage(\EasyMVC\Routers\Router $Router)
	{
		$file_name = $Router->getFileName();
		if ($file_name == '') {
			$file_name = $Bootstrap->root;
		}

		if (method_exists($this, $file_name)) {
			call_user_func(array($this, $file_name));
		} else {
			$this->Error->get404($file_name);
		}
	}
}
