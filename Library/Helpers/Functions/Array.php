<?php 


function dump_array($a, $str_ = false)
{
	$string = '<pre>'.print_r($a, true).'</pre>';
	if (!$str_) echo $string; else return $string;
}