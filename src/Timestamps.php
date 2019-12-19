<?php

namespace Netflex\Support;

use Carbon\Carbon;

trait Timestamps
{
  /** @var array */
  protected $timestamps = [
    'created',
    'updated',
    'start',
    'stop'
  ];

  /** @var Carbon */
  public function serializeTimestamp($value)
  {
    if ($value) {
      $value = ($value instanceof Carbon) ? $value : Carbon::parse($value);
      return $value->toDateTimeString();
    }
  }

  /**
   * @param string $value
   * @return Carbon
   */
  private function getTimestamp($value)
  {
    return Carbon::parse($value);
  }

  /**
   * @param Carbon|string|null $value
   * @return string|null
   */
  private function setTimestamp($value)
  {
    return $this->serializeTimestamp($value);
  }

  /**
   * @param string $property
   * @return bool
   */
  private function isTimestamp($property)
  {
    return (property_exists($this, 'timestamps') &&
      in_array($property, $this->timestamps) &&
      method_exists($this, 'getTimestamp'));
  }
}
