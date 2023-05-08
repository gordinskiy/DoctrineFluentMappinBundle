<?php

declare(strict_types=1);

namespace Gordinskiy\DoctrineFluentMappingBundle\Tests\Fixtures\Mappers\InvalidMappers;

use LaravelDoctrine\Fluent\Fluent;

class MapperWithoutInheritance
{
    public function mapFor(): string
    {
        return self::class;
    }

    public function map(Fluent $builder)
    {
    }
}
