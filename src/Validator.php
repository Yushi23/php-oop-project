<?php

namespace Hexlet\Validator;

require_once 'schemes/StringScheme.php';
require_once 'schemes/NumberScheme.php';

use Hexlet\Schemes\StringScheme\StringScheme;
use Hexlet\Schemes\NumberScheme\NumberScheme;

class Validator
{
    public function string(): object
    {
        return new StringScheme();
    }

    public function number(): object
    {
        return new NumberScheme();
    }
}
