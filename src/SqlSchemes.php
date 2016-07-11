<?php
/**
 * Created by PhpStorm.
 * User: Wolf
 * Date: 7/11/2016
 * Time: 12:40
 */

namespace CrazyFactory\Utils;

/**
 * Class SqlSchemes
 *
 * Offers helpful functions for scheme discovery and naming conventions.
 */
class SqlSchemes
{
	public static function determineTableName($className)
	{
		// No string, no result!
		if ($className === null) {
			return null;
		}

		if (!is_string($className)) {
			throw new \InvalidArgumentException('not a string');
		}

		// Initialise trimmed and opt out if empty
		$tableName = trim($className);

		// Strip out namespace
		if (strpos($tableName, '\\') != 0) {
			$tableName = array_reverse(explode('\\', $tableName))[0];
		}

		// Is a valid (and code style compliant) class name?
		$pattern = "/^[A-Z]([a-zA-Z0-9_]+[a-zA-Z0-9])*$/";
		if (!$tableName || !preg_match($pattern, $tableName)) {
			throw new \InvalidArgumentException('class name is invalid');
		}

		// These suffices will be removed from the end of the string.
		// if named properly even a Collection for Collections is ok,
		// because it should be named 'Collections'.
		$suffices = ['Collection', 'Set', 'Table'];

		// Try to strip out first suffix found
		foreach ($suffices as $suffix) {
			if ($tableName !== $suffix && stripos(strrev($tableName), strrev($suffix)) === 0) {
				$tableName = substr($tableName, 0, strlen($tableName) - strlen($suffix));
				break;
			}
		}

		// Append an 's' if missing
		if (strpos(strrev($tableName), 's') !== 0) {
			$tableName .= 's';
		}

		return $tableName;
	}
}