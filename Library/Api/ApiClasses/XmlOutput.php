<?php

namespace EasyMVC\Api\ApiClasses;

class XmlOutput {

	private $type = 'generic';
	private $data = array();
	public function __construct($type = 'generic') {
		$this->type = $type;
	}

	public function load($data)
	{
		if (is_array($data)) {
			$this->data = $data;
		}
		return $this;
	}

	public function __toString()
	{
		//$trans = array_map('utf8_encode', array_flip(array_diff(get_html_translation_table(HTML_ENTITIES), get_html_translation_table(HTML_SPECIALCHARS))));
		//return strtr($this->_getXml($this->data), $trans);
		return $this->_getXml($this->data);
	}


	private function _getXml(array &$message)
	{
		if (!isSet($message['rowcount'])) {
			$message['rowcount'] = count($message['data']);
		}

		$str = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
		$str.= '<response>'."\n";
		$str.= $this->_recData($message);
		$str.= '</response>'."\n";
		return $str;
	}

	private function _recData($data)
	{
		$str = '';
		foreach ($data as $key => $value) {
			if (is_array($value)) {
				if (is_array($value['attributes'])) {
					$str.= $this->_xmlAttr($this->_xmlKey($key), $value['attributes'], $value['value']);
				} elseif ($value['as_attributes'] == true && is_array($value['rows'])) {
					$str_tmp = '';
					foreach ($value['rows'] as $row) {
						$str_tmp.= $this->_xmlAttr($this->_xmlKey($value['tag_name']), $row)."\n";
					}
					$str.= '<'.$this->_xmlKey($key).'>'.$str_tmp.'</'.$this->_xmlkey($key).'>'."\n";
				} else {
					$str.='<'.$this->_xmlKey($key).'>' . $this->_recData($value) . '</'.$this->_xmlKey($key).'>'."\n";
				}
			} elseif (is_bool($value)) {
				$str.='<'.$this->_xmlKey($key).'>'.(($value)?'true':'false').'</'.$this->_xmlKey($key).'>'."\n";
			} elseif (is_null($value)) {
				// have as closing tag instead if value is null
				$str.='<'.$this->_xmlKey($key).' />';
			} else {
				$str.='<'.$this->_xmlKey($key).'>'.$this->_xmlCDATA($value).'</'.$this->_xmlKey($key).'>'."\n";
			}
		}
		return $str;
	}

	private function _xmlAttr($tag_name, $row = array(), $optional_value = null)
	{
		if (isSet($row['value'])) {
			$v = $row['value'];
			unset($row['value']);
		} elseif (!is_null($optional_value)) {
			$v = $optional_value;
		} else {
			$v = false;
		}

		$str = '<'.$tag_name;
		foreach ($row as $k => $vv) {
			$str.= ' '.$k.'="'.$vv.'"';
		}

		if ($v) {
			$vv = '';
			if (is_array($v)) {
				$vv = $this->_recData($v);
			} else {
				$vv = $v;
			}
			$str.= '>'.$vv.'</'.$tag_name.'>';
		} else {
			$str.= ' />';
		}
		return $str;
	}

	private static function _xmlKey($key)
	{
		if (is_int($key)) {
			return 'row';
		} elseif (is_string($key)) {
			return $key;
		} else {
			return 'data';
		}
	}

	/**
	 * Encode XML
	 *
	 * @private
	 * @param mixed $text
	 * @return string
	 */
	private function _xmlEncode($text)
	{
		//return htmlentities($text);
		return $text;
	}

	/**
	 * XML CData
	 *
	 * @private
	 * @param mixed $text
	 * @return string
	 */
	private function _xmlCDATA($text)
	{
		if (preg_match("@[&<>\"']@", $text)) {
			return '<![CDATA['.$text.']]>';
		} else {
			return $this->_xmlEncode($text);
		}
	}

}