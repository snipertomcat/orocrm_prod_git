<?php

namespace Stc\Bundle\GoogleMapBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;

use Symfony\Component\Config\Definition\Exception\Exception;
use Stc\Bundle\GoogleMapBundle\Entity\Coordinate;

class CoordinateRepository extends EntityRepository
{
    /**
     * @return integer
     */
    public function getAllCoordinates($map)
    {

    }

}