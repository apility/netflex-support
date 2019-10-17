<?php

namespace Netflex\Support;

trait Events
{
  /** @var array */
  protected $eventHandlers = [];

  /**
   * Attaches an event handler for a given event
   *
   * @param string $event
   * @param callable $handler
   * @return void
   */
  public function on($event, callable $handler = null)
  {
    if ($handler) {
      $this->eventHandlers[] = (object) [
        'event' => $event,
        'handler' => $handler
      ];
    }
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
    if (property_exists($this, 'parent') && $this->parent instanceof NetflexObject) {
      $this->parent->trigger($event, $payload);
    }
  }

  /**
   * Invokes the event handlers for the given event
   *
   * @param string $event
   * @param mixed $payload = null
   * @return void
   */
  public function trigger($event, $payload = null)
  {
    $handlers = array_filter($this->eventHandlers, function ($handler) use ($event) {
      return $handler['handler'] === $event;
    });

    foreach ($handlers as $handler) {
      $handler['handler']($payload);
    }
  }
}
