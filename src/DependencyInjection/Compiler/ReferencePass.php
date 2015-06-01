<?php
/**
 * ReferencePass.php
 *
 * @author dbojdo - Daniel Bojdo <daniel.bojdo@dxi.eu>
 * Created on Jun 01, 2015, 16:28
 * Copyright (C) DXI Ltd
 */

namespace Dxi\DoctrineExtensionBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class ReferencePass
 * @package Dxi\DoctrineExtensionBundle\DependencyInjection\Compiler
 */
class ReferencePass implements CompilerPassInterface
{
    const REFERENCE_LISTENER_ID = 'dxi_doctrine_extension.reference.listener';
    private static $registries = array(
        'orm' => 'doctrine',
        'odm' => 'doctrine_mongodb'
    );

    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     *
     * @api
     */
    public function process(ContainerBuilder $container)
    {
        if (! $container->hasDefinition(self::REFERENCE_LISTENER_ID)) {
            return;
        }

        $referenceListener = $container->getDefinition(self::REFERENCE_LISTENER_ID);
        foreach (self::$registries as $type => $serviceId) {
            if ($container->hasDefinition($serviceId)) {
                $referenceListener->addMethodCall('setRegistry', array($type, new Reference($serviceId)));
            }
        }
    }
}
