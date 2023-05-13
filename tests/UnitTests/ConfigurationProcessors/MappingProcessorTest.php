<?php

declare(strict_types=1);

namespace Gordinskiy\Tests\ConfigurationProcessors;

use Gordinskiy\DoctrineFluentMappingBundle\ConfigurationProcessors\MappingProcessor;
use Gordinskiy\DoctrineFluentMappingBundle\Exceptions\ConfigurationException;
use Gordinskiy\Fixtures\Mappings\DirectoryWithSeveralMappings\OrderMapping;
use LaravelDoctrine\Fluent\Mapping;
use PHPUnit\Framework\TestCase;

class MappingProcessorTest extends TestCase
{
    public function test_validation_of_incorrect_class(): void
    {
        self::expectException(ConfigurationException::class);
        self::expectExceptionMessage(
            "Mapping class [" . MappingProcessor::class . "] must implement " . Mapping::class
        );

        (new MappingProcessor(MappingProcessor::class))->getMappings();
    }

    public function test_validation_of_non_existent_class(): void
    {
        self::expectException(ConfigurationException::class);
        self::expectExceptionMessage("Mapping class [Not a class] not exist");

        (new MappingProcessor('Not a class'))->getMappings();
    }

    public function test_validation_of_correct_class(): void
    {
        self::expectNotToPerformAssertions();

        (new MappingProcessor(OrderMapping::class))->getMappings();
    }
}
