<?php

namespace CrazyFactory\Utils\Test;

use CrazyFactory\Utils\Arrays;

class Foo {

}

class Bar extends Foo {
	
}

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


	public function provideFortTstHasOnlyElementsOfClass() {
		return array(
			array(
				array(new Foo(), new Bar()),
				false,
				true
			),
			array(
				array(new Foo(), null, new Bar()),
				false,
				false
			),
			array(
				array(new Foo(), null, new Bar()),
				true,
				true,
			),
			array(
				array(null),
				true,
				true
			),
			array(
				array(),
				false,
				true
			),
			array(
				array(17),
				true,
				false
			)
		);
	}

	/**
	 * @dataProvider provideFortTstHasOnlyElementsOfClass
	 */
	public function testHasOnlyElementsOfClass($list, $allowNullElements, $expected) {
		$result = Arrays::hasOnlyElementsOfClass($list, Foo::class, $allowNullElements);
		$this->assertEquals($expected, $result);
	}
}