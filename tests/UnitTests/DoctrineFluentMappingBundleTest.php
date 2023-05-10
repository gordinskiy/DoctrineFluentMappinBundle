<?php

declare(strict_types=1);

namespace Gordinskiy\DoctrineFluentMappingBundle\Tests\UnitTests;

use Gordinskiy\DoctrineFluentMappingBundle\DependencyInjection\DoctrineFluentMappingExtension;
use Gordinskiy\DoctrineFluentMappingBundle\DependencyInjection\MappingDriverCompilerPass;
use Gordinskiy\DoctrineFluentMappingBundle\DoctrineFluentMappingBundle;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class DoctrineFluentMappingBundleTest extends TestCase
{
    public function test_build():void
    {
        $bundle = new DoctrineFluentMappingBundle();
        $builderMock = $this->createMock(ContainerBuilder::class);
        $builderMock->expects($this->once())
            ->method('addCompilerPass')
            ->with(new MappingDriverCompilerPass());

        $bundle->build($builderMock);

    }

    public function test_extension_getter():void
    {
        self::assertInstanceOf(
            expected: DoctrineFluentMappingExtension::class,
            actual: (new DoctrineFluentMappingBundle())->getContainerExtension()
        );
    }
}
