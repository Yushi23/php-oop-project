<?php

namespace Hexlet\Validator\Schemes;

use Hexlet\Validator\Validator;

class BaseScheme
{
    protected $parent;
    protected $checkNullOrArr = false;
    protected $test = false;
    protected $fn;
    protected $start;

    public function __construct(Validator $parent)
    {
        $this->parent = $parent;
    }

    public function required(): self
    {
        $this->checkNullOrArr = true;
        return $this;
    }

    public function test(string $fn, string $start): self
    {
        $this->fn = $fn;
        $this->start = $start;
        $this->test = true;
        return $this;
    }
}
