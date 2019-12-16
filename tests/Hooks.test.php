<?php

use PHPUnit\Framework\TestCase;
use Netflex\Support\Hooks;
use Netflex\Support\Accessors;

final class HooksTest extends TestCase
{
  public function setUp (): void {
    $this->testItem = new class ($this) {
      use Hooks;
    };
  }

  public function testAttachAndPerformHooks () {
    $hookCalled = 0;

    $hook = function ($value) use (&$hookCalled) {
      $this->assertSame($this->testItem, $value);
      $hookCalled++;
    };

    $this->testItem->addHook('testHook', $hook);
    $this->testItem->performHook('testHook');

    $this->assertSame(
      1,
      $hookCalled
    );

    $this->testItem->addHook('testHook2', $hook);

    $this->testItem->performHooks();

    $this->assertSame(
      3,
      $hookCalled
    );
  }

  public function testModifiedHook () {
    $this->testItem = new class (['name' => 'foo']) {
      use Hooks;
      use Accessors;

      public function __construct ($attributes) {
        $this->attributes = $attributes;
      }
    };

    $modified = 0;

    $this->testItem->addHook('modified', function ($_) use (&$modified) {
      $modified++;
    });

    $this->testItem->name = 'bar';

    $this->assertSame(1, $modified);
  }
}
