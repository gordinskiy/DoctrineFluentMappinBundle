<?php

declare(strict_types=1);

namespace Gordinskiy\Fixtures\Mappers\DirectoryWithSeveralMappers;

use LaravelDoctrine\Fluent\EntityMapping;
use LaravelDoctrine\Fluent\Fluent;

class OrderMapper extends EntityMapping
{
    public function mapFor(): string
    {
        return self::class;
    }

    public function map(Fluent $builder)
    {
    }
}
