<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Webit\Tests\Behaviour\Bundle\BundleConfigurationContext;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends BundleConfigurationContext implements Context, SnippetAcceptingContext
{
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
        parent::__construct(new AppKernel());
    }

    /**
     * @Then the Doctrine type :typeName should be registered
     * @param string $typeName
     * @throws \Doctrine\DBAL\DBALException
     */
    public function theDoctrineTypeShouldBeRegistered($typeName)
    {
        if ($this->kernel->getContainer()->has('doctrine_mongodb')) {
            PHPUnit_Framework_Assert::assertTrue(\Doctrine\ODM\MongoDB\Types\Type::hasType($typeName));
            PHPUnit_Framework_Assert::assertInstanceOf('\Doctrine\ODM\MongoDB\Types\Type', \Doctrine\ODM\MongoDB\Types\Type::getType($typeName));
        }

        if ($this->kernel->getContainer()->has('doctrine')) {
            PHPUnit_Framework_Assert::assertTrue(\Doctrine\DBAL\Types\Type::hasType($typeName));
            PHPUnit_Framework_Assert::assertInstanceOf('\Doctrine\DBAL\Types\Type', \Doctrine\DBAL\Types\Type::getType($typeName));
        }
    }
}
