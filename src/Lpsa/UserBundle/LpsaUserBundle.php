<?php

namespace Lpsa\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class LpsaUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
