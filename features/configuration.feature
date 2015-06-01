Feature: DoctrineExtensionBundle configuration feature
  In order to set up MyBrandNew library with Symfony Application
  As a developer
  I need Bundle Configuration / Extension

  Background:
    Given the configuration contains:
    """
    framework:
        secret: "my-secret-hash"

    doctrine_mongodb:
        connections:
            default:
                server: mongodb://localhost:27017
        document_managers:
            default: ~
    """

  Scenario: Basic configuration
    Given the configuration contains:
    """
    dxi_doctrine_extension: ~
    """
    When I bootstrap the application
    Then there should not be following services defined:
    """
    dxi_doctrine_extension.enum.dbal_registrar, dxi_doctrine_extension.enum.odm_registrar,
    dxi_doctrine_extension.reference.listener
    """
    And all given services should be reachable

  Scenario: Enum Only
    Given the configuration contains:
    """
    doctrine:
        dbal:
            connections:
                default:
                    driver: pdo_sqlite
                    path: %kernel.cache_dir%/db.sqlite

    dxi_doctrine_extension:
        enum:
            types:
                dxi.my_type: MyEnum
        reference: false
    """
    When I bootstrap the application
    Then there should be following services defined:
    """
    dxi_doctrine_extension.enum.dbal_registrar, dxi_doctrine_extension.enum.odm_registrar
    """
    And the Doctrine type "dxi.my_type" should be registered
    But there should not be following services defined:
    """
    dxi_doctrine_extension.reference.listener
    """
    And all given services should be reachable

  Scenario: Reference Only
    Given the configuration contains:
    """
    dxi_doctrine_extension:
        enum: false
        reference: true
    """
    When I bootstrap the application
    Then there should be following services defined:
    """
    dxi_doctrine_extension.reference.listener
    """
    But there should not be following services defined:
    """
    dxi_doctrine_extension.enum.dbal_registrar, dxi_doctrine_extension.enum.odm_registrar
    """
    And all given services should be reachable