# Doctrine Fluent Mapping Bundle
[![Latest Stable Version](https://poser.pugx.org/gordinskiy/doctrine-fluent-mapping-bundle/v/stable.svg)](https://packagist.org/packages/gordinskiy/doctrine-fluent-mapping-bundle)
[![Run Tests](https://github.com/gordinskiy/DoctrineFluentMappingBundle/workflows/PHP%20Tests/badge.svg?branch=master)](https://github.com/gordinskiy/DoctrineFluentMappingBundle/actions)
[![codecov](https://codecov.io/github/gordinskiy/DoctrineFluentMappingBundle/branch/tests/codecov/graph/badge.svg?token=OND89Z4T29)](https://codecov.io/github/gordinskiy/DoctrineFluentMappingBundle)
[![License](https://poser.pugx.org/gordinskiy/doctrine-fluent-mapping-bundle/license.svg)](https://packagist.org/packages/gordinskiy/doctrine-fluent-mapping-bundle)


Symfony Bundle for [laravel-doctrine/fluent](https://github.com/laravel-doctrine/fluent)
that provide alternative PHP Mapping Driver for Doctrine ORM.  
Works as extension for [doctrine/DoctrineBundle](https://github.com/doctrine/DoctrineBundle).

## Installation
Run this command in your terminal:  
`composer require gordinskiy/doctrine-fluent-mapping-bundle`

If you don't use Symfony Flex, you must enable the bundle manually in the application:

```php
// config/bundles.php    
return [  
    ...  
    Gordinskiy\DoctrineFluentMappingBundle\DoctrineFluentMappingBundle::class => ['all' => true],  
];
```

## Configuration

Create `config/packages/doctrine_fluent.yaml` file and list your entity mappings in it:
```yml
doctrine_fluent:
    mappings:
        - Infrastructure\Doctrine\Mappings\UserMapping
        - Infrastructure\Doctrine\Mappings\RoleMapping
        - Infrastructure\Doctrine\Mappings\AccountMapping
```

### Configure by directories list
You can also configure mappings by directories list:
```yml
doctrine_fluent:
    mappings_paths:
        - src/Context/Infrastructure/Doctrine/Mappings
        - src/SomeAnotherContext/Infrastructure/Doctrine/Mappings
        - src/ActivityLog/Infrastructure/Doctrine/Mappings
        - src/OneMoreContext/Infrastructure/Doctrine/Mappings
```
You can use absolute paths or paths relative to the project root directory.  
All classes in these directories that implement [Mapping](https://github.com/laravel-doctrine/fluent/blob/1.3/src/Mapping.php) interface will be automatically registered as mappings.
