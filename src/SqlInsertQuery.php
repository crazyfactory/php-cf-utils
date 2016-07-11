<?php
/**
 * Created by PhpStorm.
 * User: Wolf
 * Date: 7/11/2016
 * Time: 12:33
 */

namespace CrazyFactory\Utils;


class SqlInsertQuery
{

	/**
	 * @param array[] $data_list
	 * @param string $table_name
	 * @param string $table_primary_key
	 *
	 * @return int
	 * @throws \Exception
	 */
	protected function buildInsertQuery($table_name, $table_primary_key, $data_list)
	{
		// Return null on empty values
		if (!$data_list) {
			return null;
		}

		// Require valid table name
		if (!$table_name || !is_string($table_name)) {
			throw new \Exception("Table name is required");
		}

		// Require valid primary key
		if (!$table_primary_key || !is_string($table_primary_key)) {
			throw new \Exception("Table primary key is required");
		}

		// Get all affected columns
		$columns = Arrays::getElementKeys($data_list);

		// Unset primary key (it probably exists, but should only contain null values anyway)
		unset($columns[$table_primary_key]);


		// Build INSERT INTO ... VALUES clause
		$sql = 'INSERT INTO `' . $table_name . '` (' . implode(', ', $columns) . ')';

		$data_list_values = [];
		foreach ($data_list as $data) {
			$data_values = [];
			foreach ($columns as $column) {
				if (!key_exists($column, $data)) {
					throw new \Exception("missing data value for column '".$column."'");
				}
				$data_values[] = df_sqlval($data[$column]);
			}
			// Create inserted data set string
			$data_list_values[] = ' (' . implode(', ', $data_values) . ')';
		}

		// Append/Concat all data set strings
		$sql .= ' VALUES' . implode(', ', $data_list_values);
		return $sql;
	}
}