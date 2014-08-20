<?php 

include_once("../config.php");
load_bootstrap();

use EasyMVC\Api\Api as Api;
use EasyMVC\Api\ApiClasses\ApiException as ApiException;


class MyApi extends Api
{

	/**
	 * On construct allows you to custom configure the
	 * API object before it analyzes any requests
	 */
	protected function _onConstruct()
	{
		// immediately call some API configurations on construct
		// before the life cycle of the object
	}

	/**
	 * Required function to dictate the API calls
	 *
	 * This function MUST exist to program your API requests: ie,
	 * what is allowed, what is not, etc... You have complete
	 * control, over the method type, what other libraries are used
	 * how the request is assimilated etc... The API object itself
	 * just automates the errors and success so that there is never
	 * a strange out message or just text
	 *
	 * The output follows 3 conventions: xml, json, msgpack
	 */
	protected function _init($call_types = array())
	{
		$top_call = $call_types['top_call'];
		if ($top_call != 'example') {
			throw new ApiException('Not a valid API request');
		}
		$this->data = 'Successful call';
	}

}


try {

	$Api = new MyApi();
	$Api->getResponse();
	print $Api;

} catch (Exception $e) {

	print Api::error(
		$e->getCode(),
		'There was a general error: ' . $e->getMessage()
	);
}
