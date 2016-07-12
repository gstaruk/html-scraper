<?php

use App\Services\ScrapeService;
use Tests\StubCurl;

/**
 * Scrape service test
 */
class ScrapeServiceTest extends \PHPUnit_Framework_TestCase
{
    private $url;
    private $service;

    /**
     * Set up function
     */
    protected function setUp()
    {
        $this->service = new ScrapeService();
        $this->url = 'http://hiring-tests.s3-website-eu-west-1.amazonaws.com/2015_Developer_Scrape/5_products.html';
    }

	/**
     * Test where the HTTP status returns 200
     */
    public function testValidStatus()
    {
        $curl = new StubCurl();
        $curl->setStatus(200);

        $result = $this->service->getData($this->url, $curl);

        // should return an instance of class Curl
        $this->assertInstanceOf(App\Helpers\Curl::class, $result);
    }

    /**
     * Test where the HTTP status returns 500
     */
    public function testInvalidStatus()
    {
        $curl = new StubCurl();
        $curl->setStatus(500);

        $result = $this->service->getData($this->url, $curl);

        // should return boolean false
        $this->assertFalse($result);
    }

    /**
     * Test the response is an array and contains 
     */
    public function testGetItemsIsArray()
    {
        $this->service->url = $this->url;

        $result = $this->service->getItems();

        $this->assertInternalType('array', $result);
        $this->assertArrayHasKey('results', $result);
        $this->assertArrayHasKey('total', $result);
    }
}