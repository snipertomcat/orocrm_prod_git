<?php

namespace Stc\Bundle\SalesBundle\Tests\functional\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LeadControllerTest extends WebTestCase
{
    public function testUpdate()
    {
        $client = static::createClient();

        $container = $client->getContainer();

        print_r($container->get('stc_performance.listener.create_performance'));

        exit;
        $this->assertTrue(1);

    }
}