<?php 
/**
 * EasyMVC
 * A fast lightweight Model View Controller framework
 * 
 * Copyright (C) 2012  Paul Carlton
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 * 
 * @author      Paul Carlton
 * @category    EasyMVC
 * @package     Framework/Mail
 * @license     GNU license
 * @version     1.0
 * @link        my.public.repo
 * @since       File available since
 */

namespace EasyMVC\Framework\Mailer\Abstracts;

abstract class MailerAbstract {
	protected $to = array();
	protected $from = '';
	protected $replyTo = '';
	protected $cc = array();
	protected $bcc = array();

	public abstract function debug();
	public function dump() {
		return $this;
	}

	/**
	 * Set to whom it is being sent
	 * 
	 * @access public
	 * @param
	 * @return Mailer
	 */
	public function setTo($to)
	{
		if(!self::checkString($to) && !self::checkArray($from)) {
			throw $e->setMessage('Invalid data type passed to setTo'); // throw near line
		}
		if (self::checkString($to)) {
			array_push($this->to, $to);
		} elseif (self::checkArray($to)) {
			$this->to = $to;
		}
		return $this;
	}

	/**
	 * Set the From statement
	 * 
	 * @access public
	 * @param
	 * @return Mailer
	 */
	public function setFrom($from){
		if (!self::checkString($from)) {
			throw new MailerAbstractException('Invalid data type passed to setFrom');
		}
		$this->from = $from;
		return $this;
	}

	/**
	 * Set the reply to
	 * 
	 * @access public
	 * @param
	 * @return Mailer
	 */
	public function setReplyTo($replyTo){
		if (!self::checkString($replyTo)) {
			throw new MailerAbstractException('Invalid data type passed to setReplyTo');
		}
		$this->replyTo = $replyTo;
		return $this;
	}

	/**
	 * Set the cc
	 * 
	 * @access public
	 * @param
	 * @return Mailer
	 */
	public function setCC($cc){
		if(!self::checkString($cc) && !self::checkArray($cc)) {
			throw new MailerAbstractException('Invalid data type passed to setCC');
		}
		//$this->cc = $cc;
		return $this;
	}

	/**
	 * Set Bcc
	 * 
	 * @access public
	 * @param
	 * @return Mailer
	 */
	public function setBCC($bcc){
		if (!self::checkString($bcc) && !self::checkArray($bcc)) {
			throw new MailerAbstractException('Invalid data type passed to setBCC');
		}
		//$this->bcc = $bcc;
		return $this;
	}

	/**
	 * Input is a string and is greater than 1 length
	 * Only available within it's children
	 * 
	 * @access protected
	 * @static
	 * @param
	 * @return boolean
	 */
	protected static function checkString($string)
	{
		if (!is_string($string) || strlen($string) < 1) {
			return false;
		}
		return true;
	}

	/**
	 * Input is an array and !empty
	 * Only available within it's children
	 * 
	 * @access protected
	 * @static
	 * @param
	 * @return boolean
	 */
	protected static function checkArray($array)
	{
		if (!is_array($array) || !empty($array) < 1) {
			return false;
		}
		return true;
	}
}

class MailerAbstractException extends \Exception {}
