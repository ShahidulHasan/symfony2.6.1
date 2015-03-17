<?php

namespace Symfony\Bundle\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Bundle\UserBundle\DependencyInjection\Compiler\PermissionCompilerPass;

class SymfonyUserBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new PermissionCompilerPass());
    }

    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
