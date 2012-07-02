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

// import the short hands for the elements
use EasyMVC\Routers\Router as MVCRoute;
use EasyMVC\Routers as MVCRouter;
use EasyMVC\Bootstrap as MVCBootstrap;
use EasyMVC\Controllers\ControllerAbstract as MVCControllerAbstract;
use EasyMVC\Views\Errors\Error as MVCError;
use EasyMVC\Views\Errors\ErrorAbstract as MVCErrorAbstract;


// skeleton to the mvc bootstrap
class MyBootstrap extends MVCBootstrap{}


# setup the router and autoload bootstrap
$Bootstrap = new EasyMVC\Bootstrap;
try {
	# get the router
	$Router = new MVCRoute($Bootstrap);
	# get the controller
	$Controller = $Router->getController();
	# call the page with the controller
	$Controller->callPage($Router);
} catch (MVCRouter\RouterException $RouterException) {
	# if there was an error in the router - send a message
	$Error = new \Views\Errors\Error;
	$Error->printError($RouterException->getMessage());
}
