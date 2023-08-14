<?php

namespace Unit;

use Tests\Support\UnitTester;
use utils\ArrayUtil;

require_once 'app/ArrayUtil.php';

class ArrayUtilTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    protected function _before()
    {
    }

    public function testDigSetEmptyArray()
    {
		$input = [];
		$ret = ArrayUtil::digSet($input, 'test', 5);
		$this->assertEquals(5, $ret);
		$this->assertEquals(['test' => 5], $input);
		
		$input = [];
		$ret = ArrayUtil::digSet($input, 'test', 'foo', 'bar', 3);
		$this->assertEquals(3, $ret);
		$this->assertEquals(['test' => ['foo' => ['bar' => 3]]], $input);
    }

    public function testDigSetDnEmptyArray()
    {
        $input = [];
        $ret = ArrayUtil::digSetDn($input, 'test', 5);
        $this->assertEquals(5, $ret);
        $this->assertEquals(['test' => 5], $input);

        $input = [];
        $ret = ArrayUtil::digSetDn($input, 'test.foo.bar', 3);
        $this->assertEquals(3, $ret);
        $this->assertEquals(['test' => ['foo' => ['bar' => 3]]], $input);
    }

    public function testDigSetSingleLayerArray()
	{
		$input = ['foo' => 0];
		$ret = ArrayUtil::digSet($input, 'foo', 10);
		$this->assertEquals(10, $ret);
		$this->assertEquals(['foo' => 10], $input);

		$ret = ArrayUtil::digSet($input, 'foo', 5);
		$this->assertEquals(5, $ret);
		$this->assertEquals(['foo' => 5], $input);

		$ret = ArrayUtil::digSet($input, 'bar', 3);
		$this->assertEquals(3, $ret);
		$this->assertEquals(['foo' => 5, 'bar' => 3], $input);

		$ret = ArrayUtil::digSet($input, 'bar', 8);
		$this->assertEquals(8, $ret);
		$this->assertEquals(['foo' => 5, 'bar' => 8], $input);
	}

    public function testDigSetDnSingleLayerArray()
    {
        $input = ['foo' => 0];
        $ret = ArrayUtil::digSetDn($input, 'foo', 10);
        $this->assertEquals(10, $ret);
        $this->assertEquals(['foo' => 10], $input);

        $ret = ArrayUtil::digSetDn($input, 'foo', 5);
        $this->assertEquals(5, $ret);
        $this->assertEquals(['foo' => 5], $input);

        $ret = ArrayUtil::digSetDn($input, 'bar', 3);
        $this->assertEquals(3, $ret);
        $this->assertEquals(['foo' => 5, 'bar' => 3], $input);

        $ret = ArrayUtil::digSetDn($input, 'bar', 8);
        $this->assertEquals(8, $ret);
        $this->assertEquals(['foo' => 5, 'bar' => 8], $input);

        $ret = ArrayUtil::digSetDn($input, '.bar', 9);
        $this->assertEquals(9, $ret);
        $this->assertEquals(['foo' => 5, 'bar' => 9], $input);

        $ret = ArrayUtil::digSetDn($input, '..bar', '10');
        $this->assertEquals('10', $ret);
        $this->assertEquals(['foo' => 5, 'bar' => '10'], $input);

        $ret = ArrayUtil::digSetDn($input, 'bar.', '11');
        $this->assertEquals('11', $ret);
        $this->assertEquals(['foo' => 5, 'bar' => '11'], $input);
    }

    public function testDigSetMultiLayerArray()
	{
		$input = [
			1 => ['foo' => ['bar' => 8]],
			'test' => ['bar' => 7],
			'another' => ['foo' => ['bar' => 1]]
		];
		$ret = ArrayUtil::digSet($input, 1, 'foo', 'bar', 1);
		$this->assertEquals(1, $ret);
		$this->assertEquals(
			[
				1 => ['foo' => ['bar' => 1]],
				'test' => ['bar' => 7],
				'another' => ['foo' => ['bar' => 1]]
			],
			$input);
		$ret = ArrayUtil::digSet($input, 1, 'foo', 'bar2', 5);
		$this->assertEquals(5, $ret);
		$this->assertEquals(
			[
				1 => ['foo' => ['bar' => 1, 'bar2' => 5]],
				'test' => ['bar' => 7],
				'another' => ['foo' => ['bar' => 1]]
			],
			$input);
        $ret = ArrayUtil::digSet($input, 1, 'foo', 'bar3', 100, 'xyz'); // pass the last parameter as string.
		$this->assertEquals('xyz', $ret);
		$this->assertEquals(
			[
				1 => ['foo' => ['bar' => 1, 'bar2' => 5, 'bar3' => [100 => 'xyz']]],
				'test' => ['bar' => 7],
				'another' => ['foo' => ['bar' => 1]]
			],
			$input);
	}

    public function testDigSetDnMultiLayerArray()
    {
        $input = [
            1 => ['foo' => ['bar' => 8]],
            'test' => ['bar' => 7],
            'another' => ['foo' => ['bar' => 1]]
        ];
        $ret = ArrayUtil::digSetDn($input, '1.foo.bar', 1);
        $this->assertEquals(1, $ret);
        $this->assertEquals(
            [
                1 => ['foo' => ['bar' => 1]],
                'test' => ['bar' => 7],
                'another' => ['foo' => ['bar' => 1]]
            ],
            $input);
        $ret = ArrayUtil::digSetDn($input, '1.foo.bar2', 5);
        $this->assertEquals(5, $ret);
        $this->assertEquals(
            [
                1 => ['foo' => ['bar' => 1, 'bar2' => 5]],
                'test' => ['bar' => 7],
                'another' => ['foo' => ['bar' => 1]]
            ],
            $input);
        $ret = ArrayUtil::digSetDn($input, '1.foo.bar3.100', 'xyz'); // pass the last parameter as string.
        $this->assertEquals('xyz', $ret);
        $this->assertEquals(
            [
                1 => ['foo' => ['bar' => 1, 'bar2' => 5, 'bar3' => [100 => 'xyz']]],
                'test' => ['bar' => 7],
                'another' => ['foo' => ['bar' => 1]]
            ],
            $input);
    }

    public function testDigSetExceptionOfNumberOfParameters()
	{
		$this->expectExceptionMessage('it needs at least 3 parameters consists of array, index(es), value.');
		$input = [];
		ArrayUtil::digSet($input, 'foo');
	}

    public function testDigSetDnExceptionOfNumberOfParameters1()
    {
        $this->expectExceptionMessage('index(es) are not provided.');
        $input = [];
        ArrayUtil::digSetDn($input, '', 'xyz');
    }

    public function testDigSetDnExceptionOfNumberOfParameters2()
    {
        $this->expectExceptionMessage('index(es) are not provided.');
        $input = [];
        ArrayUtil::digSetDn($input, '.', 'xyz');
    }

    public function testDigSetDnExceptionOfNumberOfParameters3()
    {
        $this->expectExceptionMessage('index(es) are not provided.');
        $input = [];
        ArrayUtil::digSetDn($input, '..', 'xyz');
    }

    public function testDigSetExceptionOfIntermediateIndexValueIsNotArray1()
    {
        $this->expectExceptionMessage("value by intermediate index 'foo' is not an array.");
        $input = ['foo' => 'bar'];
        ArrayUtil::digSet($input, 'foo', 'bar', 100);
    }

    public function testDigSetDnExceptionOfIntermediateIndexValueIsNotArray1()
	{
		$this->expectExceptionMessage("value by intermediate index 'foo' is not an array.");
		$input = ['foo' => 'bar'];
		ArrayUtil::digSetDn($input, 'foo.bar', 100);
	}

	public function testDigSetExceptionOfIntermediateIndexValueIsNotArray2()
	{
		$this->expectExceptionMessage("value by intermediate index 'bar' is not an array.");
		$input = ['foo' => ['bar' => 1]];
		ArrayUtil::digSet($input, 'foo', 'bar' , 'ouch', 100);
	}

    public function testDigSetDnExceptionOfIntermediateIndexValueIsNotArray2()
    {
        $this->expectExceptionMessage("value by intermediate index 'bar' is not an array.");
        $input = ['foo' => ['bar' => 1]];
        ArrayUtil::digSetDn($input, 'foo.bar.ouch', 100);
    }
}
