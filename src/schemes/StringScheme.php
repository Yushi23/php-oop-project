<?php

namespace Hexlet\Validator\Schemes;

class StringScheme extends BaseScheme
{
    private $lengthStr;
    private $subStr;
    private $type = 'string';

    public function minLength(int $number): self
    {
        $this->lengthStr = $number;
        return $this;
    }

    public function contains(string $subStr): self
    {
        $this->subStr = $subStr;
        return $this;
    }

    //isValid проверяет валидность значения и возвращает true/false
    public function isValid(mixed $value): bool
    {
        if (isset($this->lengthStr)) {
            //сброс значения lengthStr для пропуска этого условия на следующей итерации
            $lengthStr = $this->lengthStr;
            $this->lengthStr = null;

            //расчет кол-ва символов, вывод результата
            return mb_strlen($value) >= $lengthStr;
        }

        if (isset($this->subStr)) {
            //сброс значения subStr для пропуска этого условия на следующей итерации
            $subStr = $this->subStr;
            $this->subStr = null;

            //вывод результата
            return str_contains($value, $subStr);
        }

        if ($this->test) {
            return $this->parent->getValidator()[$this->type][$this->fn]($value, $this->start);
        }
        return empty($value) ? !$this->checkNullOrArr : true;
    }
}
