<?php

namespace EasyMVC\Api;

/**
 * Requests are the classes used by your extended API class within the _init() method or other methods defined within
 * the extended API class
 *
 * Requests are separate from the library as they are specific to the custom API logic
 */


/**
 * A generic class as an example
 *
 * Class Request
 * @package Api
 */
class Request {

	public $api_version = 1;
	public static $api_verision = 1;
	public $api_call;

	public function __construct() {
		// do something here
		$this->api_call = Data::currentDataSet();
		$this->api_version = $this->api_call['api_version'];
		self::$api_verision = $this->api_version;
	}

}

class HandlerException extends \Exception {}