<?php

namespace Stc\Bundle\PerformanceTwoBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

use Stc\Bundle\PerformanceTwoBundle\Entity\PerformanceTwo;

class PerformanceTwoRepository extends EntityRepository
{
    public function getAllPerformanceTwosWithCoordinates()
    {
        return $this->createQueryBuilder('performancetwo')
            ->select('performancetwo.name, performancetwo.description, performancetwo.performancetwoType, performancetwo.website, performancetwo.capacity, performancetwo.jjwgMapsLatC, performancetwo.jjwgMapsLngC')
            ->where('performancetwo.deleted = 0')
            ->andWhere("performancetwo.jjwgMapsLatC != ''")
            ->getQuery()
            ->execute();
    }

    public function getAllPerformanceTwosWithLookupFields()
    {
        return $this->createQueryBuilder('performancetwo')
            ->select("performancetwo.id, performancetwo.name, performancetwo.description, performancetwo.performancetwoType, performancetwo.website, performancetwo.capacity, performancetwo.jjwgMapsLatC, performancetwo.jjwgMapsLngC, CONCAT(performancetwo.billingAddressStreet, ' ', performancetwo.billingAddressCity, ' ', performancetwo.billingAddressState, ' ', performancetwo.billingAddressPostalcode, ' ', performancetwo.billingAddressCountry) AS address")
            ->where('performancetwo.deleted = 0')
            ->getQuery()
            ->execute();
    }
}