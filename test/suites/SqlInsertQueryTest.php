<?php
/**
 * Created by PhpStorm.
 * User: Wolf
 * Date: 7/12/2016
 * Time: 09:16
 */

namespace CrazyFactory\Utils\Test;

use CrazyFactory\Utils\SqlInsertQuery;

class SqlInsertQueryTest extends \PHPUnit_Framework_TestCase
{

	public function providerForTestBuildBuild() {
		return array(
			// Set 1
			array(
				'users',
				array(
					array('location' => 'Kansas', 'age' => 13, 'name' => 'Alice'),
					array('location' => 'Wonderland', 'name' => 'Mad Hatter', 'age' => 645)
				),
				null,
				'INSERT INTO `users` (`age`, `location`, `name`) VALUES (13, "Kansas", "Alice"), (645, "Wonderland", "Mad Hatter");',
			),
			// Set 2
			array(
				'users',
				array(
					array('location' => 'Kansas', 'age' => 13, 'name' => 'Alice'),
					array('location' => 'Wonderland', 'name' => 'Mad Hatter', 'age' => 645)
				),
				array('age', 'name'),
				'INSERT INTO `users` (`location`) VALUES ("Kansas"), ("Wonderland");',
			),
		);
	}

	/**
	 * @dataProvider providerForTestBuildBuild
	 *
	 * @param string  $table_name
	 * @param array[] $data
	 * @param string|string[]  $omit_keys
	 * @param string  $expected
	 */
	public function testBuildBulk($table_name, $data, $omit_keys, $expected) {
		$sql = SqlInsertQuery::buildBulk($table_name, $data, $omit_keys);

		// Remove line-breaks, tabs, spaces, multiple whitespaces
		$sql = preg_replace('/\s+/S', " ", $sql);
		$expected = preg_replace('/\s+/S', " ", $expected);

		$this->assertEquals($expected, $sql);
	}

}