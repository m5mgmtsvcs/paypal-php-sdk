<?php

namespace PayPal\Test\Api;

use PayPal\Api\RedirectUrls;
use PHPUnit\Framework\TestCase;

/**
 * Class RedirectUrls
 *
 * @package PayPal\Test\Api
 */
class RedirectUrlsTest extends TestCase
{
    /**
     * Gets Json String of Object RedirectUrls
     * @return string
     */
    public static function getJson()
    {
        return '{"return_url":"http://www.google.com","cancel_url":"http://www.google.com"}';
    }

    /**
     * Gets Object Instance with Json data filled in
     * @return RedirectUrls
     */
    public static function getObject()
    {
        return new RedirectUrls(self::getJson());
    }


    /**
     * Tests for Serialization and Deserialization Issues
     * @return RedirectUrls
     */
    public function testSerializationDeserialization()
    {
        $obj = new RedirectUrls(self::getJson());
        $this->assertNotNull($obj);
        $this->assertNotNull($obj->getReturnUrl());
        $this->assertNotNull($obj->getCancelUrl());
        $this->assertEquals(self::getJson(), $obj->toJson());
        return $obj;
    }

    /**
     * @depends testSerializationDeserialization
     * @param RedirectUrls $obj
     */
    public function testGetters($obj)
    {
        $this->assertEquals($obj->getReturnUrl(), "http://www.google.com");
        $this->assertEquals($obj->getCancelUrl(), "http://www.google.com");
    }

    public function testUrlValidationForReturnUrl()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('ReturnUrl is not a fully qualified URL');

        $obj = new RedirectUrls();
        $obj->setReturnUrl(null);
    }

    public function testUrlValidationForCancelUrl()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('CancelUrl is not a fully qualified URL');

        $obj = new RedirectUrls();
        $obj->setCancelUrl(null);
    }
}
