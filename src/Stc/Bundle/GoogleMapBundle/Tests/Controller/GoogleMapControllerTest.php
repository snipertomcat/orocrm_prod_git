<?php

namespace Stc\Bundle\GoogleMapBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GoogleMapController extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/googlemaps/googlemaps/');

        echo $crawler->filter('html:contains("google.maps.LatLng")')->count();
        exit;
    }
}
