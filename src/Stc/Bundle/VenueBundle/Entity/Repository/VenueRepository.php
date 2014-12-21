<?php

namespace Stc\Bundle\VenueBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

use Stc\Bundle\VenueBundle\Entity\Venue;

class VenueRepository extends EntityRepository
{
    public function getAllVenuesWithCoordinates()
    {
        return $this->createQueryBuilder('venue')
            ->select('venue.name, venue.description, venue.venueType, venue.website, venue.capacity, venue.jjwgMapsLatC, venue.jjwgMapsLngC')
            ->where('venue.deleted = 0')
            ->andWhere("venue.jjwgMapsLatC != ''")
            ->getQuery()
            ->execute();
    }

    public function getAllVenuesWithLookupFields()
    {
        return $this->createQueryBuilder('venue')
            ->select("venue.id, venue.name, venue.description, venue.venueType, venue.website, venue.capacity, venue.jjwgMapsLatC, venue.jjwgMapsLngC, CONCAT(venue.billingAddressStreet, ' ', venue.billingAddressCity, ' ', venue.billingAddressState, ' ', venue.billingAddressPostalcode, ' ', venue.billingAddressCountry) AS address")
            ->where('venue.deleted = 0')
            ->getQuery()
            ->execute();
    }
}