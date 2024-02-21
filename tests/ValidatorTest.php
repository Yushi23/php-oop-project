<?php

namespace Hexlet\Tests;

use PHPUnit\Framework\TestCase;
use Hexlet\Validator\Validator;

class ValidatorTest extends TestCase
{
    public function testString(): void
    {
        $v = new Validator();
        $schema = $v->string();
        // Каждый вызов возвращает новую схему,
        // так как у нас может быть любое количество независимых проверок
        $schema2 = $v->string(); // $schema != $schema2

        $this->assertTrue($schema->isValid('')); // true

        // Null валидное значение для всех валидаторов
        // если не задан required
        $this->assertTrue($schema->isValid(null)); // true

        $this->assertTrue($schema->isValid('what does the fox say')); // true

        $schema->required();

        $this->assertTrue($schema2->isValid('')); // По прежнему валидно, это другая схема
        $this->assertFalse($schema->isValid(null)); // А тут не валидно
        $this->assertFalse($schema->isValid('')); // И тут тоже

        $this->assertTrue($schema->isValid('hexlet')); // true

        $this->assertTrue($schema->contains('what')->isValid('what does the fox say')); // true
        $this->assertFalse($schema->contains('whatthe')->isValid('what does the fox say')); // false

        // Если один валидатор вызывался несколько раз
        // то последний имеет приоритет (перетирает предыдущий)
        $this->assertTrue($v->string()->minLength(10)->minLength(5)->isValid('Hexlet')); // true
    }

    public function testNumber(): void
    {
        $v = new Validator();
        $schema = $v->number();

        $this->assertTrue($schema->isValid(null)); // true
        $schema->required();
        $this->assertFalse($schema->isValid(null)); // false

        // Достаточно работать с типом Integer
        $this->assertTrue($schema->isValid(7)); // true
        $this->assertTrue($schema->positive()->isValid(10)); // true
        $schema->range(-5, 5);
        $this->assertFalse($schema->isValid(-3)); // false
        $this->assertTrue($schema->isValid(5)); // true
    }
}
