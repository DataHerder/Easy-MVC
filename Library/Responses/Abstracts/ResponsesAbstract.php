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
namespace EasyMVC\Responses\Abstracts;

abstract class ResponsesAbstract extends \Exception {

	protected $response_code = 0;
	protected $internal_error = false;
	protected $error_message = null;

	/**
	 * Construct the http response exception
	 * 
	 * @param int $response_code
	 * @param int $message
	 * @param int $code
	 * @param \Exception $previous
	 */
	public function __construct($response_code = 0, $message, $code = 0, \Exception $previous = null)
	{
		$this->response_code = $response_code;
		if ($this->response_code == 0) {
			$this->internal_error = true;
			$this->error_message = 'Response Code set 0: Not a valid http response code';
		}
		// allowed response numbers
		$allowed = array(
			300,301,302,303,304,305,306,307,
			400,401,402,403,404,405,406,407,408,409,410,411,412,413,414,415,416,
			500,501,502,503,504,505
		);
		$found = false;
		for ($i = 0; $i < count($allowed); $i++) {
			if ($this->response_code == $allowed[$i]) {
				$found = true;
				break;
			}
		}
		if (!$found) {
			$this->internal_error = true;
			$this->error_message = 'Response Code '.$response_code.' is not a valid 300, 400, or 500 http response code';
		}
	}

	public function loadView($html = true)
	{
		header(':', true, $this->response_code);
		$Loader = new \EasyMVC\Views\Loader;
		if ($Loader->viewExists('Responses/Response'.$this->response_code)) {
			$Loader->view('Responses/Response'.$this->response_code);
		} else {
			if ($html) {
			print '
					<!DOCTYPE html>
						<html>
							<head>
								<title>Error '.$this->resposne_code.'</title>
							</head>
							<body>
								There was an error processing your request.  Response code: '.$this->response_code.'
							</body>
						</html>'
				;
			}
		}
	}

	public function hasError()
	{
		return $this->internal_error;
	}

	public function getErrorMessage()
	{
		return $this->error_message;
	}
}


class ResponseAbstractException extends \Exception {}