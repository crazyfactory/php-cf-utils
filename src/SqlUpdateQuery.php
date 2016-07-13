<?php

namespace CrazyFactory\Utils;

use CrazyFactory\Utils\Base\SqlQuery;

class SqlUpdateQuery extends SqlQuery
{
	/**
	 * @param string  $table_name
	 * @param string  $table_primary_key
	 * @param array[] $data_list
	 * @param bool    $treat_as_dictionary
	 *
	 * @return null|string Returns a sql update query. Will return null if data_list is empty-ish
	 * @throws \Exception
	 */
	public static function buildBulk($table_name, $table_primary_key, $data_list, $treat_as_dictionary = false)
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
		if ($data_list !== null && !is_array($data_list)) {
			throw new \Exception('data_list must be array (or null)');
		}
		// Data empty
		if ($data_list === null || empty($data_list)) {
			return null;
		}

		// Remove falsy data items
		$data_list = array_filter($data_list);

		// Get all columns that will be updated (and remove the primary key)
		$columns = Arrays::getElementKeys($data_list);
		$columns = array_diff($columns, array($table_primary_key));
		if (!$columns) {
			return null;
		}

		// Gather and verify all primary keys
		$primary_keys = array();
		foreach ($data_list as $key => &$data) {

			// In dictionary mode...
			if ($treat_as_dictionary) {
				// If key exists already ...
				if (key_exists($table_primary_key, $data)) {
					// ... but it's different from what we except
					if ($data[$table_primary_key] !== $key) {
						throw new \Exception('primary key mismatch');
					}
				}
				else {
					$data[$table_primary_key] = $key;
				}
			}

			// Escape and add key to list
			$primary_keys[] = self::escapeValue($data[$table_primary_key]);
		}

		// Build sql string
		$sql = 'UPDATE `' . $table_name . '` SET ';
		$sql .= implode(', ', self::buildBulkQueryCases($columns, $table_primary_key, $data_list));
		$sql .= ' WHERE `' . $table_primary_key . '` IN (' . implode(', ', $primary_keys) . ');';

		return $sql;
	}

	/**
	 * @param string[] $columns
	 * @param string   $table_primary_key
	 * @param array[]  $data_list
	 *
	 * @return array $cases
	 */
	private static function buildBulkQueryCases($columns, $table_primary_key, $data_list)
	{
		$cases = array();

		// Build clauses for all changed columns
		foreach ($columns as $column) {

			$when_clauses = array();

			// For all data sets
			foreach ($data_list as $key => $data) {
				// ... with the current column
				if (key_exists($column, $data)) {
					$when_clauses[] = 'WHEN  ' . $data[$table_primary_key] . ' THEN ' . self::escapeValue($data[$column]);
				}
			}

			// Add to list in correct format => `name` = CASE `id` THEN "Bob" ELSE `name` END
			$cases[] = "`$column` = CASE `$table_primary_key` " . implode(' ', $when_clauses) . " ELSE `$column` END";
		}

		return $cases;
	}

}

