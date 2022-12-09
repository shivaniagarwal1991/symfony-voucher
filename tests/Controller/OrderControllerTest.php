<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class OrderControllerTest extends WebTestCase
{
    private $client;
    private $url;
    public function setUp(): void
    {
        // This calls KernelTestCase::bootKernel(), and creates a
        // "client" that is acting as the browser
        $this->client = static::createClient();

        $this->url = 'http://localhost:8001/voucher/';
        parent::setUp();
    }

    /**
     * @dataProvider provideOrderData
     */
    public function testAddOrder(int $expectedResult, array $requestParams): void
    {
        $this->client->request('POST', $this->url . 'order/add', [ 'body' => $requestParams]);
        $response = $this->client->getResponse();
        $this->assertEquals($expectedResult, $response->getStatusCode());
    }


    public function provideOrderData()
    {
        yield 'order without body' => [
            400,
            [],
        ];
    }
}