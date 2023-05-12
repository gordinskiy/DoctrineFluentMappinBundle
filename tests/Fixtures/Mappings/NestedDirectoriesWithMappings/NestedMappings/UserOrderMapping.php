<?php

declare(strict_types=1);

namespace Gordinskiy\Fixtures\Mappings\NestedDirectoriesWithMappings\NestedMappings;

use LaravelDoctrine\Fluent\EntityMapping;
use LaravelDoctrine\Fluent\Fluent;

class UserOrderMapping extends EntityMapping
{
    public function mapFor(): string
    {
        return self::class;
    }

    public function map(Fluent $builder)
    {
    }
}
