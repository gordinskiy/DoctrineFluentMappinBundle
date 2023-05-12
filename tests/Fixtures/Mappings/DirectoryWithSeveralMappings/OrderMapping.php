<?php

declare(strict_types=1);

namespace Gordinskiy\Fixtures\Mappings\DirectoryWithSeveralMappings;

use LaravelDoctrine\Fluent\EntityMapping;
use LaravelDoctrine\Fluent\Fluent;

class OrderMapping extends EntityMapping
{
    public function mapFor(): string
    {
        return self::class;
    }

    public function map(Fluent $builder)
    {
    }
}
