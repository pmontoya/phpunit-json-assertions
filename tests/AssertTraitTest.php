<?php

/*
 * This file is part of the phpunit-json-assertions package.
 *
 * (c) Enrico Stahn <enrico.stahn@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EnricoStahn\JsonAssert\Tests;

class AssertTraitTest extends \PHPUnit_Framework_TestCase
{
    private static function getSchema($filename)
    {
        return implode(DIRECTORY_SEPARATOR, [__DIR__, 'schemas', $filename]);
    }

    private static function getJson($filename)
    {
        return implode(DIRECTORY_SEPARATOR, [__DIR__, 'json', $filename]);
    }

    public function testAssertJsonSchema()
    {
        $content = json_decode('{"foo":123}');

        AssertTraitImpl::assertJsonMatchesSchema(self::getSchema('test.schema.json'), $content);
    }

    /**
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     */
    public function testAssertJsonSchemaFail()
    {
        $content = json_decode('{"foo":"123"}');

        AssertTraitImpl::assertJsonMatchesSchema(self::getSchema('test.schema.json'), $content);
    }

    public function testAssertJsonSchemaFailMessage()
    {
        $content = json_decode('{"foo":"123"}');

        $exception = null;

        try {
            AssertTraitImpl::assertJsonMatchesSchema(self::getSchema('test.schema.json'), $content);
        } catch (\PHPUnit_Framework_ExpectationFailedException $exception) {
            self::assertContains('- Property: foo, Contraint: type, Message: String value found, but an integer is required', $exception->getMessage());
            self::assertContains('- Response: {"foo":"123"}', $exception->getMessage());
        }

        self::assertInstanceOf('PHPUnit_Framework_ExpectationFailedException', $exception);
    }

    /**
     * Tests if referenced schemas are loaded automatically
     */
    public function testAssertJsonSchemaWithRefs()
    {
        $content = json_decode('{"code":123, "message":"Nothing works."}');

        AssertTraitImpl::assertJsonMatchesSchema(self::getSchema('error.schema.json'), $content);
    }

    /**
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     */
    public function testAssertJsonSchemaWithRefsFails()
    {
        $content = json_decode('{"code":"123", "message":"Nothing works."}');

        AssertTraitImpl::assertJsonMatchesSchema(self::getSchema('error.schema.json'), $content);
    }

    public function testAssertJsonMatchesSchemaString()
    {
        $content = json_decode('{"foo":123}');
        $schema = file_get_contents(self::getSchema('test.schema.json'));

        AssertTraitImpl::assertJsonMatchesSchemaString($schema, $content);
    }

    /**
     * Tests assertJsonValueEquals().
     *
     * @dataProvider assertJsonValueEqualsProvider
     *
     * @param string $expression
     * @param mixed  $value
     */
    public function testAssertJsonValueEquals($expression, $value)
    {
        $content = json_decode(file_get_contents(self::getJson('testAssertJsonValueEquals.json')));

        AssertTraitImpl::assertJsonValueEquals($value, $expression, $content);
    }

    public function assertJsonValueEqualsProvider()
    {
        return [
            ['foo', '123'],
            ['a.b.c[0].d[1][0]', 1],
        ];
    }

    /**
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     */
    public function testAssertJsonValueEqualsFailsOnWrongDataType()
    {
        $content = json_decode(file_get_contents(self::getJson('testAssertJsonValueEquals.json')));

        AssertTraitImpl::assertJsonValueEquals($content, 'a.b.c[0].d[1][0]', '1');
    }

    /**
     * @dataProvider testGetJsonObjectProvider
     */
    public function testGetJsonObject($expected, $actual)
    {
        self::assertEquals($expected, AssertTraitImpl::getJsonObject($actual));
    }

    public function testGetJsonObjectProvider()
    {
        return [
            [[], []],
            [[], '[]'],
            [new \stdClass(), new \stdClass()],
            [new \stdClass(), '{}'],
        ];
    }
}
