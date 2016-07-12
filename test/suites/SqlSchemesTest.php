<?php
/**
 * @license see LICENSE
 */

namespace CrazyFactory\Core\Test;

use CrazyFactory\Utils\SqlSchemes;

class SqlSchemesTest extends \PHPUnit_Framework_TestCase
{
	public function providerForDetermineTableFromClassName() {
		return [
			[null, null],
			['User', 'Users'],
			['Users', 'Users'],
			['UserCollection', 'Users'],
			['UsersCollection', 'Users'],
			['UserSet', 'Users'],
			['UsersSet', 'Users'],
			['UserTable', 'Users'],
			['UsersTable', 'Users'],
			['Sets', 'Sets'],
			['Collections', 'Collections'],
			['CrazyFactory\Core\Test\SampleCollection', 'Samples']
		];
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