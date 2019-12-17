<?php

use PHPUnit\Framework\TestCase;
use Netflex\Support\Events;

final class EventsTest extends TestCase
{
  public function setUp(): void
  {
    $this->testItem = new class ()
    {
      use Events;
    };

    $this->testItemWithParent = new class ($this->testItem)
    {
      use Events;

      public $parent;

      public function __construct($parent)
      {
        $this->parent = $parent;
      }
    };
  }

  public function testAddAndInvokeEvent()
  {
    $wasInvoked = false;
    $payload = 'PAYLOAD_1';

    $this->testItem->on('testEvent', function ($value) use (&$wasInvoked, $payload) {
      $wasInvoked = true;

      $this->assertSame(
        $payload,
        $value
      );
    });

    $this->testItem->trigger('testEvent', $payload);

    $this->assertSame(
      true,
      $wasInvoked
    );
  }

  public function testCanTriggerEventInParent()
  {
    $wasInvoked = false;
    $payload = 'PAYLOAD_2';

    $this->testItem->on('childEmittedEvent', function ($value) use (&$wasInvoked, $payload) {
      $wasInvoked = true;

      $this->assertSame(
        $payload,
        $value
      );
    });

    $this->testItemWithParent->emit('childEmittedEvent', $payload);

    $this->assertSame(
      true,
      $wasInvoked
    );
  }
}
