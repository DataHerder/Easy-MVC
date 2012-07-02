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
 * @package     Views/Errors
 * @license     GNU license
 * @version     1.0
 * @link        my.public.repo
 * @since       File available since
 */

namespace EasyMVC\Views\Errors;


/**
 * Parses the type and kind of error being addressed
 * 
 * Work in progress, unfinished
 * 
 * @package Views
 * @subpackage Errors
 */
class Error extends ErrorAbstract {
	
	const DEBUG = DEBUG;
	public function __construct()
	{
		parent::__construct();
	}

	public function get404($page_name)
	{
		print '
			<!DOCTYPE html>
				<html>
					<head>
						<title>404</title>
					</head>
				<body>
				Document "'.$page_name.'" Not Found
				</body>
			</html>
		';
	}

	public function printError($error_message)
	{
?>
<!DOCTYPE html>
<html lang='en'>
<head>
	<title>Error</title>
</head>
<body>
	<h1><?=$error_message.'!'?></h1>
	<?php if (self::DEBUG):
		print "<pre>".print_r($_REQUEST, true)."</pre>";
	endif;?>
</body>
</html>
<?php 
	}
}