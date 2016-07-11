<?php
/**
 * Created by PhpStorm.
 * User: Wolf
 * Date: 7/11/2016
 * Time: 12:42
 */

namespace CrazyFactory\Utils;


class SqlUpdateQuery
{
	/**
	 * @param array[] $pk_to_data_dic
	 * @param string $table_name
	 * @param string $table_primary_key
	 *
	 * @return null|string Returns a query string or null if none of the models needs updating.
	 * @throws \Exception
	 */
	public static function buildUpdateQuery($table_name, $table_primary_key, $pk_to_data_dic)
	{
		// Get all columns that will be updated
		$columns = Arrays::getElementKeys($pk_to_data_dic);
		if (!$columns) {
			return null;
		}

		// Don't allow changing of primary keys!
		if (in_array($table_primary_key, $columns)) {
			throw new \Exception('Tried changing a primary key');
		}

		// Get a list of all primary keys we need to touch
		$primary_keys = array_keys($pk_to_data_dic);

		// Build sql string
		$sql = 'UPDATE ' . $table_name . ' SET ';
		$sql .= implode(', ', self::buildUpdateQueryCases($columns, $table_primary_key, $pk_to_data_dic));
		$sql .= ' WHERE ' . $table_primary_key . ' IN (' . implode(', ', $primary_keys) . ')' . "\n";

		return $sql;
	}

	/**
	 * @param string[] $columns
	 * @param string   $table_primary_key
	 * @param array[]  $pk_to_data_dic
	 *
	 * @return array $cases
	 */
	private function buildUpdateQueryCases($columns, $table_primary_key, $pk_to_data_dic)
	{
		$cases = [];

		foreach ($columns as $column) {

			$case = $column . ' = CASE' . "\n";

			foreach ($pk_to_data_dic as $primary_key => $data) {
				if (empty($data) || !key_exists($column, $data)) { // todo: show dave difference between isset and key_exists.
					continue;
				}

				$case .= ' WHEN ' . $table_primary_key . ' = ' . $primary_key . ' THEN ' . df_sqlval($data[$column]) . "\n";

			}

			$case .= ' ELSE ' . $column . "\n";
			$case .= ' END' . "\n";
			$cases[] = $case;
		}

		return $cases;
	}

}