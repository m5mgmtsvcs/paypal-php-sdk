<?php

namespace PayPal\Test\Api;

use PayPal\Common\PayPalModel;
use PayPal\Api\FlowConfig;
use PHPUnit\Framework\TestCase;

/**
 * Class FlowConfig
 *
 * @package PayPal\Test\Api
 */
class FlowConfigTest extends TestCase
{
    /**
     * Gets Json String of Object FlowConfig
     * @return string
     */
    public static function getJson()
    {
        return '{"landing_page_type":"TestSample","bank_txn_pending_url":"http://www.google.com","user_action":"TestSample","return_uri_http_method":"TestSample"}';
    }

    /**
     * Gets Object Instance with Json data filled in
     * @return FlowConfig
     */
    public static function getObject()
    {
        return new FlowConfig(self::getJson());
    }


    /**
     * Tests for Serialization and Deserialization Issues
     * @return FlowConfig
     */
    public function testSerializationDeserialization()
    {
        $obj = new FlowConfig(self::getJson());
        $this->assertNotNull($obj);
        $this->assertNotNull($obj->getLandingPageType());
        $this->assertNotNull($obj->getBankTxnPendingUrl());
        $this->assertNotNull($obj->getUserAction());
        $this->assertNotNull($obj->getReturnUriHttpMethod());
        $this->assertEquals(self::getJson(), $obj->toJson());
        return $obj;
    }

    /**
     * @depends testSerializationDeserialization
     * @param FlowConfig $obj
     */
    public function testGetters($obj)
    {
        $this->assertEquals($obj->getLandingPageType(), "TestSample");
        $this->assertEquals($obj->getBankTxnPendingUrl(), "http://www.google.com");
        $this->assertEquals($obj->getUserAction(), "TestSample");
        $this->assertEquals($obj->getReturnUriHttpMethod(), "TestSample");
    }

    public function testUrlValidationForBankTxnPendingUrl()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('BankTxnPendingUrl is not a fully qualified URL');

        $obj = new FlowConfig();
        $obj->setBankTxnPendingUrl(null);
    }

}
