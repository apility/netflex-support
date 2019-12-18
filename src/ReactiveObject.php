<?php

namespace Netflex\Support;

use ArrayAccess;
use JsonSerializable;

abstract class ReactiveObject implements ArrayAccess, JsonSerializable
{
  use Hooks;
  use Events;
  use Accessors;

  /** @var ReactiveObject|ItemCollection|null */
  protected $parent = null;

  /** @var array */
  protected $defaults = [];

  /** @var array */
  protected $readOnlyAttributes = ['id'];

  /**
   * @param object|array $attributes = []
   * @param object|null $parent = null
   */
  public function __construct($attributes = [], $parent = null)
  {
    $this->parent = $parent;

    if (is_object($attributes) || is_array($attributes)) {
      foreach ($attributes as $property => $value) {
        $this->attributes[$property] = $value;
      }
    }

    if (property_exists($this, 'defaults') && is_array($this->defaults)) {
      foreach ($this->defaults as $property => $value) {
        if (!($this->attributes[$property] ?? null)) {
          $this->attributes[$property] = $this->value;
        }
      }
    }
  }

  /**
   * @param ReactiveObject|ItemCollection|null $parent
   * @return static
   */
  public function setParent($parent)
  {
    $this->parent = $parent;
    return $this;
  }

  /**
   * @return ReactiveObject|ItemCollection|null
   */
  public function getParent()
  {
    return $this->parent;
  }

  /**
   * @param string|int $id
   * @return int
   */
  public function getIdAttribute($id = null)
  {
    return $id ? (int) $id : $id;
  }

  /**
   * @return array
   */
  public function __debugInfo()
  {
    $debug = [];

    foreach (array_keys($this->attributes) as $property) {
      $debug[$property] = $this->__get($property);
    }

    return $debug;
  }

  /**
   * @param object|array $attributes = []
   * @param object|null $parent = null
   * @return static
   */
  public static function factory($attributes = [], $parent = null)
  {
    return new static($attributes, $parent);
  }

  /**
   * @return array
   */
  public function jsonSerialize()
  {
    $json = [];

    foreach (array_keys($this->attributes) as $property) {
      $value = $this->__get($property);

      if ($value instanceof ItemCollection) {
        $value = $value->jsonSerialize();
      }

      $json[$property] = $value;
    }

    return $json;
  }
}
