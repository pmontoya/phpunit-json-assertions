<?php

namespace EnricoStahn\JsonAssert\Tests;

class Utils
{
    /**
     * Returns the full path of the schema file
     *
     * @param string $filename The filename of the schema file
     * @return string
     */
    public static function getSchemaPath($filename)
    {
        return implode(DIRECTORY_SEPARATOR, [__DIR__, 'schemas', $filename]);
    }

    /**
     * Returns the full path of the schema file
     *
     * @param string $filename The filename of the json file
     * @return string
     */
    public static function getJsonPath($filename)
    {
        return implode(DIRECTORY_SEPARATOR, [__DIR__, 'json', $filename]);
    }
}