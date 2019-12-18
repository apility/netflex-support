<?php

namespace Mocks;

use Netflex\Support\ReactiveObject;

class TestObject extends ReactiveObject
{
  /** @var TestCase */
  private $test;

  /** @var array */
  protected $readOnlyAttributes = ['readOnly'];

  public function __construct($attributes, $parent = null, $testCase = null)
  {
    parent::__construct($attributes, $parent);
    $this->test = $testCase;
  }

  public function getDoubleValueAttribute($value)
  {
    return $value * 2;
  }

  public function getDynamicAttribute($pageNumber)
  {
    $this->test->getterCalled++;
    return (int) $pageNumber;
  }

  public function setDynamicAttribute($pageNumber)
  {
    $this->test->setterCalled++;
    $pageNumber = (int) $pageNumber;

    if ($pageNumber < 1) {
      $pageNumber = 1;
    }

    $this->attributes['dynamic'] = (string) $pageNumber;
  }

  public function getWeirdNamedPropertyAttribute($weird_named_property)
  {
    return 'Very ' . $weird_named_property;
  }
}
