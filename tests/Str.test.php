<?php

use PHPUnit\Framework\TestCase;
use Netflex\Support\Str;

final class StrTest extends TestCase
{
  public function testConvertsSnakeCase(): void
  {
    $this->assertEquals(
      'snakeCase',
      Str::toCamcelCase('snake_case')
    );
  }

  public function testConvertsKebabCase(): void
  {
    $this->assertEquals(
      'kebabCase',
      Str::toCamcelCase('kebab-case')
    );
  }

  public function testConvertsWhitespace(): void
  {
    $this->assertEquals(
      'whiteSpace',
      Str::toCamcelCase('white space')
    );
  }

  public function testPreservesCase(): void
  {
    $this->assertEquals(
      'notModifiedCamelCase',
      Str::toCamcelCase('notModifiedCamelCase')
    );
  }

  public function testHandlesMixedCase(): void
  {
    $this->assertEquals(
      'stringWith-Mixed_Case',
      Str::toCamcelCase('string with-Mixed_Case')
    );
  }
}
