<?php

declare(strict_types=1);

namespace Cyclone\Extend\Commander;

class ExpressionParser
{
    public function parse($expression): array
    {
        $tokens = explode(' ', $expression);
        $tokens = array_map('trim', $tokens);
        $tokens = array_values(array_filter($tokens));

        if (count($tokens) === 0) {
            throw new \RuntimeException('The expression was empty');
        }

        $name = array_shift($tokens);

        $arguments = [];
        $options = [];

        foreach ($tokens as $token) {
            if (str_starts_with($token, '--')) {
                throw new \RuntimeException('An option must be enclosed by brackets: [--option]');
            }

            if ($this->isOption($token)) {
                $options[] = $this->parseOption($token);
            } else {
                $arguments[] = $this->parseArgument($token);
            }
        }

        return [
            'name' => $name,
            'arguments' => $arguments,
            'options' => $options,
        ];
    }

    private function isOption($token): bool
    {
        return str_starts_with($token, '[-');
    }

    private function parseArgument($token): InputArgument
    {
        if (str_ends_with($token, ']*')) {
            $mode = InputArgument::IS_ARRAY;
            $name = trim($token, '[]*');
        } elseif (str_ends_with($token, '*')) {
            $mode = InputArgument::IS_ARRAY | InputArgument::REQUIRED;
            $name = trim($token, '*');
        } elseif (str_starts_with($token, '[')) {
            $mode = InputArgument::OPTIONAL;
            $name = trim($token, '[]');
        } else {
            $mode = InputArgument::REQUIRED;
            $name = $token;
        }

        return new InputArgument($name, $mode);
    }

    private function parseOption($token): InputOption
    {
        $token = trim($token, '[]');

        // Shortcut [-y|--yell]
        if (str_contains($token, '|')) {
            [$shortcut, $token] = explode('|', $token, 2);
            $shortcut = ltrim($shortcut, '-');
        } else {
            $shortcut = null;
        }

        $name = ltrim($token, '-');

        if (str_ends_with($token, '=]*')) {
            $mode = InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY;
            $name = substr($name, 0, -3);
        } elseif (str_ends_with($token, '=')) {
            $mode = InputOption::VALUE_REQUIRED;
            $name = rtrim($name, '=');
        } else {
            $mode = InputOption::VALUE_NONE;
        }

        return new InputOption($name, $shortcut, $mode);
    }
}
