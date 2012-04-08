<?php

namespace Madalynn\Bundle\AndroBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TipControllerTest extends WebTestCase
{
    const NO_TIPS = 'No tips to display';

    protected $client;

    public function setUp()
    {
        $this->client = self::createClient();
    }

    public function testWithLocale()
    {
        $this->client->request('GET', '/tip/fr');
        $response = $this->client->getResponse();

        $this->assertNotEmpty($response->getContent());
        $this->assertNotEquals(self::NO_TIPS, $response->getContent());
    }

    public function testWithoutLocale()
    {
        $this->client->request('GET', '/tip');
        $this->assertEquals(404, $this->client->getResponse()->getStatusCode());
    }

    public function testMalformedDate()
    {
        $this->client->request('GET', '/tip/en/2012-13-12');
        $response = $this->client->getResponse();

        $this->assertNotEmpty($response->getContent());
        $this->assertNotEquals(self::NO_TIPS, $response->getContent());
    }

    public function testUnknowLocale()
    {
        $this->client->request('GET', '/tip/es');
        $this->assertEquals(self::NO_TIPS, $this->client->getResponse()->getContent());
    }

    public function testWithDate()
    {
        $this->client->request('GET', '/tip/en/2011-12-25');
        $this->assertEquals('We wish you a merry christmas... *sings*', $this->client->getResponse()->getContent());
    }
}