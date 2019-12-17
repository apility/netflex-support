<?php

namespace Netflex\Support;

class Event
{
  /** @var string */
  public $name;

  /** @var callable */
  public $handler;

  /**
   * @param string $name = null
   * @param callable $handler = null
   */
  public function __construct($name = null, $handler = null)
  {
    $this->name = $name;
    $this->handler = $handler;
  }

  /**
   * @param string $name
   * @return static
   */
  public function setName($name)
  {
    $this->name = $name;
    return $this;
  }

  /**
   * @param callable $handler
   * @return static
   */
  public function setHandler($handler)
  {
    $this->handler = $handler;
    return $this;
  }

  /**
   * @param mixed $payload
   * @return mixed
   */
  public function handle($payload = null)
  {
    if (is_callable($this->handler)) {
      return ($this->handler)($payload);
    }
  }
}
