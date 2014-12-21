<?php

namespace Stc\Bundle\BandBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

use Stc\Bundle\BandBundle\Entity\BandStatus;

class BandRepository extends EntityRepository
{
    /**
     * @param BandStatus $status
     * @return integer
     */
    public function getBandCountByStatus(BandStatus $status)
    {
        return $this->createQueryBuilder('band')
            ->select('COUNT(band)')
            ->where('band.status = :status')
            ->setParameter('status', $status)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function getAllBandsWithCoordinates()
    {
        return $this->createQueryBuilder('band')
            ->select('band.name, band.description, band.tributeto, band.jjwgMapsLatC, band.jjwgMapsLngC')
            ->where('band.deleted = 0')
            ->andWhere("band.jjwgMapsLatC != ''")
            ->getQuery()
            ->execute();
    }

    public function getAllBandsWithLookupFields()
    {
        return $this->createQueryBuilder('band')
            ->select("band.id, band.name, band.description, band.tributeto, band.jjwgMapsLatC, band.jjwgMapsLngC, CONCAT(band.billingAddressStreet, ' ', band.billingAddressCity, ' ', band.billingAddressState, ' ', band.billingAddressPostalcode, ' ', band.billingAddressCountry) AS address")
            ->where('band.deleted = 0')
            ->getQuery()
            ->execute();
    }
}