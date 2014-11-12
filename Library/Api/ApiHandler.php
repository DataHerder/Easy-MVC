<?php

namespace EasyMVC\Api;

/**
 * Handlers are the classes used by your extended API class within the _init() method or other methods defined within
 * the extended API class
 *
 * It's important to extend your Handlers with the ApiHandler so that you can use api_version control within your
 * logic.  Basically, if you decide later on in your application to change your Api handling by versions, you
 * are now able to do this using version_control and the setVersion() method preferrably used in your
 * __onConstruct() protected method within your custom Api class object
 *
 * Ie: now you can use an URL to specify versions ie:
 *  yourwebsite.com/api/v1/your-feed.json
 *  yourwebsite.com/api/v2/your-feed.json
 *
 * The two feeds for the same data may wield different results
 */


/**
 * A generic class as an example
 *
 * Class Handler
 * @package Api\Handlers
 */
class ApiHandler {

	public $api_version = 1;
	public static $api_verision = 1;
	public $api_call;

	public function __construct() {
		// do something here
		$this->api_call = ApiData::currentDataSet();
		$this->api_version = $this->api_call['api_version'];
		self::$api_verision = $this->api_version;
	}

}

class HandlerException extends \Exception {}