<?php

namespace OJezu\AddCallToRemoteServiceBundle;

use OJezu\AddCallToRemoteServiceBundle\DependencyInjection\Compiler\AddCallToRemoteServiceCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * @inheritdoc
 */

class AddCallToRemoteServiceBundle extends Bundle
{
    /**
     * @inheritdoc
     */
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new AddCallToRemoteServiceCompilerPass());
    }
}
