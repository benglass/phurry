<?php

namespace Phurry\Tests;

use Phurry\Phurry;

class EverythingTest extends \PHPUnit_Framework_TestCase
{
    public function testCanCreateCurriedFunctionFromClosure()
    {
        $phurry = new Phurry;

        $curriedFn = $phurry->curry(function($a) {
        });

        $this->assertInstanceOf('Closure', $curriedFn);
    }

    public function testCanCurryFunctionArguments()
    {
        $phurry = new Phurry;

        $curriedFn = $phurry->curry(function($a, $b, $c) {
            return $a + $b + $c;
        });

        $add3 = $curriedFn(3);
        $add7 = $add3(4);

        $this->assertEquals(10, $add7(3));
    }

    public function testCreateCurriedFunctionWithNoArgumentsThrowsInvalidArgumentException()
    {
        $phurry = new Phurry;

        $this->setExpectedException('InvalidArgumentException');

        $curriedFn = $phurry->curry(function() {
        });
    }

    public function testCreateCurriedFunctionWithTooManyArgumentsThrowsInvalidArgumentException()
    {
        $phurry = new Phurry;

        $curriedFn = $phurry->curry(function($a, $b) {
        });

        $this->setExpectedException('InvalidArgumentException');

        $curriedFn(5, 6, 7);
    }
}
