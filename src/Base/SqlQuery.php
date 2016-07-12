<?php
/**
 * Created by PhpStorm.
 * User: Wolf
 * Date: 7/12/2016
 * Time: 09:42
 */

namespace CrazyFactory\Utils\Base;


class SqlQuery
{
	public static function escapeValue($value) {
		if (is_int($value) || is_null($value)) {
			return $value;
		}
		else if (is_bool($value)) {
			return (int) $value;
		}
		else {
			return '"'.addslashes($value).'"';
		}
	}
}