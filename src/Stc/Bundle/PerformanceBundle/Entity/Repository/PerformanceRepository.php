<?php

namespace Stc\Bundle\PerformanceBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

use Stc\Bundle\PerformanceBundle\Entity\Performance;
use Doctrine\ORM\Query\ResultSetMapping;

class PerformanceRepository extends EntityRepository
{
    public function getLatestHeadlines()
    {
        $all = $this->findAll();

        return $all;

/*        $sql = "SELECT performance.name, performance.venue_id, venue.name
                FROM StcPerformanceBundle:Performance performance
                LEFT JOIN StcVenueBundle:Venue venue ON performance.venue_id = venue.id
                WHERE 1
        ";

        $dbal = $this->findAll();

        foreach ($dbal as $row) {
            $id = $row->getId();
            $bands = $row->getBands();

            $sql = "SELECT b FROM StcPerformanceBundle:Performance p INNER JOIN StcBandBundle:Band b ON p.bands = b.id";
            $query = $this->getEntityManager()->createQuery($sql);
            echo "<pre>";print_r($query->getResult());exit;
        }

        return $dbal;*/
    }
}