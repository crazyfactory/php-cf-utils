<?php
/**
 * Created by PhpStorm.
 * User: Wolf
 * Date: 7/12/2016
 * Time: 09:16
 */

namespace CrazyFactory\Utils\Test;

use CrazyFactory\Utils\SqlUpdateQuery;

class SqlUpdateQueryTest extends \PHPUnit_Framework_TestCase
{
	public function providerForTestBuildBuild() {
		return array(
			// #0 - dictionary with mixed types
			array(
				'users',
				'id',
		        array(
					1 => array(
						'age' => 15,
						'location' => "Kansas"
					),
					3 => array(
						'age' => 11,
						'name' => 'Peter'
					)
		        ),
		        true,
				'UPDATE `users` 
SET 
 `age` = CASE `id` WHEN 1 THEN 15 WHEN 3 THEN 11 ELSE `age` END,
  `location` = CASE `id` WHEN 1 THEN "Kansas" ELSE `location` END,
 `name` = CASE `id` WHEN 3 THEN "Peter" ELSE `name` END
WHERE `id` IN (1, 3);'
			),
			// #1 - dictionary with empty/null sets
			array(
				'employees',
				'employee_id',
				array(
					1 => array(),
					2 => null,
					3 => array(
						'age' => 11,
						'name' => 'Peter'
					)
				),
				true,
				'UPDATE `employees` 
SET 
 `age` = CASE `employee_id` WHEN 3 THEN 11 ELSE `age` END, 
 `name` = CASE `employee_id` WHEN 3 THEN "Peter" ELSE `name` END
WHERE `employee_id` IN (3);'
			),
			// #2 - empty dictionary
			array(
				'users',
				'id',
				array(),
				true,
				null
			),
			// #3 - null data
			array(
				'users',
				'id',
				null,
				false,
				null
			),
			// #4 - list with mixed data
			array(
				'posts',
				'id',
				array(
					array(),
					null,
					array(
						'id' => 7,
						'is_verified' => true
					)
				),
				false,
				'UPDATE `posts` 
					SET `is_verified` = CASE `id` WHEN 7 THEN 1 ELSE `is_verified` END
					WHERE `id` IN (7);'
			),
		);
	}

	/**
	 * @dataProvider providerForTestBuildBuild
	 *
	 * @param string  $table_name
	 * @param string  $table_primary_key
	 * @param array[] $data
	 * @param bool    $treat_as_dictionary
	 * @param string  $expected
	 *
	 * @throws \Exception
	 */
	public function testBuildBulk($table_name, $table_primary_key, $data, $treat_as_dictionary, $expected) {

		$sql = SqlUpdateQuery::buildBulk($table_name, $table_primary_key, $data, $treat_as_dictionary);

		// Remove line-breaks, tabs, spaces, multiple whitespaces
		$sql = preg_replace('/\s+/S', " ", $sql);
		$expected = preg_replace('/\s+/S', " ", $expected);

		$this->assertEquals($expected, $sql);
	}

	/**
	 * @expectedException \Exception
	 */
	public function testBuildBuild_WithDictionaryKeyMismatch_ThrowsException() {

		SqlUpdateQuery::buildBulk(
			'posts',
			'id',
			array(
				array(
					'id' => 7,
					'something_else' => 5
				)
			),
			true
		);
	}

	/**
	 * @expectedException \Exception
	 */
	public function testBuildBulk_WithInvalidTableName_ThrowsException() {
		SqlUpdateQuery::buildBulk(null, 'id', array());
	}

	/**
	 * @expectedException \Exception
	 */
	public function testBuildBulk_WithInvalidTablePrimaryKey_ThrowsException() {
		SqlUpdateQuery::buildBulk('users', null, array());
	}
}