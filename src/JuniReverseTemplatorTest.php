<?php

use JuniReverseTemplator\InvalidTemplateException;
use JuniReverseTemplator\JuniReverseTemplator;
use JuniReverseTemplator\ResultTemplateMismatchException;
use PHPUnit\Framework\TestCase;

class JuniReverseTemplatorTest extends TestCase {

    /**
    * @dataProvider successData
    */
    public function test_reverseSuccess($template, $result, $returned) {

        $templator = new JuniReverseTemplator();

        $this->assertEquals($templator->reverse($template, $result), $returned);
    }


    public function successData(): array {
        return [
            ['Hello, my name is {{name}}', 'Hello, my name is Nik', ['name' => 'Nik']],
            ['Hello, my name is {{name}}', 'Hello, my name is <Nik>', ['name' => "<Nik>"]],
            ['Hello, my name is {name}', 'Hello, my name is <Nik>', ['name' => "<Nik>"]],
            ['Hello, my name is {{name}}', 'Hello, my name is &lt;Nik&gt;', ['name' => "<Nik>"]],
            ['Hello, my name is {{name}}', 'Hello, my name is ', ['name' => ""]],
            ['{{a}}, {{b}} and {{c}}', 'a, b and c', ['a' => 'a', 'b' => 'b', 'c' => 'c']],
            ['{{a}}{{b}}{{c}}', 'abc', ['a' => 'abc', 'b' => '', 'c' => '']],
        ];
    }

    /**
    * @dataProvider errorData
    */
    public function test_reverseError($template, $result, $exception) {
        $this->expectException($exception);

        $templator = new JuniReverseTemplator();
        $templator->reverse($template, $result);
    }


    public function errorData(): array {
        return [
            ['Hello, my name is {name}}', 'Hello, my name is Nik', InvalidTemplateException::class],
            ['Hello, my name is {{name}', 'Hello, my name is Nik', InvalidTemplateException::class],
            ['Hello, my name is {name}', 'Hello my name is Nik', ResultTemplateMismatchException::class],
            ['{{{s}}{d}{{}}}', 'qwerty123', InvalidTemplateException::class],
            ['{a}x{v}{d}', 'Hello my name is Nik', ResultTemplateMismatchException::class]
        ];
    }
}
