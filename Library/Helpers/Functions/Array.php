<?php 


function dump_array($a, $return = false)
{
	$string = '<pre>'.print_r($a, true).'</pre>';
	if (!$return) echo $string; else return $string;
}

function dbg_array($a, $return = false) {
	dump_array($a, $return);
}