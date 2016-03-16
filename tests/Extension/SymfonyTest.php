<?php

namespace EnricoStahn\JsonAssert\Tests\Extension;

use EnricoStahn\JsonAssert\Extension\Symfony;
use EnricoStahn\JsonAssert\Tests\Utils;
use Symfony\Component\HttpFoundation\Response;

class SymfonyTest extends \PHPUnit_Framework_TestCase
{
    public function testAssertJsonMatchesSchema()
    {
        $schema = Utils::getSchemaPath('test.schema.json');
        $response = new Response(file_get_contents(Utils::getJsonPath('simple.json')));

        Symfony::assertJsonMatchesSchema($schema, $response);
    }

    public function testAssertJsonMatchesSchemaString()
    {
        $schema = file_get_contents(Utils::getSchemaPath('test.schema.json'));
        $response = new Response(file_get_contents(Utils::getJsonPath('simple.json')));

        Symfony::assertJsonMatchesSchemaString($schema, $response);
    }

    public function testAssertJsonValueEquals()
    {
        $response = new Response(file_get_contents(Utils::getJsonPath('simple.json')));

        Symfony::assertJsonValueEquals(123, 'foo', $response);
    }
}