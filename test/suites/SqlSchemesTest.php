<?php
/**
 * @license see LICENSE
 */

namespace CrazyFactory\Core\Test;

use CrazyFactory\Utils\SqlSchemes;

class SqlSchemesTest extends \PHPUnit_Framework_TestCase
{
	public function providerForDetermineTableFromClassName() {
		return array(
			array(null, null),
			array('User', 'Users'),
			array('Users', 'Users'),
			array('UserCollection', 'Users'),
			array('UsersCollection', 'Users'),
			array('UserSet', 'Users'),
			array('UsersSet', 'Users'),
			array('UserTable', 'Users'),
			array('UsersTable', 'Users'),
			array('Sets', 'Sets'),
			array('Collections', 'Collections'),
			array('CrazyFactory\Core\Test\SampleCollection', 'Samples')
		);
	}

	/**
	 * @dataProvider providerForDetermineTableFromClassName
	 *
	 * @param string $className
	 * @param string $expected
	 */
	public function testDetermineTableName($className, $expected) {
		$this->assertEquals($expected, SqlSchemes::determineTableName($className));
	}
}