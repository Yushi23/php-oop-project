<?php

namespace Hexlet\Validator;

use Hexlet\Validator\Schemes\StringScheme;
use Hexlet\Validator\Schemes\NumberScheme;
use Hexlet\Validator\Schemes\ArrayScheme;

class Validator
{
    private $customValidatorFns;

    public function string(): StringScheme
    {
        return new StringScheme($this);
    }

    public function number(): NumberScheme
    {
        return new NumberScheme($this);
    }

    public function array(): ArrayScheme
    {
        return new ArrayScheme($this);
    }

    public function addValidator(string $type, string $name, callable $fn): void
    {
        if ($type == 'string' || $type == 'array' || $type == 'number') {
            $this->customValidatorFns[$type][$name] = $fn;
        } else {
            throw new \Exception('boom!');
        }
    }

    public function getValidator(): array
    {
        return $this->customValidatorFns;
    }
}
