<?php

namespace Mocks;

use Netflex\Support\ReactiveObject;

class TestObject extends ReactiveObject
{
  public function getDoubleValueAttribute($value)
  {
    return $value * 2;
  }
}
