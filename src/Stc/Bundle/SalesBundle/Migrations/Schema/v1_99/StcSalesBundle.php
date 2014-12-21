<?php


namespace Stc\Bundle\SalesBundle\Migrations\Schema\v1_99;


use Doctrine\DBAL\Schema\Schema;
use Oro\Bundle\EntityExtendBundle\Migration\Extension\ExtendExtension;
use Oro\Bundle\EntityExtendBundle\Migration\Extension\ExtendExtensionAwareInterface;
use Oro\Bundle\MigrationBundle\Migration\Migration;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;
use Oro\Bundle\EntityExtendBundle\EntityConfig\ExtendScope;

class StcSalesBundle implements Migration, ExtendExtensionAwareInterface
{
    protected $extendExtension;

    public function setExtendExtension(ExtendExtension $extendExtension)
    {
        $this->extendExtension = $extendExtension;
    }

    public function up(Schema $schema, QueryBag $queries)
    {
        $schema->dropTable('orocrm_sales_lead');

        $table = $schema->createTable('orocrm_sales_lead');

	/* Fields */
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('updatedAt', 'datetime', ['notnull' => false]);
        $table->addColumn('workflow_item_id', 'integer', ['notnull' => false]);
        $table->addColumn('status_name', 'string', ['notnull' => false, 'length' => 32]);
        $table->addColumn('workflow_step_id', 'integer', ['notnull' => false]);
        $table->addColumn('account_id', 'integer', ['notnull' => false]);
        $table->addColumn('user_owner_id', 'integer', ['notnull' => false]);
        $table->addColumn('contact_id', 'integer', ['notnull' => false]);
        $table->addColumn('address_id', 'integer', ['notnull' => false]);
        $table->addColumn('campaign_id', 'integer', ['notnull' => false]);
        $table->addColumn('sound_check_at', 'datetime', ['notnull' => false]);
        $table->addColumn('name', 'string', ['length' => 255]);
        $table->addColumn('name_prefix', 'string', ['notnull' => false, 'length' => 255]);
        $table->addColumn('first_name', 'string', ['length' => 255]);
        $table->addColumn('middle_name', 'string', ['notnull' => false, 'length' => 255]);
        $table->addColumn('last_name', 'string', ['length' => 255]);
        $table->addColumn('name_suffix', 'string', ['notnull' => false, 'length' => 255]);
        $table->addColumn('job_title', 'string', ['notnull' => false, 'length' => 255]);
        $table->addColumn('phone_number', 'string', ['notnull' => false, 'length' => 255]);
        $table->addColumn('email', 'string', ['notnull' => false, 'length' => 255]);
        $table->addColumn('company_name', 'string', ['notnull' => false, 'length' => 255]);
        $table->addColumn('website', 'string', ['notnull' => false, 'length' => 255]);
        $table->addColumn('number_of_employees', 'integer', ['notnull' => false]);
        $table->addColumn('industry', 'string', ['notnull' => false, 'length' => 255]);
        $table->addColumn('createdAt', 'datetime', []);
        $table->addColumn('notes', 'text', ['notnull' => false]);
        $table->addColumn('per_diem', 'string', ['notnull' => false, 'length' => 255]);
        $table->addColumn('travel_details', 'text', ['notnull' => false]);
        $table->addColumn('backline', 'text', ['notnull' => false]);
        $table->addColumn('deposit', 'money', ['notnull' => false, 'precision' => 19, 'scale' => 4, 'comment' => '(DC2Type:money)']);
        $table->addColumn('reminder', 'datetime', ['notnull' => false]);
        $table->addColumn('default_bands_id', 'integer', ['notnull' => false]);
        $table->addColumn('attachment_id', 'integer', ['notnull' => false]);
        $table->addColumn('desired_start_date', 'date', ['notnull' => false]);
        $table->addColumn('desired_end_date', 'date', ['notnull' => false]);
        $table->addColumn('load_in_at', 'datetime', ['notnull' => false]);
        $table->addColumn('total_compensation', 'money', ['notnull' => false, 'precision' => 19, 'scale' => 4, 'comment' => '(DC2Type:money)']);
        $table->addColumn('budget_meals', 'money', ['notnull' => false, 'precision' => 19, 'scale' => 4, 'comment' => '(DC2Type:money)']);
        $table->addColumn('budget_hotels', 'money', ['notnull' => false, 'precision' => 19, 'scale' => 4, 'comment' => '(DC2Type:money)']);
        $table->addColumn('budget_travel', 'money', ['notnull' => false, 'precision' => 19, 'scale' => 4, 'comment' => '(DC2Type:money)']);
        $table->addColumn('budget_total', 'money', ['notnull' => false, 'precision' => 19, 'scale' => 4, 'comment' => '(DC2Type:money)']);
		$table->addColumn('ground_transportation', 'text', ['notnull' => false]);
        $table->setPrimaryKey(['id']);
        $table->addUniqueIndex(['workflow_item_id'], 'UNIQ_73DB46331023C4EE');
        $table->addIndex(['status_name'], 'IDX_73DB46336625D392', []);
        $table->addIndex(['contact_id'], 'IDX_73DB4633E7A1254A', []);
        $table->addIndex(['account_id'], 'IDX_73DB46339B6B5FBA', []);
        $table->addIndex(['address_id'], 'IDX_73DB4633F5B7AF75', []);
        $table->addIndex(['user_owner_id'], 'IDX_73DB46339EB185F9', []);
        $table->addIndex(['workflow_step_id'], 'IDX_73DB463371FE882C', []);
        $table->addIndex(['campaign_id'], 'IDX_73DB4633F639F774', []);
        $table->addIndex(['createdAt'], 'lead_created_idx', []);

        /* Foreign Keys */

        $table->addForeignKeyConstraint(
            $schema->getTable('oro_workflow_item'),
            ['workflow_item_id'],
            ['id'],
            ['onDelete' => 'SET NULL', 'onUpdate' => null]
        );
        $table->addForeignKeyConstraint(
            $schema->getTable('orocrm_sales_lead_status'),
            ['status_name'],
            ['name'],
            ['onDelete' => null, 'onUpdate' => null]
        );
        $table->addForeignKeyConstraint(
            $schema->getTable('oro_workflow_step'),
            ['workflow_step_id'],
            ['id'],
            ['onDelete' => 'SET NULL', 'onUpdate' => null]
        );
        $table->addForeignKeyConstraint(
            $schema->getTable('orocrm_account'),
            ['account_id'],
            ['id'],
            ['onDelete' => 'SET NULL', 'onUpdate' => null]
        );
        $table->addForeignKeyConstraint(
            $schema->getTable('oro_user'),
            ['user_owner_id'],
            ['id'],
            ['onDelete' => 'SET NULL', 'onUpdate' => null]
        );
        $table->addForeignKeyConstraint(
            $schema->getTable('orocrm_contact'),
            ['contact_id'],
            ['id'],
            ['onDelete' => 'SET NULL', 'onUpdate' => null]
        );
        $table->addForeignKeyConstraint(
            $schema->getTable('oro_address'),
            ['address_id'],
            ['id'],
            ['onDelete' => 'SET NULL', 'onUpdate' => null]
        );
        $table->addForeignKeyConstraint(
            $schema->getTable('orocrm_campaign'),
            ['campaign_id'],
            ['id'],
            ['onDelete' => 'SET NULL', 'onUpdate' => null]
        );

        /* Relationships */

        $this->extendExtension->addManyToOneRelation(
            $schema,
            $table,
            'bands',
            'stc_bands',
            'name',
            ['extend' => ['without_default' => true, 'is_extend' => true, 'owner' => ExtendScope::OWNER_CUSTOM]]
        );

        $this->extendExtension->addManyToOneRelation(
            $schema,
            $table,
            'venue',
            'stc_venues',
            'name',
            [
                'extend' => [
                    'is_extend' => true, 'owner' => ExtendScope::OWNER_CUSTOM
                ]
            ]
        );

        //$table = $schema->getTable('orocrm_sales_lead');

        //$extTable = $table;
        /*
        $extTable->addColumn(
            'venue',
            'string',
            [
                'oro_options' => [
                    'extend' => ['is_extend' => true, 'owner' => ExtendScope::OWNER_CUSTOM],
                    'datagrid' => ['is_visible' => true],
                    'merge' => ['display' => true],
                ]
            ]
        );

        //$extTable->addUniqueIndex(['StcVenueBundle:Venue']);

        $extTable->addColumn(
            'desiredStartAt',
            'datetime',
            [
                'oro_options' => [
                    'extend' => ['is_extend' => true, 'owner' => ExtendScope::OWNER_CUSTOM],
                    'datagrid' => ['is_visible' => true],
                    'merge' => ['display' => true],
                ]
            ]
        );

        $extTable->addColumn(
            'desiredEndAt',
            'datetime',
            [
                'oro_options' => ['is_extend' => true, 'owner' => ExtendScope::OWNER_CUSTOM],
                'datagrid' => ['is_visible' => true],
                'merge' => ['display' => true]
            ]
        );

        $extTable->addColumn(
            'soundCheckAt',
            'datetime',
            [
                'oro_options' => ['is_extend' => true, 'owner' => ExtendScope::OWNER_CUSTOM],
                'datagrid' => ['is_visible' => true],
                'merge' => ['display' => true]
            ]
        );

        $extTable->addColumn(
            'loadInAt',
            'datetime',
            [
                'oro_options' => ['is_extend' => true, 'owner' => ExtendScope::OWNER_CUSTOM],
                'datagrid' => ['is_visible' => true],
                'merge' => ['display' => true]
            ]
        );

        $extTable->addColumn(
            'budgetTotal',
            'currency',
            [
                'oro_options' => ['is_extend' => true, 'owner' => ExtendScope::OWNER_CUSTOM],
                'datagrid' => ['is_visible' => true],
                'merge' => ['display' => true]
            ]
        );

        $extTable->addColumn(
            'budgetMeals',
            'currency',
            [
                'oro_options' => ['is_extend' => true, 'owner' => ExtendScope::OWNER_CUSTOM],
                'datagrid' => ['is_visible' => true],
                'merge' => ['display' => true]
            ]
        );

        $extTable->addColumn(
            'budgetHotels',
            'currency',
            [
                'oro_options' => ['is_extend' => true, 'owner' => ExtendScope::OWNER_CUSTOM],
                'datagrid' => ['is_visible' => true],
                'merge' => ['display' => true]
            ]
        );

        $extTable->addColumn(
            'travelDetails',
            'text',
            [
                'oro_options' => ['is_extend' => true, 'owner' => ExtendScope::OWNER_CUSTOM],
                'datagrid' => ['is_visible' => true],
                'merge' => ['display' => true]
            ]
        );

        $extTable->addColumn(
            'backline',
            'text',
            [
                'oro_options' => ['is_extend' => true, 'owner' => ExtendScope::OWNER_CUSTOM],
                'datagrid' => ['is_visible' => true],
                'merge' => ['display' => true]
            ]
        );

        $extTable->addColumn(
            'groundTransportation',
            'text',
            [
                'oro_options' => ['is_extend' => true, 'owner' => ExtendScope::OWNER_CUSTOM],
                'datagrid' => ['is_visible' => true],
                'merge' => ['display' => true]
            ]
        );

        $extTable->addColumn(
            'perDiem',
            'string',
            [
                'oro_options' => ['is_extend' => true, 'owner' => ExtendScope::OWNER_CUSTOM],
                'datagrid' => ['is_visible' => true],
                'merge' => ['display' => true]
            ]
        );

        $extTable->addColumn(
            'deposit',
            'currency',
            [
                'oro_options' => ['is_extend' => true, 'owner' => ExtendScope::OWNER_CUSTOM],
                'datagrid' => ['is_visible' => true],
                'merge' => ['display' => true]
            ]
        );

        $this->extendExtension->addManyToOneRelation(
            $schema,
            'bands',
            'Bands',
            $extTable,
            'bands',
            ['extend' => ['without_default' => true, 'is_extend' => true, 'owner' => ExtendScope::OWNER_CUSTOM]]
        );
        */
    }
}
