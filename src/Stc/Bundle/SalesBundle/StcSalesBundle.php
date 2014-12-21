<?php

namespace Stc\Bundle\SalesBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class StcSalesBundle extends Bundle
{
    public function getParent()
    {
        return 'OroCRMSalesBundle';
    }
}