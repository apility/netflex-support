<?php

namespace Netflex\Support;

use JsonSerializable;
use Tightenco\Collect\Support\Collection as BaseCollection;

abstract class ItemCollection extends BaseCollection implements JsonSerializable
{
  use Hooks;

  /** @var ReactiveObject|ItemCollection|null */
  protected $parent = null;

  /** @var string */
  protected static $type = ReactiveObject::class;

  /**
   * @param array|null $items = []
   */
  public function __construct($items = [], $parent = null)
  {
    $this->parent = $parent;

    if ($items) {
      parent::__construct(array_map(function ($item) {
        if (!($item instanceof static::$type)) {
          $item = static::$type::factory($item);
        }

        $item->setParent($this);

        return $item->addHook('modified', function ($_) {
          $this->performHook('modified');
        });
      }, $items));
    }
  }

  /**
   * @param array|null $items = []
   * @return static
   */
  public static function factory($items = [], $parent = null)
  {
    return new static($items, $parent);
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
    return array_values(
      array_filter(
        $this->jsonSerialize()
      )
    );
  }

  /**
   * Run a map over each of the items.
   *
   * @param callable $callback
   * @return Tightenco\Collect\Support\Collection
   */
  public function map(callable $callback)
  {
    return new BaseCollection(parent::map($callback));
  }

  /**
   * @return array
   */
  public function jsonSerialize()
  {
    $items = $this->all();

    if ($items && count($items)) {
      return array_map(function ($item) {
        return $item->jsonSerialize();
      }, $items);
    }

    return [];
  }
}
