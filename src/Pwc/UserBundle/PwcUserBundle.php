<?php

namespace Pwc\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class PwcUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
