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
 * @category    Model View Controller Framework
 * @package     EasyMVC
 * @license     GNU license
 * @version     1.0
 * @link        my.public.repo
 * @since       File available since
 */


/**
 * Require MVC architecture
 * 
 * config.php - configures the system
 * Bootstrap  - initializes the system
 */
include_once("config.php");
require_once("Library/Bootstrap.php");

// skeleton to the mvc bootstrap
class MyBootstrap extends \EasyMVC\Bootstrap{}

# setup the router and autoload bootstrap
$Bootstrap = new MyBootstrap;
try {
	# get the router
	$Router = new EasyMVC\Routers\Router($Bootstrap);
	# get the controller
	$Router->callController();
} catch (\EasyMVC\Routers\RouterException $RouterException) {
	# if there was an error in the router - send a message
	$Error = new \EasyMVC\Views\Errors\Error;
	$Error->printError($RouterException->getMessage());
}

