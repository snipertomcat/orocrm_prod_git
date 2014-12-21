<?php

namespace Stc\Bundle\GoogleMapBundle\Service\Geocoder;

use Ivory\GoogleMap\Services\Geocoding\Geocoder;
use Ivory\GoogleMap\Services\Geocoding\GeocoderProvider;
use Geocoder\HttpAdapter\CurlHttpAdapter;

class AdHocGeocoder
{
    protected $geocoder;

    public function __construct()
    {
        $this->geocoder = new Geocoder();
        $this->geocoder->registerProviders([
            new GeocoderProvider(new CurlHttpAdapter()),
        ]);
    }

    public function geocode($address)
    {
        return $this->geocoder->geocode($address);
    }

}