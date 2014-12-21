<?php

namespace Stc\Bundle\ContractBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;

use Stc\Bundle\ContractBundle\Entity\ContractStatus;
use Symfony\Component\Config\Definition\Exception\Exception;

class ContractRepository extends EntityRepository
{
    /**
     * @return integer
     */
    public function getContractCountByStage()
    {

    }

    public function insertAssociatedPerformance($contract_id, $performance_id)
    {
        if ($contract_id === null) {
            throw new Exception("Missing contract_id param");
        } elseif ($performance_id === null) {
            throw new Exception("Missing performance_id param");
        }
            $rsm = new ResultSetMapping();
            $sql = "INSERT INTO stc_contract_to_performance VALUES($performance_id, $contract_id)";
            $this->getEntityManager()->createNativeQuery($sql,$rsm);
    }
}