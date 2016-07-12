<?php

namespace CrazyFactory\Utils;

use CrazyFactory\Utils\Base\SqlQuery;

class SqlDeleteQuery extends SqlQuery
{
	/**
	 * @param string $table_name
	 * @param string $table_primary_key
	 * @param int[]|string[] $primary_key_list
	 *
	 * @return string
	 */
	static function buildBulk($table_name, $table_primary_key, $primary_key_list) {



	}
}