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
 * @category    EasyMVC
 * @package     Helpers/Functions
 * @license     GNU license
 * @version     1.0
 * @link        my.public.repo
 * @since       File available since
 */


/**
 * Return the POST variable without setting off warnings from shorthand coding.
 * For instance: if ($_POST['something'] == '') { // etc
 * will set off warnings if $_POST['something'] is not set
 * 
 * If POST variable is not set, take note that the return value is NULL
 * 
 * @param string $n
 * @return mixed
 * @throws Exception
 */
function getPost($n)
{
	if (!is_string($n)) {
		return false;
	}
	if(isSet($_POST[$n])) {
		return $_POST[$n];
	} else {
		return null;
	}
}


/**
 * Return the GET variable without setting off warnings from shorthand coding.
 * For instance: if ($_GET['something'] == '') { // etc
 * will set off warnings if $_GET['something'] is not set
 * 
 * If GET variable is not set, take note that the return value is NULL
 * 
 * @param string $n
 * @return mixed
 * @throws Exception
 */
function getGet($n)
{
	if (!is_string($n)) {
		return false;
	}
	if(isSet($_GET[$n])) {
		return $_GET[$n];
	} else {
		return null;
	}
}
