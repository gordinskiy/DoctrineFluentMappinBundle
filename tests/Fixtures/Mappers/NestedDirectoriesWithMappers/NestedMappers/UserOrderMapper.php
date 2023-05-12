<?php

declare(strict_types=1);

namespace Gordinskiy\Fixtures\Mappers\NestedDirectoriesWithMappers\NestedMappers;

use LaravelDoctrine\Fluent\EntityMapping;
use LaravelDoctrine\Fluent\Fluent;

class UserOrderMapper extends EntityMapping
{
    public function mapFor(): string
    {
        return self::class;
    }

    public function map(Fluent $builder)
    {
    }
}
