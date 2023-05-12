<?php

declare(strict_types=1);

namespace Gordinskiy\DoctrineFluentMappingBundle\Tests\UnitTests\Validators;

use Gordinskiy\DoctrineFluentMappingBundle\Exceptions\ConfigurationException;
use Gordinskiy\DoctrineFluentMappingBundle\Tests\Fixtures\Mappers\DirectoryWithSeveralMappers\OrderMapper;
use Gordinskiy\DoctrineFluentMappingBundle\Validators\MappingsValidator;
use LaravelDoctrine\Fluent\Mapping;
use PHPUnit\Framework\TestCase;

class MappingsValidatorTest extends TestCase
{
    public function test_validation_of_incorrect_class(): void
    {
        self::expectException(ConfigurationException::class);
        self::expectExceptionMessage(
            "Mapping class [" . MappingsValidator::class . "] must implement " . Mapping::class
        );
        MappingsValidator::isValid(MappingsValidator::class);
    }

    public function test_validation_of_correct_class(): void
    {
        self::expectNotToPerformAssertions();

        MappingsValidator::isValid(OrderMapper::class);
    }
}