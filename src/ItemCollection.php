<?php

namespace Netflex\Support;

use JsonSerializable;
use Tightenco\Collect\Support\Collection as BaseCollection;

class ItemCollection extends BaseCollection implements JsonSerializable
{
  use Hooks;

  /** @var string */
  protected static $type = NetflexObject::class;

  /**
   * @param array|null $items = []
   */
  public function __construct($items = [])
  {
    if ($items) {
      parent::__construct(array_map(function ($item) {
        return static::$type::factory($item);
      }, $items));
    }
  }

  /**
   * @param array|null $items = []
   * @return static
   */
  public static function factory($items = [])
  {
    return new static($items);
  }

  /**
   * Set the item at a given offset.
   *
   * @param string|int $offset
   * @param mixed $value
   * @return void
   */
  public function offsetSet($offset, $value)
  {
    parent::offsetSet($offset, $value);
    $this->performHook('modified');
  }

  /**
   * Unset the item at a given offset.
   *
   * @param string|int $offset
   * @return void
   */
  public function offsetUnset($offset)
  {
    parent::offsetUnset($offset);
    $this->performHook('modified');
  }

  /**
   * Get the collection of items as a plain array.
   *
   * @return array
   */
  public function toArray()
  {
    return array_values(array_filter(parent::toArray()));
  }

  /**
   * @return array
   */
  public function jsonSerialize()
  {
    $items = $this->all();

    if ($items) {
      return array_map(function ($item) {
        return $item->jsonSerialize();
      }, $items);
    }

    return [];
  }
}
