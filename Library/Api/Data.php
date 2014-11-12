<?php

namespace EasyMVC\Api;

class Data extends \ArrayObject {

	private static $data = array();

	public function __construct($version, $return_type = 'xml') {
		$this['version'] = $version;
		$this['return_type'] = $return_type;
		$this['type'] = $return_type;
		$this['static_type'] = $return_type;
		$this->_setData();
	}

	public static function currentDataSet()
	{
		return array(
			'api_version' => self::$data['version'],
			'top_call' => self::$data['top_call'],
			'api_call' => self::$data['api_call'],
			'api_call_type' => self::$data['api_call_type'],
			'api_call_subtype' => self::$data['api_call_subtype'],
			'api_call_user_subtypes' => self::$data['api_call_user_subtypes'],
			'api_call_string' => self::$data['api_call_string'],
			'method' => self::$data['this'],
			'post' => self::$data['post'],
			'get' => self::$data['get'],
		);
	}

	public function __set($name, $value)
	{
		if ($name == 'version') {
			throw new ApiDataException('Can not alter version outside of class instantiation set by the Api class');
		}
		$this[$name] = $value;
		// always assign the static variable
		$this->_setData();
	}

	private function _setData()
	{
		foreach ($this as $key => $value) {
			self::$data[$key] = $value;
		}
	}

	public function getVersion() {
		return $this['version'];
	}

	public function set(array $data = array()) {
		foreach ($data as $key => $value) {
			$this[$key] = $value;
		}
		$this->_setData();
	}

	public function call()
	{
		return self::currentDataSet();
	}
}

class ApiDataException extends \Exception {}