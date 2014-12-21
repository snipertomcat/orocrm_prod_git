<?php

namespace Stc\Bundle\GoogleMapBundle\DataBuilder;


// @todo change to AbstractMapBuilder
use Ivory\GoogleMapBundle\Model\MapBuilder;
use Stc\Bundle\BandBundle\Entity\Band;
use Stc\Bundle\VenueBundle\Entity\Venue;
use Ivory\GoogleMap\Overlays\InfoWindow;
use Ivory\GoogleMap\Overlays\Marker as MarkerOverlay;

abstract class AbstractDataBuilder
{
    protected function setMapConfig(MapBuilder $map)
    {
        // map options
        $map->setAsync(true);
        $map->setHtmlContainerId('map_canvas');

        $map->setCenter(39.102951, -94.5830765, true);

        // map size
        $map->setStylesheetOptions(array(
            'width'  => '1200px',
            'height' => '950px',
            'margin-left' => '100px',
            
        ));

        //$map->build();

        return $map;
    }

    protected function addMarker($coordinate)
    {
        if ($coordinate instanceof Band || $coordinate instanceof Venue) {
            $newCoordinate = array(
                'description' => $coordinate->getDescription(),
                'jjwgMapsLatC' => $coordinate->getJjwgMapsLatC(),
                'jjwgMapsLngC' => $coordinate->getJjwgMapsLngC(),
                'name' => $coordinate->getName()
            );
        } else {
            $newCoordinate = $coordinate;
        }

        $newCoordinate['description'] = htmlentities($newCoordinate['description']);
        $newCoordinateBuilder = $this->map->getCoordinateBuilder();
        $newCoordinateBuilder->setLatitude($newCoordinate['jjwgMapsLatC']);
        $newCoordinateBuilder->setLongitude($newCoordinate['jjwgMapsLngC']);

        $newMarker = new MarkerOverlay($newCoordinateBuilder->build());
        $desc = str_split($newCoordinate['description'], 75)[0];

        $infoWindowHtml = "<strong>".$newCoordinate['name']."</strong><br />";
        $infoWindowHtml .= "<p> $desc </p><br />";

        $newMarker->setInfoWindow(
            new InfoWindow(($infoWindowHtml))
        );
        $this->temp->addMarker($newMarker);

        $this->markerBuilder->reset();
        $this->map->reset();
    }

}