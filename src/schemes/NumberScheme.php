<?php

namespace Hexlet\Validator\Schemes;

class NumberScheme
{
    private $checkNull = false;
    private $positive = false;
    private $min;
    private $max;

    public function required(): object
    {
        $this->checkNull = true;
        return $this;
    }

    public function positive(): object
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
        if ($this->checkNull && $value === null) {
            return false;
        } elseif ($this->positive && $value < 0) { //проверка установки positive
            return false;
        } elseif (isset($this->min) && isset($this->max)) { //проверка установки range
            if ($this->min <= $value && $value <= $this->max) {
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    }
}
