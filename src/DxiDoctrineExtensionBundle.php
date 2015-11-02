<?php
/**
 * DxiDoctrineExtensionBundle.php
 *
 * @author dbojdo - Daniel Bojdo <daniel.bojdo@dxi.eu>
 * Created on Jun 01, 2015, 11:25
 * Copyright (C) DXI Ltd
 */

namespace Dxi\DoctrineExtensionBundle;

use Dxi\DoctrineExtension\Enum\Common\AbstractTypeRegistrar;
use Dxi\DoctrineExtensionBundle\DependencyInjection\Compiler\ReferencePass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class DxiDoctrineExtensionBundle
 * @package Dxi\DoctrineExtensionBundle
 */
class DxiDoctrineExtensionBundle extends Bundle
{
    /**
     * Builds the bundle.
     *
     * It is only ever called once when the cache is empty.
     *
     * This method can be overridden to register compilation passes,
     * other extensions, ...
     *
     * @param ContainerBuilder $container A ContainerBuilder instance
     */
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new ReferencePass());
    }

    public function boot()
    {
        if ($this->container->has('dxi_doctrine_extension.dbal_types.registrar')) {
            $this->container->get('dxi_doctrine_extension.dbal_types.registrar')->register();
        }

        if (true == $this->container->getParameter('dxi_doctrine_extension.enum.enabled')) {
            $registrars = $this->container->getParameter('dxi_doctrine_extension.enum.registrars');
            $types = $this->container->getParameter('dxi_doctrine_extension.enum.types');
            foreach ($registrars as $registrarName) {
                if (! $this->container->has($registrarName)) {
                    throw new \InvalidArgumentException(sprintf('Can not find EnumType registrar with name "%s".', $registrarName));
                }

                /** @var AbstractTypeRegistrar $registrar */
                $registrar = $this->container->get($registrarName);
                $this->registerTypes($registrar, $types);
            }
        }
    }

    /**
     * @param AbstractTypeRegistrar $registrar
     * @param array $types
     */
    private function registerTypes(AbstractTypeRegistrar $registrar, array $types)
    {
        foreach ($types as $typeName => $enumClass) {
            $registrar->registerType($typeName, $enumClass);
        }
    }
}
