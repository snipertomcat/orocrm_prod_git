<?php

namespace Stc\Core\EventBundle;

use Stc\Core\EventBundle\DependencyInjection\StcCoreEventExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class StcCoreEventBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new StcCoreEventExtension();
    }

}