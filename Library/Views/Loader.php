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
 * @package     Views
 * @license     GNU license
 * @version     1.0
 * @link        my.public.repo
 * @since       File available since
 */

namespace EasyMVC\Views;

/**
 * 
 * 
 */
class Loader
{
	public $Load = null;
	public $redirect = '../';
	public function __construct()
	{
		$this->Load =& $this;
	}

	/**
	 * Loads the view
	 * 
	 * @param $view
	 * @param array $array_extract
	 * @throws LoaderException
	 */
	public function view($view, $array_extract = array())
	{
		if (!is_string($view)) {
			throw new LoaderException('No view specified to load.');
		} else {
			extract($array_extract);
			if (is_readable(\EasyMVC\EasyMVCBootstrap::ROOT_DIR.'/Library/Views/'.$view.'.php')) {
				include(\EasyMVC\EasyMVCBootstrap::ROOT_DIR.'/Library/Views/'.$view.'.php');
			} elseif (is_readable(\EasyMVC\EasyMVCBootstrap::ROOT_DIR.'/Application/Views/'.$view.'.php')) {
				include(\EasyMVC\EasyMVCBootstrap::ROOT_DIR.'/Application/Views/'.$view.'.php');
			} else {
				throw new LoaderException('There was an error loading the view.');
			}
		}
	}

	/**
	 * Checks by the same measure that view in fact exists
	 * This function is handy for __call() method in a 
	 * controller - whereby you want dynamically load views
	 * through the controller and want to check to see
	 * if the view exists
	 * 
	 * @param string $view
	 * @return bool
	 */
	public function viewExists($view)
	{
		if (!is_string($view)) {
			return false;
		} else {
			if (is_readable(\EasyMVC\EasyMVCBootstrap::ROOT_DIR.'/Library/Views/'.$view.'.php')) {
				return true;
			} elseif (is_readable(\EasyMVC\EasyMVCBootstrap::ROOT_DIR.'/Application/Views/'.$view.'.php')) {
				return true;
			} else {
				return false;
			}
		}
	}

	/**
	 * load raw file
	 * 
	 * @param string $file
	 * @return string|boolean false on failure
	 */
	public function rawFile($file)
	{
		$fd = fopen($file, 'r') or false;
		if (is_resource($fd)) {
			$file_data = array();
			while (!feof($fd)) {
				$file_data[] = fread($fd,1024);
			}
			fclose($fd);
			return join($file_data);
		} else {
			return false;
		}
	}

	/**
	 * Load the model
	 * 
	 * unfinished work in progress
	 */
	public function model()
	{
		
	}
}

class LoaderException extends \Exception {}