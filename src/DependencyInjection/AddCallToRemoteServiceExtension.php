<?php

namespace OJezu\AddCallToRemoteServiceBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader;

/**
 * @inheritdoc
 */

class AddCallToRemoteServiceExtension extends Extension
{
    public function load(array $config, ContainerBuilder $container)
    {

    }

    public function getNamespace()
    {
        return 'add_call_to_remote_service';
    }
}
