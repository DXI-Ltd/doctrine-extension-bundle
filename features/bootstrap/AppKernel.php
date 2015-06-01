<?php
/**
 * AppKernel.php
 *
 * @author dbojdo - Daniel Bojdo <daniel.bojdo@dxi.eu>
 * Created on Jun 01, 2015, 11:40
 * Copyright (C) DXI Ltd
 */

use Webit\Tests\Behaviour\Bundle\Kernel as BaseKernel;

/**
 * Class AppKernel
 */
class AppKernel extends BaseKernel
{

    /**
     * Returns an array of bundles to register.
     *
     * @return \Symfony\Component\HttpKernel\Bundle\BundleInterface[] An array of bundle instances.
     *
     * @api
     */
    public function registerBundles()
    {
        return array(
            new \Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new \Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new \Doctrine\Bundle\MongoDBBundle\DoctrineMongoDBBundle(),
            new \Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),
            new \Dxi\DoctrineExtensionBundle\DxiDoctrineExtensionBundle()
        );
    }
}
