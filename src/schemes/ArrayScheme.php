<?php

namespace Hexlet\Validator\Schemes;

class ArrayScheme extends BaseScheme
{
    private bool $checkSize = false;
    private int $lenArr;
    private bool $shape = false;
    private array $arr;
    private string $type = 'array';

    public function sizeof(int $lenArr): bool
    {
        $this->lenArr = $lenArr;
        return $this->checkSize = boolval($this->lenArr);
    }

    public function shape(array $arr): void
    {
        $this->shape = true;
        $this->arr = $arr;
    }

    public function isValid(mixed $arr): bool
    {
        if ($this->checkNullOrArr && !is_array($arr)) {
            return false;
        }

        if ($this->checkSize && count($arr) !== $this->lenArr) {
            return false;
        }

        if ($this->shape) {
            $boolVar = array_map(function (mixed $shapeArr, mixed $resArr) {
                return $shapeArr->isValid($resArr);
            }, $this->arr, $arr);
            return array_search(false, $boolVar, true) === false;
        }

        if ($this->test) {
            return $this->parent->getValidator()[$this->type][$this->fn]($arr, $this->start);
        }
        return true;
    }
}
