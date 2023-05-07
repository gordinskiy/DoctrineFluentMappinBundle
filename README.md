# Doctrine Fluent Mapping Bundle
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

Create `config/packages/doctrine_fluent.yaml` file and list your entity mappers in it:
```yml
doctrine_fluent:  
    mappers:  
        list:
            - Infrastructure\Doctrine\Mappers\UserMapper
            - Infrastructure\Doctrine\Mappers\RoleMapper
            - Infrastructure\Doctrine\Mappers\AccountMapper`
```

### Configure by directories list
You can also configure mappers by directories list:
```yml
doctrine_fluent:
    mappers:
        auto_locator:
            directories:
                - 'src/Context/Infrastructure/Doctrine/Mapping'
                - 'src/SomeAnotherContext/Infrastructure/Doctrine/Mapping'
                - 'src/ActivityLog/Infrastructure/Doctrine/Mapping'
                - 'src/OneMoreContext/Infrastructure/Doctrine/Mapping'
```
You can use absolute paths or paths relative to the project root directory.  
All classes in these directories that implement [Mapping](https://github.com/laravel-doctrine/fluent/blob/1.3/src/Mapping.php) interface will be automatically registered as mappers.
