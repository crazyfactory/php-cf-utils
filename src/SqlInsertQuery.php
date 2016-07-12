<?php

namespace CrazyFactory\Utils;

use CrazyFactory\Utils\Base\SqlQuery;

class SqlInsertQuery extends SqlQuery
{

	/**
	 * @param array[]         $data_list
	 * @param string          $table_name
	 * @param string|string[] $omit_keys A key or list of keys you want to ignore within the data.
	 *
	 * @return int
	 * @throws \Exception
	 */
	public static function buildBulk($table_name, $data_list, $omit_keys = array())
	{
		// Return null on empty values
		if (!$data_list) {
			return null;
		}

		// Require valid table name
		if (!$table_name || !is_string($table_name)) {
			throw new \Exception("Table name is required");
		}

		// Get all affected columns
		$columns = Arrays::getElementKeys($data_list);

		// Strip omitted keys from columns
		$omit_keys = is_array($omit_keys)
			? $omit_keys
			: array($omit_keys);
		$columns = array_diff($columns, $omit_keys);

		$columns_strings = $columns;
		foreach ($columns_strings as &$column_string) {
			$column_string = '`' . $column_string . '`';
		}

		// Build INSERT INTO ... VALUES clause
		$imploded = implode(', ', $columns_strings);
		$sql = "INSERT INTO `$table_name` ($imploded)";

		$data_list_values = [];
		foreach ($data_list as $data) {
			$data_values = [];
			foreach ($columns as $column) {
				if (!key_exists($column, $data)) {
					throw new \Exception("missing data value for column '" . $column . "'");
				}
				$data_values[] = self::escapeValue($data[$column]);
			}
			// Create inserted data set string
			$data_list_values[] = '(' . implode(', ', $data_values) . ')';
		}

		// Append/Concat all data set strings
		$sql .= ' VALUES ' . implode(', ', $data_list_values) . ';';

		return $sql;
	}
}