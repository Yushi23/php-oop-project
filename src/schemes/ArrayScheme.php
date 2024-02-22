<?php

namespace Hexlet\Validator\Schemes;

class ArrayScheme extends BaseScheme
{
    private $checkSize = false;
    private $lenArr;
    private $arr = false;
    private $type = 'array';

    public function sizeof(int $lenArr): bool
    {
        $this->lenArr = $lenArr;
        return $this->checkSize = boolval($this->lenArr);
    }

    public function shape(array $arr): void
    {
        $this->arr = $arr;
    }

    public function isValid(mixed $arr): bool
    {
        if ($this->checkNullOrArr && !is_array($arr)) {
            return false;
        } elseif ($this->checkSize) {
            return count($arr) === $this->lenArr;
        } elseif ($this->arr) {
            $boolVar = array_map(function (mixed $shapeArr, mixed $resArr) {
                return $shapeArr->isValid($resArr);
            }, $this->arr, $arr);
            return in_array(false, $boolVar) ? false : true;
        } elseif ($this->test) {
            return $this->parent->getValidator()[$this->type][$this->fn]($value, $this->start);
        } else {
            return true;
        }
    }
}
