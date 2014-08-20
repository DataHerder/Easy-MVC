<?php

namespace EasyMVC\Api\ApiClasses;

class ApiSyntaxException extends \Exception {
	// codes are required
	public function __construct($message, $code = null, Exception $previous = null) {
		if ($code == null) {
			throw new \Exception('No Code set for ApiSyntaxException');
		}
		parent::__construct($message, $code, $previous);
	}
}
