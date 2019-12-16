<?php

use PHPUnit\Framework\TestCase;
use Netflex\Support\Hooks;

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
}
