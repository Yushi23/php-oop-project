<?php

namespace Hexlet\Validator;

require_once 'schemes/StringScheme.php';

use Hexlet\Schemes\StringScheme\StringScheme;

class Validator
{
    public function string(): object
    {
        return new StringScheme();
    }
}
