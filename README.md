# Doctrine Fluent Mapping Bundle
Symfony Bundle for [laravel-doctrine/fluent](https://github.com/laravel-doctrine/fluent)
that provide alternative PHP Mapping Driver for Doctrine ORM

## Installation
Run this command in your terminal:  
`composer require gordinskiy/doctrine-fluent-mapping-bundle`

If you don't use Symfony Flex, you must enable the bundle manually in the application:

`// config/bundles.php  
  return [  
      ...  
      Gordinskiy\DoctrineFluentMappingBundle\DoctrineFluentMappingBundle::class => ['all' => true],
  ];`

## Configuration

Create `config/packages/doctrine_fluent.yaml` file and list your entities mappers in it:

`doctrine_fluent:  
    mappers:  
        list:  
            - Infrastructure\Doctrine\Mappers\UserMapper  
            - Infrastructure\Doctrine\Mappers\RoleMapper  
            - Infrastructure\Doctrine\Mappers\AccountMapper`
