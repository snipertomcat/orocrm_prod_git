<?php

namespace Stc\Bundle\PerformanceBundle\Migrations\Schema\v1_0;

use Doctrine\DBAL\Schema\Schema;

use Oro\Bundle\MigrationBundle\Migration\Migration;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;

use Oro\Bundle\ActivityBundle\Migration\Extension\ActivityExtension;
use Oro\Bundle\ActivityBundle\Migration\Extension\ActivityExtensionAwareInterface;

class StcPerformanceBundle implements Migration, ActivityExtensionAwareInterface
{
    protected $activityExtension;


    public function up(Schema $schema, QueryBag $queries)
    {

    }

    public function setActivityExtension(ActivityExtension $activityExtension)
    {
        //$this->activityExtension = $activityExtension;
    }
/*


    public function setActivityExtension(ActivityExtension $activityExtension)
    {
        $this->activityExtension = $activityExtension;
    }

    public function up(Schema $schema, QueryBag $queries)
    {
        self::addActivityAssociations($schema, $this->activityExtension);
    }

    public static function addActivityAssociations(Schema $schema, ActivityExtension $activityExtension)
    {
        $activityExtension->addActivityAssociation($schema, "oro_email", "stc_performances", true);
        $activityExtension->addActivityAssociation($schema, "oro_reminder", "stc_performances", true);
    }
*/
}