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
 * @package     Models
 * @license     GNU license
 * @version     1.0
 * @link        my.public.repo
 * @since       File available since
 */

namespace EasyMVC\Models;

/**
 * The beginnings of the ModelAbstract class
 * 
 * Unfinished project
 * 
 * @package Models
 * @subpackage 
 * 
 */
abstract class ModelsAbstract {

	/**
	 * 
	 * @var Password
	 * @access private
	 */
	protected $PasswordHash;

	public $db = null;

	/**
	 * Constructor instantiates password hash
	 */
	public function __construct()
	{
		$this->PasswordHash = new \EasyMVC\Framework\BCrypt\PasswordHash(8, false);
		$Bootstrap = get_bootstrap();
		$Sql = $Bootstrap->db;
		if (!is_null($Sql)) {
			$this->db = $Sql;
		}
	}

	public static function getDB()
	{
		$Bootstrap = get_bootstrap();
		return $Bootstrap->db;
	}

	/**
	 * Hashes a string using Bcrypt
	 *
	 * @access public
	 *
	 * @param mixed $toHash
	 * @throws \EasyMVC\ModelException
	 * @return mixed
	 */
	public function hash($toHash = null)
	{
		if (is_null($toHash)) {
			return '';
		}
		if ((is_object($toHash) && $toHash instanceof \stdClass) || is_array($toHash)) {
			foreach ($toHash as $i => $b) {
				$toHash[$i] = $this->PasswordHash->HashPassword($b);
			}
			return $toHash;
		} elseif (is_object($toHash) && (!$toHash instanceof \stdClass)) {
			throw new \EasyMVC\ModelException('Trying to hash an invalid value');
		} else {
			return $this->PasswordHash->HashPassword($toHash);
		}
	}

	/**
	 * Decrypt the bcrypt hash
	 * 
	 * @access public
	 * @param mixed $fromHash
	 * @throws \EasyMVC\ModelException
	 * @return mixed
	 */
	public function check($fromHash = null)
	{
		if (is_null($fromHash)) {
			return '';
		}
		if ((is_object($fromHash) && $fromHash instanceof \stdClass) || is_array($fromHash)) {
			foreach ($fromHash as $i => $b) {
				$toHash[$i] = $this->PasswordHash->CheckPassword($b);
			}
			return $toHash;
		} elseif (is_object($fromHash) && (!$fromHash instanceof \stdClass)) {
			throw new \EasyMVC\ModelException('Trying to hash an invalid value');
		} else {
			return $this->PasswordHash->CheckPassword($fromHash);
		}
	}
}

/**
 * Shell for the model exception
 * 
 */
class ModelException extends \Exception {}