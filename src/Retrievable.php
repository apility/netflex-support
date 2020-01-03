<?php

namespace Netflex\Support;

use Netflex\API;
use Tightenco\Collect\Support\Collection;

trait Retrievable
{
  /**
   * @param int $id
   * @return static
   */
  public static function retrieve($id)
  {
    if (property_exists(get_called_class(), 'base_path')) {
      return new static(
        API::getClient()
          ->get(trim(static::$base_path, '/') . '/' . $id)
      );
    }
  }

  /**
   * @return Collection
   */
  public static function all(){
    if (property_exists(get_called_class(), 'base_path')) {
      return collect(
        API::getClient()
          ->get(trim(static::$base_path, '/'))
      )->map(function ($attributes) {
        return static::factory($attributes);
      });
    }
  }
}
