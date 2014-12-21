<?php

namespace Stc\Bundle\PerformanceBundle\Migrations\Schema\v1_2;

use Doctrine\DBAL\Schema\Schema;

use Oro\Bundle\MigrationBundle\Migration\Migration;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;

use Oro\Bundle\ActivityBundle\Migration\Extension\ActivityExtension;
use Oro\Bundle\ActivityBundle\Migration\Extension\ActivityExtensionAwareInterface;
use Oro\Bundle\EntityExtendBundle\Migration\Extension\ExtendExtensionAwareInterface;
use Oro\Bundle\EntityExtendBundle\EntityConfig\ExtendScope;
use Oro\Bundle\EntityExtendBundle\Migration\Extension\ExtendExtension;
use OroCRM\Bundle\SalesBundle\Entity\Lead;

class StcPerformanceBundle implements Migration, ExtendExtensionAwareInterface
{
    protected $extendExtension;

    public function setExtendExtension(ExtendExtension $extendExtension)
    {
        $this->extendExtension = $extendExtension;
    }


    public function up(Schema $schema, QueryBag $queries)
    {
        $table = $schema->getTable('stc_performances');

        $leadTable = $schema->getTable('orocrm_sales_lead');

        //$table->dropColumn('lead');

        /*$table->addColumn('leads', 'object', [
            'extend' => ['is_extend' => true, 'owner' => ExtendScope::OWNER_CUSTOM],
            'datagrid' => ['is_visible' => true],
            'merge' => ['display' => true],
        ]);

        $this->extendExtension->addManyToOneRelation(
            $schema,
            'orocrm_sales_lead',
            'Leads',
            $table,
            'leads',
            ['extend' => ['without_default' => true, 'is_extend' => true, 'owner' => ExtendScope::OWNER_CUSTOM]]
        );*/

    }
}