<?php 


function dump_array($a, $return = false)
{
	$string = '<pre>'.print_r($a, true).'</pre>';
	if (!$return) echo $string; else return $string;
}

function dbg_array($a, $return = false) {
	dump_array($a, $return);
}


/**
 * Extract Array Members from an associative or default array
 * You can pass a function into associative array to data munge if necessary on successful match
 * Example: extract_array(array('element1' => 'some string to parse'), 'element1', function($field, $value) {
 * 		if ($field == 1
 *
 * Examples:
 * if $haystack = array('element1' => 'value1', 'element2' => 'value2')
 * then array_extract($haystack, 'element1') will yield array('element1'=>'value')
 *
 * if $haystack = array('element1' => 'value1', 'element2' => 'value2')
 * then array_extract($haystack, 'element1, element2') will yield array('element1' => 'value1', 'element2' => 'value2')
 *
 * if $haystack = array('element1' => array(1,2,3), 'element2' => 'value2')
 * then array_extract($haystack, 'element1') will yield array('element1' => array(1,2,3))
 *
 * if $haystack = array('element1' => array('element2' => array('slice1' => array(1,2,3)), 'element3' => 'some string')
 * then array_extract($haystack, 'element2->slice1->0') will yield 1
 *
 * To flatten the array, set $associative_flag_or_callable = false
 *
 * If you need to pass a function to mess with the data and still want to flatten the array, pass it into options
 * as a "callable" function
 *
 * Example:
 * array_extract($array, $fields_as_string, false, array('callable' => function($field, $value) {
 * 		return 'something';
 * });
 *
 * @param $array
 * @param $fields_as_string
 * @param bool|callable $associative_flag_or_callable
 * @param array $options
 * @return array
 */
function array_extract($array, $fields_as_string, $associative_flag_or_callable = true, $options = array())
{
	set_default($options['recursive'], false);
	set_default($options['callable'], false);
	if (is_callable($associative_flag_or_callable)) {
		$options['callable'] = $associative_flag_or_callable;
		$associate = true;
	} else {
		$associate = $associative_flag_or_callable;
	}
	$fields = explode(',', $fields_as_string);
	$output = array();
	foreach ($fields as $field) {
		$field = trim($field);
		if ($field == '') continue;
		if (strpos($field, '->') !== false) {
			$tmp = explode("->", $field);
			$column = array_shift($tmp);
			$column = trim($column);
			if ($associate) {
				$data = array_extract($array[$column], join('->', $tmp), $associate, array('recursive' => true) + $options);
				$output[$column] = (isSet($output[$column])) ? $output[$column] + $data : $data;
			} else {
				$output[] = array_extract($array[$column], join('->', $tmp), $associate, array( 'recursive' => true) + $options);
			}
		} else {
			if (is_callable($options['callable'])) {
				$data = $options['callable']($field, $array[$field]);
			} else {
				$data = $array[$field];
			}
			if ($associate) {
				$output[$field] = $data;
			} else {
				if ($options['recursive']) {
					return $data;
				} else {
					$output[] = $data;
				}
			}
		}
	}
	return $output;
}


function set_default(&$variable, $value = null)
{
	if (!isSet($variable)) {
		$variable = $value;
	}
}