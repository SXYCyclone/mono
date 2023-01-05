<?php

declare(strict_types=1);

namespace Cyclone\Extend;

use ZM\Annotation\Framework\Init;

class Extend
{
    public function __construct()
    {
    }

    #[Init]
    public function onInit(): void
    {
        // just to trigger the constructor
    }
}
