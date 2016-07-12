<?php

namespace CrazyFactory\Utils\Test;

use CrazyFactory\Utils\Arrays;

class ArraysTest extends \PHPUnit_Framework_TestCase
{
	public function provideForTestGetElementKeys() {
		return array(
			// #0
			array(
				array(
					array('location' => 'Kansas', 'age' => 13, 'name' => 'Alice'),
					array('location' => 'Wonderland', 'name' => 'Mad Hatter', 'age' => 645)
				),
				array('age', 'location', 'name')
			),
			// #1
			array(
				array(),
				array()
			),
			// #2
			array(
				array(
					array('age' => 13, 'name' => 'Alice'),
					array('age' => 645, 'location' => 'Wonderland')
				),
				array('age', 'location', 'name')
			),
			// #3
			array(
				array(
					array(),
					null,
					array('firstname' => 'Peter', 'lastname' => null),
					array('profession' => 'Nurse')
				),
				array('firstname', 'lastname', 'profession')
			)
		);
	}

	/**
	 * @dataProvider provideForTestGetElementKeys
	 */
	public function testGetElementKeys($list, $expected) {
		$this->assertEquals($expected, Arrays::getElementKeys($list));
	}
}