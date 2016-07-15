<?php

namespace CrazyFactory\Utils;

use CrazyFactory\Utils\Base\SqlQuery;

class SqlDeleteQuery extends SqlQuery
{
	/**
	 * @param string         $table_name
	 * @param string         $table_primary_key
	 * @param int[]|string[] $primary_key_list
	 *
	 * @return string
	 * @throws \Exception
	 */
	static function buildBulk($table_name, $table_primary_key, $primary_key_list)
	{
		// Require valid table name
		if (!SqlSchemes::isValidTableName($table_name)) {
			throw new \Exception('Table name invalid');
		}
		// Require valid table primary key
		if (!SqlSchemes::isValidColumnName($table_primary_key)) {
			throw new \Exception('Table primary key invalid');
		}
		// Data not array?
		if ($primary_key_list !== null && !is_array($primary_key_list)) {
			throw new \Exception('primary_key_list must be array (or null)');
		}

		// Data empty, return null
		if ($primary_key_list === null) {
			return null;
		}

		// Filter out falsy, return null when empty
		$primary_key_list = array_filter($primary_key_list);
		if (empty($primary_key_list)) {
			return null;
		}

		// Construct query
		$primary_key_list_escaped = array_map(function($val) {
			return SqlQuery::escapeValue($val);
		}, $primary_key_list);

		$sql = "DELETE FROM `$table_name` WHERE `$table_primary_key` IN (" . implode(', ', $primary_key_list_escaped) . ");";

		return $sql;
	}
}