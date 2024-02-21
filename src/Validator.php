<?php

namespace Hexlet\Validator;

require_once 'schemes/StringScheme.php';
require_once 'schemes/NumberScheme.php';

use Hexlet\Validator\Schemes\StringScheme;
use Hexlet\Validator\Schemes\NumberScheme;

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
