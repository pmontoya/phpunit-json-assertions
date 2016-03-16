# phpunit-json-assertions

JSON assertions for PHPUnit includes traits/methods to help validate your JSON data through various methods.

## Features

* Validate your JSON data via JSON Schema
    * describes your existing data format
    * clear, human- and machine-readable documentation
    * complete structural validation, useful for
        * automated testing
        * validating client-submitted data
    * See more details [here](http://json-schema.org/)
* Access JSON data through expressions (e.g. `foo.bar[3]`)
    * See more details [here](http://jmespath.org/examples.html)

## Install

    $ composer require estahn/phpunit-json-assertions --dev
    
or in your `composer.json`:

```json
{
    "require-dev": {
        "estahn/phpunit-json-assertions": "@stable"
    }
}
```

## Asserts

| Assert                        | Description                                                                  |
| ----------------------------- | ---------------------------------------------------------------------------- |
| assertJsonMatchesSchema       | Asserts that json content is valid according to the provided schema file     |
| assertJsonMatchesSchemaString | Asserts that json content is valid according to the provided schema string   |
| assertJsonValueEquals         | Asserts if the value retrieved with the expression equals the expected value |

## Usage

You can either use the `trait` or `class` version.

### Trait

```php
<?php

namespace EnricoStahn\JsonAssert\Tests;

use EnricoStahn\JsonAssert\Assert as JsonAssert;

class MyTestCase extends \PHPUnit_Framework_TestCase
{
    use JsonAssert;
    
    public function testJsonDocumentIsValid()
    {
        // my-schema.json
        //
        // {
        //   "type" : "object",
        //   "properties" : {
        //     "foo" : {
        //       "type" : "integer"
        //     }
        //   },
        //   "required" : [ "foo" ]
        // }
    
        $json = json_decode('{"foo":1}');
        
        $this->assertJsonMatchesSchemaString('./my-schema.json', $json);
        $this->assertJsonValueEquals(1, '* | [0]', $json);
    }
}
```

### Class

In case you don't want to use the `trait` you can use the provided class wich extends from `\PHPUnit_Framework_TestCase`.
You can either extend your test case or use the static methods like below.

```php
<?php

namespace EnricoStahn\JsonAssert\Tests;

use EnricoStahn\JsonAssert\AssertClass as JsonAssert;

class MyTestCase extends \PHPUnit_Framework_TestCase
{
    public function testJsonDocumentIsValid()
    {
        // my-schema.json
        //
        // {
        //   "type" : "object",
        //   "properties" : {
        //     "foo" : {
        //       "type" : "integer"
        //     }
        //   },
        //   "required" : [ "foo" ]
        // }
    
        $json = json_decode('{"foo":1}');
        
        JsonAssert::assertJsonMatchesSchemaString('./my-schema.json', $json);
        JsonAssert::assertJsonValueEquals(1, '* | [0]', $json);
    }
}
```

## Tests

To run the test suite, you need [composer](http://getcomposer.org).

    $ composer install
    $ bin/phpunit

## License

The phpunit-json-assertions library is licensed under the [MIT](LICENSE).