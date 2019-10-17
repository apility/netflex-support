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
    return new static(
      API::getClient()
        ->get(trim(static::$base_path, '/') . '/' . $id)
    );
  }
}
