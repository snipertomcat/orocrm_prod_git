<?php

namespace Stc\Bundle\ContactBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class StcContactBundle extends Bundle
{
    public function getParent()
    {
        return 'OroCRMContactBundle';
    }
}
