<?php

namespace Hexlet\Schemes\StringScheme;

class StringScheme
{
    private $checkNull = false;
    private $lengthStr;
    private $subStr;

    public function required(): object
    {
        $this->checkNull = true;
        return $this;
    }

    public function minLength(int $number): object
    {
        $this->lengthStr = $number;
        return $this;
    }

    public function contains(string $subStr): object
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

        return empty($value) ? !$this->checkNull : true;
    }
}
