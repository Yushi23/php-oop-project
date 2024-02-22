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

    public function testArray(): void
    {
        $v = new Validator();
        $schema = $v->array();

        $this->assertTrue($schema->isValid(null)); // true

        $schema = $schema->required();

        $this->assertTrue($schema->isValid([])); // true
        $this->assertTrue($schema->isValid(['hexlet'])); // true

        $this->assertTrue($schema->sizeof(2)); // true

        $this->assertFalse($schema->isValid(['hexlet'])); // false
        $this->assertTrue($schema->isValid(['hexlet', 'code-basics'])); // true
    }

    public function testArrayShape(): void
    {
        $v = new Validator();

        $schema = $v->array();

        // Позволяет описывать валидацию для ключей массива
        $schema->shape([
            'name' => $v->string()->required(),
            'age' => $v->number()->positive(),
        ]);

        $this->assertTrue($schema->isValid(['name' => 'kolya', 'age' => 100])); // true
        $this->assertTrue($schema->isValid(['name' => 'maya', 'age' => null])); // true
        $this->assertFalse($schema->isValid(['name' => '', 'age' => null])); // false
        $this->assertFalse($schema->isValid(['name' => 'ada', 'age' => -5])); // false
    }

    public function testAddValidator(): void
    {
        $v = new Validator();

        $fn = fn($value, $start) => str_starts_with($value, $start);
        // Метод добавления новых валидаторов
        // addValidator($type, $name, $fn)
        $v->addValidator('string', 'startWith', $fn);

        // Новые валидаторы вызываются через метод test
        $schema = $v->string()->test('startWith', 'H');
        $this->assertFalse($schema->isValid('exlet')); // false
        $this->assertTrue($schema->isValid('Hexlet')); // true

        $fn = fn($value, $min) => $value >= $min;
        $v->addValidator('number', 'min', $fn);

        $schema = $v->number()->test('min', 5);
        $this->assertFalse($schema->isValid(4)); // false
        $this->assertTrue($schema->isValid(6)); // true
    }
}
