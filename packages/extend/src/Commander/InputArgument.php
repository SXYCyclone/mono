<?php

declare(strict_types=1);

namespace Cyclone\Extend\Commander;

class InputArgument extends \Symfony\Component\Console\Input\InputArgument
{
    private string $description;

    public function setDescription($description): void
    {
        $this->description = $description;
    }

    public function getDescription(): string
    {
        return $this->description ?: parent::getDescription();
    }
}
