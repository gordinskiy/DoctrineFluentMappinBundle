<?php

declare(strict_types=1);

namespace Gordinskiy\Tests\Validators;

use Gordinskiy\DoctrineFluentMappingBundle\Exceptions\ConfigurationException;
use Gordinskiy\Fixtures\Mappings\DirectoryWithSeveralMappings\OrderMapping;
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

    public function test_validation_of_non_existent_class(): void
    {
        self::expectException(ConfigurationException::class);
        self::expectExceptionMessage("Mapping class [Not a class] not exist");
        MappingsValidator::isValid('Not a class');
    }

    public function test_validation_of_correct_class(): void
    {
        self::expectNotToPerformAssertions();

        MappingsValidator::isValid(OrderMapping::class);
    }
}