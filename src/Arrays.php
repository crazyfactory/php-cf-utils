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
	 * @param array[] $list
	 *
	 * @return string[]
	 */
	public static function getElementKeys($list)
	{
		$keys = [];
		foreach ($list as $item) {
			if ($item !== null) {
				$keys = array_merge($keys, array_keys($item));
			}
		}

		$keys = array_unique($keys);

		sort($keys, SORT_STRING);

		return $keys;
	}
}