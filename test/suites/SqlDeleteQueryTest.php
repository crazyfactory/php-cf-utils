<?php
/**
 * Created by PhpStorm.
 * User: Wolf
 * Date: 7/12/2016
 * Time: 09:16
 */

namespace CrazyFactory\Utils\Test;

use CrazyFactory\Utils\SqlDeleteQuery;

class SqlDeleteQueryTest extends \PHPUnit_Framework_TestCase
{

	public function providerForTestBuildBuild() {
		return array(
			array('users', 'id', array(1, 4, 17, 28),
			      'DELETE FROM `'.users.'` WHERE `id` IN (1, 4, 17, 28);'),
			array('posts', 'post_id', array(1, 3, 2),
			      'DELETE FROM `'.users.'` WHERE `id` IN (1, 3, 2);'),
			array('posts', 'post_id', array(), null),
			array('posts', 'post_id', null, null)
		);
	}

	/**
	 * @dataProvider providerForTestBuildBuild
	 *
	 * @param string $table_name
	 * @param string $table_primary_key
	 * @param string[]|int[] $primary_key_list
	 * @param string $expected
	 */
	public function testBuildBulk($table_name, $table_primary_key, $primary_key_list, $expected) {
		$sql = SqlDeleteQuery::buildBulk($table_name, $table_primary_key, $primary_key_list);

		// Remove line-breaks, tabs, spaces, multiple whitespaces
		$sql = preg_replace('/\s+/S', " ", $sql);
		$expected = preg_replace('/\s+/S', " ", $expected);

		$this->assertEquals($expected, $sql);
	}

}