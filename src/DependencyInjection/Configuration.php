<?php
/**
 * Configuration.php
 *
 * @author dbojdo - Daniel Bojdo <daniel.bojdo@dxi.eu>
 * Created on Jun 01, 2015, 12:00
 * Copyright (C) DXI Ltd
 */

namespace Dxi\DoctrineExtensionBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 * @package Dxi\DoctrineExtensionBundle\DependencyInjection
 */
class Configuration implements ConfigurationInterface
{

    /**
     * Generates the configuration tree builder.
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('dxi_doctrine_extension');

        $treeBuilder->getRootNode()->children()
            ->arrayNode('types')->canBeDisabled()->addDefaultsIfNotSet()
                ->children()
                    ->arrayNode('dbal')->addDefaultsIfNotSet()
                        ->children()
                            ->arrayNode('timestamp')->canBeDisabled()
                                ->children()
                                    ->scalarNode('class')->defaultValue('Dxi\\DoctrineExtension\\DBAL\\TimestampType')->end()
                                    ->scalarNode('name')->defaultValue('timestamp')->end()
                                ->end()
                            ->end()
                            ->arrayNode('enum')->canBeDisabled()
                                ->children()
                                    ->scalarNode('class')->defaultValue('Dxi\\DoctrineExtension\\DBAL\\EnumType')->end()
                                    ->scalarNode('name')->defaultValue('enum')->end()
                                ->end()
                            ->end()
                            ->arrayNode('set')->canBeDisabled()
                                ->children()
                                    ->scalarNode('class')->defaultValue('Dxi\\DoctrineExtension\\DBAL\\SetType')->end()
                                    ->scalarNode('name')->defaultValue('set')->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
            ->arrayNode('enum')->addDefaultsIfNotSet()->canBeEnabled()
                ->children()
                    ->arrayNode('types')
                        ->prototype('scalar')->end()
                    ->end()
                    ->scalarNode('type_class_dir')->defaultValue('%kernel.cache_dir%/dxi/doctrine-types')->end()
                    ->scalarNode('type_class_namespace')->defaultValue('Dxi\\Doctrine\\EnumType\\')->end()
                ->end()
            ->end()
            ->arrayNode('reference')->canBeEnabled()->end()
            ->end();

        return $treeBuilder;
    }
}
