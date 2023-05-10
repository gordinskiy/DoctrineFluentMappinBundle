<?php

declare(strict_types=1);

namespace Gordinskiy\DoctrineFluentMappingBundle\Tests\UnitTests\DependencyInjection;

use Gordinskiy\DoctrineFluentMappingBundle\DependencyInjection\MappingDriverCompilerPass;
use LaravelDoctrine\Fluent\FluentDriver;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class MappingDriverCompilerPassTest extends TestCase
{
    public function test_process(): void
    {
        $compilerPass = new MappingDriverCompilerPass();
        $builderMock = $this->createMock(ContainerBuilder::class);

        $builderMock->expects($this->once())
            ->method('setDefinition')
            ->with('doctrine.orm.default_metadata_driver');

        $builderMock->expects($this->once())
            ->method('getDefinition')
            ->with(FluentDriver::class);

        $compilerPass->process($builderMock);
    }
}
