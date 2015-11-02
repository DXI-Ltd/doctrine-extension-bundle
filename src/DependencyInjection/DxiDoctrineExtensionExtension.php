<?php
/**
 * DxiDoctrineExtensionExtension.php
 *
 * @author dbojdo - Daniel Bojdo <daniel.bojdo@dxi.eu>
 * Created on Jun 01, 2015, 12:06
 * Copyright (C) DXI Ltd
 */

namespace Dxi\DoctrineExtensionBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * Class DxiDoctrineExtensionExtension
 * @package Dxi\DoctrineExtensionBundle\DependencyInjection
 */
class DxiDoctrineExtensionExtension extends Extension
{

    /**
     * Loads a specific configuration.
     *
     * @param array $configs An array of configuration values
     * @param ContainerBuilder $container A ContainerBuilder instance
     *
     * @throws \InvalidArgumentException When provided tag is not defined in this extension
     *
     * @api
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $config = $this->processConfiguration(new Configuration(), $configs);
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        if ($config['types']['enabled']) {
            $this->loadDbalTypes($container, $loader, $config['types']['dbal']);
        }

        if ($config['enum']) {
            $this->loadEnum($container, $loader, $config['enum']);
        }

        if ($config['reference']) {
            $this->loadReference($container, $loader, $config['reference']);
        }
    }

    /**
     * @param ContainerBuilder $container
     * @param XmlFileLoader $loader
     * @param array $enumConfig
     */
    private function loadEnum(ContainerBuilder $container, XmlFileLoader $loader, array $enumConfig)
    {
        $container->setParameter('dxi_doctrine_extension.enum.enabled', $enumConfig['enabled']);
        if (! $enumConfig['enabled']) {
            return;
        }

        $registrars = array();

        // DBAL Support
        if (class_exists('Doctrine\DBAL\Types\Type', true)) {
            $loader->load('enum.dbal.xml');
            $registrars[] = 'dxi_doctrine_extension.enum.dbal_registrar';

            $generator = $container->getDefinition('dxi_doctrine_extension.enum.dbal_type_generator');
            $generator->addArgument($enumConfig['type_class_dir'] . '/dbal');

            $namespace = rtrim($enumConfig['type_class_namespace'], '\\') . '\\DBAL';
            $generator->addArgument($namespace);
        }

        if (class_exists('Doctrine\ODM\MongoDB\Types\Type', true)) {
            $loader->load('enum.odm.xml');
            $registrars[] = 'dxi_doctrine_extension.enum.odm_registrar';

            $generator = $container->getDefinition('dxi_doctrine_extension.enum.odm_type_generator');
            $generator->addArgument($enumConfig['type_class_dir'] . '/odm');

            $namespace = rtrim($enumConfig['type_class_namespace'], '\\') . '\\ODM';
            $generator->addArgument($namespace);
        }

        $container->setParameter('dxi_doctrine_extension.enum.registrars', $registrars);
        $container->setParameter('dxi_doctrine_extension.enum.types', $enumConfig['types']);
    }

    private function loadReference(ContainerBuilder $container, XmlFileLoader $loader, array $referenceConfig)
    {
        if (! $referenceConfig['enabled']) {
            return;
        }

        $loader->load('reference.xml');
    }

    private function loadDbalTypes(ContainerBuilder $container, XmlFileLoader $loader, array $dbalConfig)
    {
        if (class_exists('Doctrine\DBAL\Types\Type', true)) {
            $loader->load('dbal-types.xml');


            $typesMap = array();
            foreach ($dbalConfig as $type => $typeConfig) {
                if (! $typeConfig['enabled']) {
                    continue;
                }

                $typesMap[$typeConfig['class']] = $typeConfig['name'];
            }

            if ($typesMap) {
                $registrar = $container->getDefinition('dxi_doctrine_extension.dbal_types.registrar');
                $registrar->replaceArgument(0, $typesMap);
            }
        }
    }
}
