<?php
/**
 * Created by PhpStorm.
 * User: Wolf
 * Date: 7/11/2016
 * Time: 12:46
 */

namespace CrazyFactory\Utils;


class Arrays
{
	/**
	 * Creates a sorted list with all unique keys from all elements of a list.
	 *
	 * @param array[] $list
	 *
	 * @return string[]
	 */
	public static function getElementKeys($list)
	{
		// Gather all keys in a list
		$keys = array();
		foreach ($list as $item) {
			// Skip null values
			if ($item !== null) {
				if (!is_array($item)) {
					throw new \InvalidArgumentException('list item is not null or array');
				}
				$keys = array_merge($keys, array_keys($item));
			}
		}

		// Clean up results
		$keys = array_unique($keys);
		sort($keys, SORT_STRING);

		return $keys;
	}

	/**
	 * @param array $list
	 * @param mixed $class
	 * @param bool  $allowNullElements
	 *
	 * @return bool
	 */
	public static function hasOnlyElementsOfClass($list, $class, $allowNullElements = false)
	{
		if (!is_array($list)) {
			throw new \InvalidArgumentException('list is not array');
		}
		foreach ($list as $item) {
			if (($item !== null && !($item instanceof $class)) || ($item === null && !$allowNullElements)) {
				return false;
			}
		}

		return true;
	}
}