# DXI Doctrine Extension Bundle

Doctrine 2 extensions Symfony 2 integration

## Installation

Add the **dxi/doctrine-extension-bundle** into **composer.json**

```json
{
    "require": {
        "php":              ">=5.3.2",
        "dxi/doctrine-extension-bundle": "~1.0"
    }
}
```

Register the Bundle in the AppKernel

```php
// in AppKernel::registerBundles()
$bundles = array(
    // ...
    new Dxi\DoctrineExtensionBundle\DxiDoctrineExtensionBundle(),
    // ...
);
```

## Enum Extension - Configuration

Enabling Enum Extension

```yaml
# app/config/config.yml

dxi_doctrine_extension:
    enum:
        types:
            dxi.my_type: MyEnum #register your enum types here
```

It generates ODM / DBAL Types for "MyEnum" class and registers them.

See Enum extension documentation:
[https://github.com/DXI-Ltd/doctrine-extension](https://github.com/DXI-Ltd/doctrine-extension "Dxi/Enum")

## Reference Extension

Enabling Reference Extension

```yaml
# app/config/config.yml

dxi_doctrine_extension:
    reference: true

```

See Reference extension documentation:
[https://github.com/DXI-Ltd/doctrine-extension](https://github.com/DXI-Ltd/doctrine-extension "Dxi/References")
[https://github.com/Atlantic18/DoctrineExtensions/blob/master/doc/references.md](https://github.com/Atlantic18/DoctrineExtensions/blob/master/doc/references.md "Gedmo/References extension")
