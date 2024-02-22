<?php

namespace Hexlet\Validator\Schemes;

class NumberScheme extends BaseScheme
{
    private $positive = false;
    private $min;
    private $max;
    private $type = 'number';

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
        } elseif ($this->positive && $value < 0) { //проверка установки positive
            return false;
        } elseif (isset($this->min) && isset($this->max)) { //проверка установки range
            if ($this->min <= $value && $value <= $this->max) {
                return true;
            } else {
                return false;
            }
        } elseif ($this->test) {
            return $this->parent->getValidator()[$this->type][$this->fn]($value, $this->start);
        } else {
            return true;
        }
    }
}
