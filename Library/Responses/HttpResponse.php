<?php 

namespace EasyMVC\Responses;

final class HttpResponse extends Abstracts\ResponsesAbstract {

	/**
	 * Construct the response, defaults to 307
	 *
	 * @param int $response_code
	 * @param int $message
	 * @param array $params
	 * @param int $code
	 * @param \Exception $previous
	 */
	public function __construct($response_code = 0, $message, $params = array(), $code = 0, \Exception $previous = null)
	{
		parent::__construct($response_code, $message, $params, $code, $previous);
		// check the bootstrap
	}


	private $functions = array();

	/**
	 * Executes functions before the redirect
	 * 
	 * @param string $func
	 */
	public function execute($func = '')
	{
		if (is_callable($func)) {
			$this->functions[] = $func;
		}
	}



}