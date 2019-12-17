<?php

use PHPUnit\Framework\TestCase;
use Netflex\Support\Event;

final class EventTest extends TestCase
{
  public function testCanCreateEvent()
  {
    $handler = function () {
    };
    $event = new Event('testEvent', $handler);
    $this->assertInstanceOf(Event::class, $event);
    $this->assertSame('testEvent', $event->name);
    $this->assertSame($handler, $event->handler);
  }

  public function testCanModifyEvent()
  {
    $event = new Event('testEvent');
    $this->assertSame('testEvent', $event->name);
    $event->setName('modifiedEvent');
    $this->assertSame('modifiedEvent', $event->name);
  }

  public function testCanInvokeEvent()
  {
    $wasInvoked = false;
    $payload = 'PAYLOAD';

    $handler = function ($value) use (&$wasInvoked, $payload) {
      $wasInvoked = true;
      $this->assertSame($payload, $value);
    };

    $event = new Event('testEvent', $handler);
    $event->handle($payload);

    $this->assertSame(true, $wasInvoked);
  }
}
