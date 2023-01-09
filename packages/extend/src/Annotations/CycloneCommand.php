<?php

declare(strict_types=1);

namespace Cyclone\Extend\Annotations;

use ZM\Annotation\AnnotationBase;

#[\Attribute(\Attribute::IS_REPEATABLE | \Attribute::TARGET_METHOD)]
class CycloneCommand extends AnnotationBase
{
    public function __construct(
        public string $expression,
    ) {
    }
}
