<?php

namespace OJezu\AddCallToRemoteServiceBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Finds services tagged with "ojezu.configurable_discrimination" tag, and builds discriminator maps out of that.
 *
 * Discriminator map is then set in this package config parameters
 */
class AddCallToRemoteServiceCompilerPass implements CompilerPassInterface
{
    /**
     * @inheritdoc
     */
    public function process(ContainerBuilder $container)
    {
        $taggedServices = $container->findTaggedServiceIds('ojezu.add_call_to_remote_service');

        foreach ($taggedServices as $serviceName => $tags) {
            foreach ($tags as $tag) {
                $remoteService = $tag['remote_service'];

                if ($remoteService[0] === '@') {
                    $remoteService = $container->getDefinition(substr($remoteService, 1));
                }

                $arguments = [];
                foreach ($tag as $attributeName => $attributeValue) {
                    $match = [];
                    if (preg_match('/^argument\.(\d+)$/', $attributeName, $match)) {
                        if (is_string($attributeValue)) {
                            if ($attributeValue === '@') {
                                $attributeValue = $container->getDefinition($serviceName);
                            } elseif ($attributeValue[0] === '@') {
                                $attributeValue = $container->getDefinition(substr($attributeValue, 1));
                            }
                        }

                        $arguments[(int) $match[1]] = $attributeValue;
                    }
                }

                $remoteService->addMethodCall(
                    $tag['method'],
                    array_values($arguments)
                );
            }
        }
    }
}
