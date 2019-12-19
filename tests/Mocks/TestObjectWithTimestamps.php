<?php

namespace Mocks;

class TestObjectWithTimestamps extends TestObject
{
  /** @var array */
  protected $defaults = [
    'defaultTimestamp' => '1990-02-28 00:00:00'
  ];

  /** @var array */
  protected $readOnlyAttributes = [
    'created'
  ];

  /** @var array */
  protected $timestamps = [
    'created',
    'updated',
    'defaultTimestamp'
  ];
}
