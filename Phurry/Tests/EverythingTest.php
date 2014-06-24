<?php

namespace Phurry\Tests;

use Phurry\Phurry;

class EverythingTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->phurry = new Phurry;
    }

    public function testCanCreateCurriedFunctionFromClosure()
    {
        $curriedFn = $this->phurry->curry(function($a) {
        });

        $this->assertInstanceOf('Closure', $curriedFn);
    }

    public function testCanCurryFunctionArguments()
    {
        $curriedFn = $this->phurry->curry(function($a, $b, $c) {
            return $a + $b + $c;
        });

        $add3 = $curriedFn(3);
        $add7 = $add3(4);

        $this->assertEquals(10, $add7(3));
    }

    public function testCanCallCurriedFunctionWithAllArguments()
    {
        $curriedFn = $this->phurry->curry(function($a, $b, $c) {
            return $a + $b + $c;
        });

        $this->assertEquals(10, $curriedFn(3, 3, 4));
    }

    public function testCanCallCurriedFunctionWithMultipleArguments()
    {
        $curriedFn = $this->phurry->curry(function($a, $b, $c) {
            return $a + $b + $c;
        });

        $add6 = $curriedFn(3, 3);

        $this->assertEquals(10, $add6(4));
    }

    public function testCanCallCurriedFunctionWithOptionalParameters()
    {
        $curriedFn = $this->phurry->curry(function($a, $b, $c = 'c') {
            return $a . $b . $c;
        });

        $this->assertEquals('abc', $curriedFn('a', 'b'));
    }

    public function testCreateCurriedFunctionWithNoArgumentsThrowsInvalidArgumentException()
    {
        $this->setExpectedException('InvalidArgumentException');

        $curriedFn = $this->phurry->curry(function() {
        });
    }

    public function testCreateCurriedFunctionWithTooManyArgumentsThrowsInvalidArgumentException()
    {
        $curriedFn = $this->phurry->curry(function($a, $b) {
        });

        $this->setExpectedException('InvalidArgumentException');

        $curriedFn(5, 6, 7);
    }
}
