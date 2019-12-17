<?php

namespace Netflex\Support;

class Event
{
  /** @var string */
  public $name;

  /** @var callable */
  public $handler;

  public function __construct($name = null, $handler = null)
  {
    $this->name = $name;
    $this->handler = $handler;
  }

  public function setName($name)
  {
    $this->name = $name;
    return $this;
  }

  public function setHandler($handler)
  {
    $this->handler = $handler;
    return $this;
  }

  public function handle($payload = null)
  {
    if (is_callable($this->handler)) {
      return ($this->handler)($payload);
    }
  }
}
