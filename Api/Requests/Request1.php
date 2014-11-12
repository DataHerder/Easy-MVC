<?php
/**
 * EXAMPLE REQUEST OBJECT
 */
namespace Api\Requests;

use EasyMVC\Api\Request;

class Request1 extends Request {
	public function __construct() {
		parent::__construct();
		if ($this->api_version == 1) {
			return array('message' => 'successful api request to version 1');
		} elseif ($this->api_version == 2) {
			return array('message' => 'successful api request to version 2');
		}
		throw new Request1Exception('There was an error, api version not supported');
	}
}

class Request1Exception extends \Exception {}
