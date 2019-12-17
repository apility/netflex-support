<?php

use PHPUnit\Framework\TestCase;
use Netflex\Support\ReactiveObject;

final class ReactiveObjectTest extends TestCase
{
  public function testConstructFromArray()
  {
    $attributes = [
      'id' => 10000,
      'name' => 'Test',
      'published' => true,
      'owner' => 1,
      'revision' => 10001
    ];

    $testObj = new class ($attributes) extends ReactiveObject
    {
    };

    foreach ($attributes as $key => $value) {
      $this->assertSame(
        $value,
        $testObj->{$key}
      );
    }
  }

  public function testConstructFromObject()
  {
    $attributes = (object) [
      'id' => 10000,
      'name' => 'Test',
      'published' => true,
      'owner' => 1,
      'revision' => 10001
    ];

    $testObj = new class ($attributes) extends ReactiveObject
    {
    };

    foreach ($attributes as $key => $value) {
      $this->assertSame(
        $value,
        $testObj->{$key}
      );
    }
  }

  public function testIdGetter()
  {
    $attributes = ['id' => '10000'];

    $testObj = new class ($attributes) extends ReactiveObject
    {
    };
    $this->assertSame(
      10000,
      $testObj->id
    );
  }

  public function testDebugInfo()
  {
    $attributes = [
      'id' => '10000',
      'doubleValue' => 10,
    ];

    $testObj = new class ($attributes) extends ReactiveObject
    {
      public function getDoubleValueAttribute($value)
      {
        return $value * 2;
      }
    };

    $debug = $testObj->__debugInfo();

    $this->assertSame(
      10000,
      $testObj->id
    );

    $this->assertSame(
      20,
      $testObj->doubleValue
    );
  }

  public function testJsonSerialization()
  {
    $attributes = [
      'id' => 10000,
      'name' => 'test',
      'published' => true
    ];

    $testObj = new class ($attributes) extends ReactiveObject
    {
    };

    $this->assertSame($attributes, $testObj->jsonSerialize());

    $attributes['id'] = '1234';
    $testObj = new class ($attributes) extends ReactiveObject
    {
    };
    $attributes['id'] = 1234;

    $this->assertSame($attributes, $testObj->jsonSerialize());
  }

  public function testJsonSerializationInvokesGetters()
  {
    $attributes = [
      'id' => 10000,
      'doubleValue' => 10,
    ];

    $testObj = new class ($attributes) extends ReactiveObject
    {
      public function getDoubleValueAttribute($value)
      {
        return $value * 2;
      }
    };

    $this->assertNotSame($attributes, $testObj->jsonSerialize());
    $this->assertSame(20, $testObj->jsonSerialize()['doubleValue']);
  }
}
