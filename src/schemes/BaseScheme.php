<?php

namespace Hexlet\Validator\Schemes;

use Hexlet\Validator\Validator;

class BaseScheme
{
    protected object $parent;
    protected bool $checkNullOrArr = false;
    protected bool $test = false;
    protected string $fn;
    protected string $start;

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
