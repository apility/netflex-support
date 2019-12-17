<?php

namespace Netflex\Support;

use Netflex\API;

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
}
