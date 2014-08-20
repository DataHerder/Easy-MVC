<?php


/**
 * Gets the bootstrap class from globals variable
 *
 * @return \EasyMVC\EasyMVCBootstrap
 */
function get_bootstrap()
{
	if (array_key_exists('Bootstrap', $GLOBALS)) {
		return $GLOBALS['Bootstrap'];
	} else {
		return false;
	}
}

/**
 * Allows for cron jobs, API and other elements outside the mvc framework
 * to load the bootstrap without instantiating or requiring libraries
 *
 * @param null|string $alternate_bootstrap_directory
 * @param string $class_name
 * @throws Exception
 * @return \Application\Bootstrap
 */
function load_bootstrap($alternate_bootstrap_directory = null, $class_name = '')
{
	require_once(ROOT_DIR."/Library/EasyMVCBootstrap.php");

	if (!is_null($alternate_bootstrap_directory) && is_string($alternate_bootstrap_directory)) {
		require_once($alternate_bootstrap_directory);
		if ($class_name == '') {
			throw new Exception('Unknown bootstrap class name for alternate bootstrap directory, ie: \Somewhere\Else\Bootstrap');
		} else {
			$Bootstrap = new $class_name();
		}
	} else {
		require_once(ROOT_DIR."/Application/bootstrap.php");
		$Bootstrap = new \Application\Bootstrap();
	}

	// assign as a global variable
	$GLOBALS['Bootstrap'] = $Bootstrap;
	return $Bootstrap;
}