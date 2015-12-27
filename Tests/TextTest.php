<?php

namespace Zimbra\Common\Tests;

use \PHPUnit_Framework_TestCase;
use Faker\Factory as FakerFactory;
use Zimbra\Common\Text;

/**
 * Testcase class for text.
 */
class TextTest extends PHPUnit_Framework_TestCase
{
    public function testIsRgb()
    {
        $this->assertTrue(Text::isRgb('#112233'));
        $this->assertTrue(Text::isRgb('#1122ff'));
        $this->assertTrue(Text::isRgb('#11ff33'));
        $this->assertTrue(Text::isRgb('#ff2233'));
        $this->assertTrue(Text::isRgb('#aabbcc'));

        $this->assertFalse(Text::isRgb('#1122gg'));
        $this->assertFalse(Text::isRgb('#11gg33'));
        $this->assertFalse(Text::isRgb('#gg2233'));
        $this->assertFalse(Text::isRgb('#aabbgg'));
        $this->assertFalse(Text::isRgb('#aaggcc'));
        $this->assertFalse(Text::isRgb('#ggbbcc'));
    }
    public function testIsValidTagName()
    {
        $this->assertTrue(Text::isValidTagName('name'));
        $this->assertTrue(Text::isValidTagName('_name'));
        $this->assertTrue(Text::isValidTagName('ns:name'));
        $this->assertTrue(Text::isValidTagName('year2000'));
        $this->assertTrue(Text::isValidTagName('year_2000'));
        $this->assertTrue(Text::isValidTagName('year-2000'));
        $this->assertTrue(Text::isValidTagName('year.2000'));
        $this->assertTrue(Text::isValidTagName('year 2000'));

        $this->assertFalse(Text::isValidTagName(':name'));
        $this->assertFalse(Text::isValidTagName('.name'));
        $this->assertFalse(Text::isValidTagName(' name'));
        $this->assertFalse(Text::isValidTagName('-name'));
        $this->assertFalse(Text::isValidTagName('2000'));
    }

    public function tesTextractHeaders()
    {
        $headersString = 'HTTP/1.1 200 OK' . "\r\n"
                       . 'Date: Sun, 25 Jun 2006 19:55:19 GMT' . "\r\n"
                       . 'Server: Apache' . "\r\n"
                       . 'X-powered-by: PHP/5.2.4' . "\r\n"
                       . 'Connection: close' . "\r\n"
                       . 'Transfer-encoding: chunked' . "\r\n"
                       . 'Content-type: text/html' . "\r\n";
        $headers =[
            'Date' => 'Sun, 25 Jun 2006 19:55:19 GMT',
            'Server' => 'Apache',
            'X-powered-by' => 'PHP/5.4.4',
            'Connection' => 'close',
            'Transfer-encoding' => 'chunked',
            'Content-type' => 'text/html',
        ];
       $extractHeaders = Text::extractHeaders($headersString);
       $this->assertCount(count($headers), $extractHeaders);
       foreach ($headers as $key => $value)
       {
           $this->assertArrayHasKey($key, $extractHeaders);
           $this->assertSame($value, $extractHeaders[$key]);
       }
    }

    public function testBoolToString()
    {
        $faker = FakerFactory::create();
        $number = mt_rand();
        $string = $faker->word;
        $this->assertSame('true', Text::boolToString(true));
        $this->assertSame('false', Text::boolToString(false));
        $this->assertSame($number, Text::boolToString($number));
        $this->assertSame($string, Text::boolToString($string));
    }
}
