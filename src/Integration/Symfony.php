<?php

namespace EnricoStahn\JsonAssert\Integration;

use EnricoStahn\JsonAssert\Assert;
use Symfony\Component\HttpFoundation\Response;

trait Symfony
{
    /**
     * Asserts that json content is valid according to the provided schema file.
     *
     * Example:
     *
     *   static::assertJsonMatchesSchema(json_decode('{"foo":1}'), './schema.json')
     *
     * @param string   $schema   Path to the schema file
     * @param Response $response JSON array or object
     */
    public static function assertJsonMatchesSchema($schema, Response $response)
    {
        Assert::assertJsonMatchesSchema($schema, json_decode($response->getContent()));
    }

    /**
     * Asserts that json content is valid according to the provided schema string.
     *
     * @param string   $schema   Schema data
     * @param Response $response JSON content
     */
    public static function assertJsonMatchesSchemaString($schema, Response $response)
    {
        Assert::assertJsonMatchesSchemaString($schema, json_decode($response->getContent()));
    }

    /**
     * Asserts if the value retrieved with the expression equals the expected value.
     *
     * Example:
     *
     *     static::assertJsonValueEquals(33, 'foo.bar[0]', $json);
     *
     * @param mixed    $expected   Expected value
     * @param string   $expression Expression to retrieve the result
     *                             (e.g. locations[?state == 'WA'].name | sort(@))
     * @param Response $response   JSON Content
     */
    public static function assertJsonValueEquals($expected, $expression, $response)
    {
        Assert::assertJsonValueEquals($expected, $expression, json_decode($response->getContent()));
    }
}