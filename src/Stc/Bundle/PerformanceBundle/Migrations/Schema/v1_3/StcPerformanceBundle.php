<?php

namespace Stc\Bundle\PerformanceBundle\Migrations\Schema\v1_3;

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
        if ($schema->hasTable('stc_performances')) {
            $schema->dropTable('stc_performances');
        }

        $table = $schema->createTable('stc_performances');

        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('venue_id', 'integer', ['notnull' => false]);
        $table->addColumn('assignee_id', 'integer', ['notnull' => false]);
        $table->addColumn('owner_id', 'integer', ['notnull' => false]);
        $table->addColumn('name', 'string', ['length' => 255]);
        $table->addColumn('createdAt', 'datetime', []);
        $table->addColumn('updatedAt', 'datetime', ['notnull' => false]);
        $table->addColumn('description', 'text', ['notnull' => false]);
        $table->addColumn('deleted', 'boolean', []);
        $table->addColumn('profileType', 'string', ['notnull' => false, 'length' => 50]);
        $table->addColumn('website', 'string', ['notnull' => false, 'length' => 255]);
        $table->addColumn('performanceType', 'string', ['notnull' => false, 'length' => 50]);
        $table->addColumn('status', 'string', ['notnull' => false, 'length' => 25]);
        $table->addColumn('leadSource', 'string', ['notnull' => false, 'length' => 100]);
        $table->addColumn('amount', 'float', ['notnull' => false]);
        $table->addColumn('closedAt', 'datetime', ['notnull' => false]);
        $table->addColumn('nextStep', 'string', ['notnull' => false, 'length' => 100]);
        $table->addColumn('salesStage', 'string', ['notnull' => false, 'length' => 100]);
        $table->addColumn('probability', 'float', ['notnull' => false]);
        $table->addColumn('performanceDate', 'datetime', ['notnull' => false]);
        $table->addColumn('performanceLength', 'string', ['notnull' => false, 'length' => 100]);
        $table->addColumn('loadInAt', 'string', ['notnull' => false, 'length' => 100]);
        $table->addColumn('performanceEndAt', 'string', ['notnull' => false, 'length' => 100]);
        $table->addColumn('mealsIncluded', 'boolean', ['notnull' => false]);
        $table->addColumn('performanceFee', 'float', ['notnull' => false]);
        $table->addColumn('budget', 'float', ['notnull' => false]);
        $table->addColumn('flightBudget', 'float', ['notnull' => false]);
        $table->addColumn('rentalCarBudget', 'float', ['notnull' => false]);
        $table->addColumn('hotelBudget', 'float', ['notnull' => false]);
        $table->addColumn('estimatedAttendance', 'string', ['notnull' => false, 'length' => 100]);
        $table->addColumn('actualAttendance', 'string', ['notnull' => false, 'length' => 100]);
        $table->addColumn('postShowComments', 'text', ['notnull' => false]);
        $table->addColumn('travelComments', 'text', ['notnull' => false]);
        $table->addColumn('soundCheckAt', 'string', ['notnull' => false, 'length' => 100]);
        $table->addColumn('performanceHostStatus', 'string', ['notnull' => false, 'length' => 100]);
        $table->addColumn('default_lead_id', 'integer', ['notnull' => false]);
        $table->addColumn(
            'mealBudget',
            'money',
            [
                'oro_options' => [
                    'extend' => ['is_extend' => true, 'owner' => ExtendScope::OWNER_CUSTOM],
                    'datagrid' => ['is_visible' => true],
                    'merge' => ['display' => true],
                ]
            ]
        );
        $table->addColumn(
            'perDiem',
            'text',
            [
                'oro_options' => [
                    'extend' => ['is_extend' => true, 'owner' => ExtendScope::OWNER_CUSTOM],
                    'datagrid' => ['is_visible' => true],
                    'merge' => ['display' => true],
                ]
            ]
        );
        $table->addColumn(
            'deposit',
            'money',
            [
                'oro_options' => [
                    'extend' => ['is_extend' => true, 'owner' => ExtendScope::OWNER_CUSTOM],
                    'datagrid' => ['is_visible' => true],
                    'merge' => ['display' => true],
                ]
            ]
        );
        $this->extendExtension->addManyToOneRelation(
            $schema,
            $table,
            'leads',
            'orocrm_sales_lead',
            'name',
            [
                'extend' => ['is_extend' => true, 'owner' => ExtendScope::OWNER_CUSTOM]
            ]
        );
        $table->setPrimaryKey(['id']);
        $table->addUniqueIndex(['default_lead_id'], 'UNIQ_B295D683F2D014C8');
        $table->addIndex(['venue_id'], 'IDX_B295D68340A73EBA', []);
        /*$table->addIndex(['assignee_id'], 'IDX_B295D68359EC7D60', []);*/
        $table->addIndex(['owner_id'], 'IDX_B295D6837E3C61F9', []);
        $table->addIndex(['name'], 'stc_performances_name_idx', []);

        $table->addForeignKeyConstraint(
            $schema->getTable('stc_performances'),
            ['Leads_id'],
            ['id'],
            ['onDelete' => 'SET NULL', 'onUpdate' => null]
        );

        $table->addForeignKeyConstraint(
            $schema->getTable('stc_venues'),
            ['venue_id'],
            ['id'],
            ['onDelete' => null, 'onUpdate' => null]
        );
        /*$table->addForeignKeyConstraint(
            $schema->getTable('oro_user'),
            ['assignee_id'],
            ['id'],
            ['onDelete' => 'SET NULL', 'onUpdate' => null]
        );*/
        $table->addForeignKeyConstraint(
            $schema->getTable('oro_user'),
            ['owner_id'],
            ['id'],
            ['onDelete' => 'SET NULL', 'onUpdate' => null]
        );
        /*$table->addForeignKeyConstraint(
            $schema->getTable('orocrm_sales_lead'),
            ['default_lead_id'],
            ['id'],
            ['onDelete' => 'SET NULL', 'onUpdate' => null]
        );*/

    }
}