<?php


namespace Stc\Bundle\GoogleMapBundle\DataBuilder;

use Doctrine\ORM\EntityManager;
use Ivory\GoogleMapBundle\Model\Overlays\MarkerBuilder;
use Ivory\GoogleMapBundle\Model\MapBuilder;
use Stc\Bundle\GoogleMapBundle\Service\Geocoder\AdHocGeocoder as AdHocGeocoder;


// @todo change to BandMapBuilder
class BandDataBuilder extends AbstractDataBuilder
{
    protected $manager;

    protected $mapBuilder;

    protected $markerBuilder;

    protected $geocoder;

    public function __construct(EntityManager $manager, MapBuilder $mapBuilder, MarkerBuilder $markerBuilder)
    {
        $this->manager = $manager;
        $this->mapBuilder = $mapBuilder;
        $this->markerBuilder = $markerBuilder;
        $this->geocoder = new AdHocGeocoder();
    }

    public function build()
    {
        $repository = $this->manager->getRepository('StcBandBundle:Band');
        $coordinates = $repository->getAllBandsWithCoordinates();

        $map = $this->mapBuilder;
        $marker = $this->markerBuilder;

        $this->map = $this->setMapConfig($map);

        $this->temp = $map->build();

        foreach ($coordinates as $coordinate) {
            $this->addMarker($coordinate);
        }

        return $this->temp;

    }

    /**
     * The idea of this method is to return a map that includes all bands regardless of geolocation status.
     * All newly entered (i.e. non-geocoded) records are auto-geocoded and re-persisted to the database before
     * they are added to the map. That said, it may take a while to run.
     */
    public function buildWithLookup()
    {
        $repository = $this->manager->getRepository('StcBandBundle:Band');
        $coordinates = $repository->getAllBandsWithLookupFields();

        //echo "<pre>";print_r($coordinates);exit;

        $map = $this->mapBuilder;
        $marker = $this->markerBuilder;

        $map = $this->setMapConfig($map);

        $this->map = $map;
        $this->temp = $map->build();

        // @todo Change the $coordinates variable to be a collection of entities instead of an array
        foreach ($coordinates as $coordinate) {
            if ($coordinate['jjwgMapsLatC'] !== '') {
                $this->addMarker($coordinate);
            } else {
                if ($coordinate['address'] !== '' && $coordinate['address'] !== null) {
                    $geocodeResponse = $this->geocoder->geocode($coordinate['address']);
                    $results = $geocodeResponse->getResults();
                    foreach ($results as $result) {
                        $location = $result->getGeometry()->getLocation();
                        break;
                    }
                    $lat = $location->getLatitude();
                    $lng = $location->getLongitude();

                    // @todo once there are entities inside $coordinates instead of array, remove this code and set the new data inline with geocoder response
                    $bandObject = $repository->find($coordinate['id']);
                    $bandObject->setJjwgMapsLatC($lat);
                    $bandObject->setJjwgMapsLngC($lng);
                    $this->manager->persist($bandObject);

                    $this->addMarker($bandObject);
                }
            }
        }
        $this->manager->flush();

        /*
         * use this statement to verify the number of bands against the database:
         */
        //echo count($this->temp->getMarkers());exit;
        return $this->temp;
    }

}