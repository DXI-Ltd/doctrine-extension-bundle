<?php
/**
 * RegisterEnumTypePass.php
 *
 * @author dbojdo - Daniel Bojdo <daniel.bojdo@dxi.eu>
 * Created on Jun 04, 2015, 14:56
 * Copyright (C) DXI Ltd
 */

namespace Dxi\DoctrineExtensionBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class RegisterEnumTypePass
 * @package Dxi\DoctrineExtensionBundle\DependencyInjection\Compiler
 */
class RegisterEnumTypePass implements CompilerPassInterface
{
    /**
     * @var array
     */
    private $enumMap;

    /**
     * @param array $enumMap
     */
    public function __construct(array $enumMap)
    {
        $this->enumMap = $enumMap;
    }

    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     *
     * @api
     */
    public function process(ContainerBuilder $container)
    {
        $registrars = $container->getParameter('dxi_doctrine_extension.enum.registrars');
        foreach ($registrars as $registrar) {
            if ($container->findDefinition($registrar)) {
                $registrar = $container->get($registrar);
                foreach ($this->enumMap as $type => $class) {
                    $registrar->registerType($type, $class);
                }
            }
        }

        $types = $container->getParameter('dxi_doctrine_extension.enum.types');
        $types = array_replace($types, $this->enumMap);
        $container->setParameter('dxi_doctrine_extension.enum.types', $types);
    }
}
