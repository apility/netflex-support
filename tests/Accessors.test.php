<?php

use PHPUnit\Framework\TestCase;
use Netflex\Support\Accessors;

final class AccessorsTest extends TestCase
{
  public function setUp (): void {
    $this->getterCalled = 0;
    $this->setterCalled = 0;

    $this->testItem = new class ($this) {
      use Accessors;

      /** @var TestCase */
      private $test;

      protected $readOnlyAttributes = ['readOnly'];

      protected $defaults = [
        'bar' => 'baz'
      ];

      public function __construct ($test) {
        $this->test = $test;

        $this->attributes = [
          'normal' => 'hello world',
          'dynamic' => '1',
          'readOnly' => 'foo'
        ];
      }

      public function getDynamicAttribute ($pageNumber) {
        $this->test->getterCalled++;
        return (int) $pageNumber;
      }

      public function setDynamicAttribute ($pageNumber) {
        $this->test->setterCalled++;
        $pageNumber = (int) $pageNumber;

        if ($pageNumber < 1) {
          $pageNumber = 1;
        }

        $this->attributes['dynamic'] = (string) $pageNumber;
      }
    };
  }

  public function testGetRegularProperty () {
    $this->assertSame(
      'hello world',
      $this->testItem->normal
    );
  }

  public function testSetRegularProperty () {
    $this->testItem->normal = 'OK';

    $this->assertSame(
      'OK',
      $this->testItem->normal
    );
  }

  public function testGetDynamicAttribute () {
    $this->getterCalled = 0;

    $this->assertSame(
      1,
      $this->testItem->dynamic
    );

    $this->assertSame(
      1,
      $this->getterCalled
    );

    $this->testItem->dynamic;

    $this->assertSame(
      2,
      $this->getterCalled
    );
  }

  public function testSetDynamicAttribute () {
    $this->getterCalled = 0;
    $this->setterCalled = 0;

    $this->testItem->dynamic = 2;

    $this->assertSame(
      2,
      $this->testItem->dynamic
    );

    $this->testItem->dynamic = -4;

    $this->assertSame(
      1,
      $this->testItem->dynamic
    );

    $this->assertSame(
      2,
      $this->setterCalled
    );

    $this->assertSame(
      2,
      $this->getterCalled
    );
  }

  public function testReadyOnlyAttribute () {
    $this->assertSame(
      'foo',
      $this->testItem->readOnly
    );

    $this->testItem->readOnly = 'modified';

    $this->assertSame(
      'foo',
      $this->testItem->readOnly
    );
  }

  public function testDefaultValues () {
    $this->assertSame(
      'baz',
      $this->testItem->bar
    );
  }
}
