<?php

namespace Netflex\Support;

trait Accessors
{
  /** @var array */
  protected $attributes = [];

  /** @var array */
  public $modified = [];

  /**
   * @param string $property
   * @return mixed
   */
  public function __get($property)
  {
    $value = $this->attributes[$property] ?? null;
    $getter = 'get' . Str::toCamcelCase($property) . 'Attribute';

    if (method_exists($this, $getter)) {
      $value = $this->{$getter}($value);
    }

    if (property_exists($this, 'defaults')) {
      if (is_null($value) && array_key_exists($property, $this->defaults)) {
        return $this->defaults[$property];
      }
    }

    return $value;
  }

  /**
   * @param string $property
   * @return bool
   */
  public function __isset($property)
  {
    if(isset($this->attributes[$property])){
      return true;
    }
    
    $getter = 'get' . Str::toCamcelCase($property) . 'Attribute';
    if (method_exists($this, $getter)) {
      return true;
    }

    return false;
  }

  /**
   * @param string $property
   * @param mixed $value
   */
  public function __set($property, $value)
  {
    if (
      !property_exists($this, 'readOnlyAttributes') ||
      !in_array($property, $this->readOnlyAttributes)
    ) {
      $setter = 'set' . Str::toCamcelCase($property) . 'attribute';

      if (method_exists($this, $setter)) {
        return $this->{$setter}($value);
      }

      $this->attributes[$property] = $value;
      $this->modified[] = $property;
      $this->modified = array_unique($this->modified);

      if (method_exists($this, 'performHook')) {
        $this->performHook('modified');
      }
    }
  }
}
