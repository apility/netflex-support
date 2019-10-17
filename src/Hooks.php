<?php

namespace Netflex\Support;

trait Hooks
{
  /** @var array */
  protected $hooks = [];

  /**
   * @param string $name
   * @param callable $callback
   * @return static
   */
  public function addHook(string $name, callable $callback = null)
  {
    if ($callback) {
      $this->hooks[$name] = function () use ($callback) {
        return $callback($this);
      };
    }

    return $this;
  }

  /**
   * @param string $name
   * @return void
   */
  public function performHook($name)
  {
    if (array_key_exists($name, $this->hooks) && is_callable($this->hooks[$name])) {
      $this->hooks[$name]();
    }
  }

  /**
   * @return void
   */
  public function performHooks()
  {
    foreach ($this->hooks as $hook) {
      $hook();
    }
  }
}
