<?php

namespace Mocks;

class TestObjectWithDefaults extends TestObject
{
  /** @var array */
  protected $defaults = [
    'bar' => 'baz'
  ];
}
