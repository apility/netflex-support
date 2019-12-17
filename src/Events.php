<?php

namespace Netflex\Support;

trait Events
{
  /** @var Event[] */
  protected $eventHandlers = [];

  /**
   * Attaches an event handler for a given event
   *
   * @param string $eventName
   * @param callable $handler
   * @return static
   */
  public function on($eventName, callable $handler = null)
  {
    return $this->addEvent(
      new Event($eventName, $handler)
    );
  }

  /**
   * Attaches an Event directly
   *
   * @param Event $event
   * @return static
   */
  public function addEvent(Event $event)
  {
    $this->eventHandlers[] = $event;
    return $this;
  }

  /**
   * Emits an event to parent
   *
   * @param string $event
   * @param mixed $payload = null
   * @return void
   */
  public function emit($event, $payload = null)
  {
    if (property_exists($this, 'parent') && method_exists($this->parent, 'trigger')) {
      $this->parent->trigger($event, $payload);
    }
  }

  /**
   * Invokes the event handlers for the given event
   *
   * @param string $eventName
   * @param mixed $payload = null
   * @return void
   */
  public function trigger($eventName, $payload = null)
  {
    $events = array_filter($this->eventHandlers, function (Event $event) use ($eventName) {
      return $event->name === $eventName;
    });

    foreach ($events as $event) {
      $event->handle($payload);
    }
  }
}
