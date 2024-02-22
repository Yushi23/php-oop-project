<?php

namespace Hexlet\Validator\Schemes;

class NumberScheme extends BaseScheme
{
    private bool $positive = false;
    private int $min;
    private int $max;
    private string $type = 'number';

    public function positive(): self
    {
        $this->positive = true;
        return $this;
    }

    public function range(int $min, int $max): void
    {
        $this->min = $min;
        $this->max = $max;
    }

    public function isValid(mixed $value): bool
    {
        //Проверка установки required
        if ($this->checkNullOrArr && ($value === null || $value === 0)) {
            return false;
        }

        if ($this->positive && $value < 0) { //проверка установки positive
            return false;
        }

        if (isset($this->min) && isset($this->max)) { //проверка установки range
            return $this->min <= $value && $value <= $this->max;
        }

        if ($this->test) {
            return $this->parent->getValidator()[$this->type][$this->fn]($value, $this->start);
        }
        return true;
    }
}
