<?php

namespace EasyMVC\Api;

use EasyMVC\Api\ApiClasses\ApiException;
use EasyMVC\Api\ApiClasses\ApiSyntaxException;
use EasyMVC\Api\ApiClasses\XmlOutput;
use EasyMVC\Api\Modules\MsgPack\MsgPack_Coder;

class Api extends ApiClasses\ApiAbstract {

	protected $data = array();
	protected $method = 'GET';
	private $type = 'json';
	protected static $api_call_string = '';
	protected static $top_call = '';
	protected static $api_call = '';
	protected static $api_call_type = '';
	protected static $api_call_subtype = '';
	private static $header_content = false;
	/**
	 * @var null|callable
	 */
	protected static $header_content_callback = null;
	protected static $static_type = 'json';
	//private static $log_hit = true;


	/**
	* Create new Api call
	*/
	public function __construct()
	{
		$this->setHeader();
		if (method_exists($this, '_onConstruct')) {
			$this->_onConstruct();
		}
		try {
			// if method is post, will not overwrite get
			$this->method = $_SERVER['REQUEST_METHOD'];
			if (isSet($_GET['directory'])) {
				$this->_setReturnType($_GET['directory']);
			}
		} catch (ApiSyntaxException $e) {

			// defaulted to JSON output for now
			print Api::error(
				$e->getCode(),
				'There was an API syntax error: ' . $e->getMessage()
			);
			die;

		} catch (ApiException $e) {

			print Api::error(
				$e->getCode(),
				'There was an API error: ' . $e->getMessage()
			);
			die;
		}
	}



	/**
	 * Set the header content type, when the API outputs the data it will
	 * then print the header content
	 *
	 * Please note, the last call of this method is the one that will be used
	 *
	 * @param bool $set_header_content
	 * @param null|string|callable $callback_string_or_callable
	 */
	public function setHeader($set_header_content = true, $callback_string_or_callable = null)
	{
		self::$header_content = $set_header_content;
		if (is_callable($callback_string_or_callable) || is_string($callback_string_or_callable)) {
			self::$header_content_callback = $callback_string_or_callable;
		} else {
			self::$header_content_callback = null;
		}
	}

	/**
	 * Start the api call by parsing the URI and calling
	 * the correct api access directory to get the response
	 *
	 * @param null|string $directory
	 * @param array $post_data
	 */
	public function getResponse($directory = null, $post_data = array())
	{
		// the try catch block is only for all exceptions built into the
		// api class, all other api exceptions should be handled by the programmer
		// exactly as the syntax is handled here
		try {
			if (
				(is_null($directory) || !is_string($directory)) ||
				(is_string($directory) && $directory == ''))
			{
				self::$api_call_string = $_GET['directory'];
			} else {
				self::$api_call_string = $directory;
				$this->_setReturnType($directory);
			}

			$api_call = explode("/", self::$api_call_string);

			if (preg_match("/\./", $api_call[0])) {
				$napi = current(explode('.', $api_call[0]));
			} else {
				$napi = $api_call[0];
			}

			self::$top_call = $napi;
			self::$api_call = $api_call;
			self::$api_call_type = $api_call[0];
			$this->_getSubtype($api_call, true);

			if (method_exists($this, '_init')) {
				array_shift($api_call);
				array_shift($api_call);
				array_walk($api_call, function(&$value) {
					$value = array_shift(explode(".", $value));
				});
				$this->_init(array(
					'top_call' => self::$top_call,
					'api_call' => self::$api_call,
					'api_call_type' => self::$api_call_type,
					'api_call_subtype' => self::$api_call_subtype,
					'api_call_user_subtypes' => $api_call,
					'api_call_string' => self::$api_call_string,
					'method' => $this->method,
					'post' => (empty($post_data)) ? $_POST : $post_data,
				));
			} else {
				throw new ApiException('_init function does not exist.  You must extend the API and create a the _init function, see documentation');
			}
			// this will go into the protected extension of the API
		} catch (ApiSyntaxException $e) {

			// defaulted to JSON output for now
			print Api::error(
				$e->getCode(),
				'There was an API syntax error: ' . $e->getMessage()
			);
			die;

		} catch (ApiException $e) {

			print Api::error(
				$e->getCode(),
				'There was an API error: ' . $e->getMessage()
			);
			die;

		}

	}


	/**
	 * Get the return type from the directory string and set the return type in the API
	 *
	 * @param string $directory
	 * @throws ApiClasses\ApiSyntaxException
	 */
	private function _setReturnType($directory = null)
	{
		if (strpos($directory, '.') !== false) {
			$this->type = array_pop(explode(".", $directory)); // will always have $_GET var for type
		} else {
			$this->type = '';
		}
		self::$static_type = $this->type;
		if (!preg_match("/msgpack|json|xml/", $this->type)) {
			$error = true;
			foreach ($this->allowed_extensions as $allowed) {
				if (preg_match('/'.$allowed.'/', $this->type)) {
					self::$static_type = $allowed;
					$error = false;
					break;
				}
			}
			if ($error) {
				// force the api syntax exception and set the static type to xml
				self::$static_type = 'xml';
				throw new ApiSyntaxException('Illegal api call with wrong type', 1);
			}
		}
	}


	/**
	 * Parses out the subtype, the subtype is the second list
	 * Everything following that are programmer designed subtypes
	 * handled in the protected function within the extended API class
	 *
	 * Example 1: site.com/api/type/subtype.xml
	 * Example 2: site.com/api/type/subtype/user_subtype1/user_subtype2.json
	 *
	 * @param $api_call
	 * @param bool $strict
	 * @return mixed|string
	 * @throws ApiClasses\ApiException
	 */
	private function _getSubtype($api_call, $strict = false)
	{
		$subtype = '';
		$last = $api_call[1]; // subtype is ALWAYS the second subtype
		if (preg_match("/^[A-Za-z0-9-_]+\.[A-Za-z0-9-_]+$/", $last)) {
			$subtype = array_shift(explode(".", $last));
			self::$api_call_subtype = $subtype;
		} elseif (strpos($last, '.') === false) {
			// set the subtype with no extension in case it has been allowed
			$subtype = $last;
			self::$api_call_subtype = $last;
		} elseif ($strict) {
			throw new ApiException('Unknown api subtype call');
		}
		return $subtype;
	}


	private static $_customErrors = array();
	/**
	 * This method allows the programmer to set the error message of a give custom extension type.
	 * It allows more powerful error handling by the programmer, set the allowed extensions and then
	 * use the allowed extensions
	 *
	 * Please note: $for is the specific extension type specified in allowExtensions()
	 * Please note: $callable will have the $message variable passed as a parameter
	 *
	 * @param string $for
	 * @param null $callable
	 * @throws ApiClasses\ApiException
	 */
	protected function setError($for = '', $callable = null)
	{
		if (!in_array($for, $this->allowed_extensions)) {
			throw new ApiException('Set error did not match the type allowed');
		}
		self::$_customErrors[$for] = $callable;
	}

	/**
	 * Function error
	 *
	 * @param int $code
	 * @param string $message
	 * @param string $code_message
	 * @throws ApiClasses\ApiException
	 * @internal param string $type
	 * @return string
	 */
	public static function error($code = null, $message = 'generic error', $code_message = null)
	{

		if (!is_string($code_message)) {
			$code_message = 'general exception';
		}

		if (self::$header_content) {
			self::headerContent();
		}

		$message = array(
			'result' => 'failure',
			'success' => false,
			'code' => $code,
			'code-message' => $code_message,
			'message' => $message
		);

		if (self::$static_type == 'json') {
			return json_encode($message);
		} elseif (self::$static_type == 'msgpack') {
			return MsgPack_Coder::encode($message);
		} elseif (self::$static_type == 'xml') {
			$Xml = new XmlOutput();
			return $Xml->load($message)->__toString();
		} else {
			if (isSet(self::$_customErrors[self::$static_type]) && is_callable(self::$_customErrors[self::$static_type])) {
				$custom_func = self::$_customErrors[self::$static_type];
				$custom_func($message);
			} else {
				throw new ApiException('Custom error output not set for custom extension used');
			}
		}
	}


	private static $_customSuccesses = array();
	/**
	 * This method allows the programmer to set the error message of a give custom extension type.
	 * It allows more powerful error handling by the programmer, set the allowed extensions and then
	 * use the allowed extensions
	 *
	 * Please note: $for is the specific extension type specified in allowExtensions()
	 * Please note: $callable will have the $message variable passed as a parameter
	 *
	 * @param string $for
	 * @param null $callable
	 * @throws ApiClasses\ApiException
	 */
	protected function setSuccess($for = '', $callable = null)
	{
		if (!in_array($for, $this->allowed_extensions)) {
			throw new ApiException('Set error did not match the type allowed');
		}
		self::$_customSuccesses[$for] = $callable;
	}


	/**
	 * Make a success call
	 *
	 * @param string $type
	 * @param string $subtype
	 * @param array $data
	 * @param string $return_type
	 * @throws ApiClasses\ApiException
	 * @return string
	 */
	public static function success($type = '', $subtype = '', $data = array(), $return_type = '')
	{

		$message = array(
			'success' => true,
			'return_type' => $return_type,
			'type' => $type,
			'subtype' => $subtype,
			'data' => $data
		);

		if (self::$static_type == 'json') {
			return json_encode($message);
		} elseif (self::$static_type == 'msgpack') {
			return MsgPack_Coder::encode($message);
		} elseif (self::$static_type == 'xml') {
			$Xml = new XmlOutput();
			return $Xml->load($message)->__toString();
		} else {
			if (isSet(self::$_customSuccesses[self::$static_type]) && is_callable(self::$_customSuccesses[self::$static_type])) {
				return self::$_customSuccesses[self::$static_type]($message);
			} else {
				throw new ApiException('Custom success not set for custom extension used');
			}
		}
	}


	private $allowed_extensions = array();
	/**
	 * This method allows extensions specified by the programmer, these extensions go into a regular expression
	 * so regular expressions can be used
	 *
	 * Please note, errors will be outputed as xml and you must specify the setHeader()
	 * for successful outputs and set the error and success messages for those outputs
	 *
	 * @param array $types
	 * @throws ApiClasses\ApiException
	 */
	protected function allowExtensions($types = array())
	{
		if (!is_array($types)) {
			throw new ApiException('allow extensions expects $types to be array, another variable type given');
		}
		foreach ($types as $i => $type) {
			array_push($this->allowed_extensions, $type);
		}
	}


	public static function headerContent()
	{
		if (is_callable(self::$header_content_callback)) {
			header(self::$header_content_callback(array(
				'top_call' => self::$top_call,
				'api_call' => self::$api_call,
				'api_call_type' => self::$api_call_type,
				'api_call_subtype' => self::$api_call_subtype,
				'api_call_string' => self::$api_call_string,
			)));
		} elseif (is_string(self::$header_content_callback)) {
			header(self::$header_content_callback);
		} elseif (self::$static_type == 'json') {
			header('Content-type: application/json');
		} elseif (self::$static_type == 'xml') {
			header('Content-type: application/xml');
		} elseif (self::$static_type == 'msgpack') {
			// unreadable in browser for now
			//header('Content-type: application/x-msgpack');
			header('Content-type: text/plain');
		} else {
			header('Content-type: text/html');
		}
	}

	/**
	 * Return the success string
	 *
	 * @return string
	 */
	public function __toString()
	{
		if (self::$header_content) {
			self::headerContent();
		}
		try {
			return self::success(
				self::$top_call,
				self::$api_call_subtype,
				$this->data,
				$this->type
			);
		} catch (\Exception $e) {
			print $e->getMessage();
			die;
		}
	}
}
