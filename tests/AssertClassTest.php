<?php

namespace EnricoStahn\JsonAssert\Tests;

use EnricoStahn\JsonAssert\AssertClass;

class AssertClassTest extends \PHPUnit_Framework_TestCase
{
    public function testClassInstance()
    {
        static::assertInstanceOf('EnricoStahn\JsonAssert\AssertClass', new AssertClass());
    }
}
