<?php

use PHPUnit\Framework\TestCase;
use Netflex\Support\NetflexObject;

final class NetflexObjectTest extends TestCase
{
  public function testConstructFromArray () {
    $attributes = [
      'id' => 10000,
      'name' => 'Test',
      'published' => true,
      'owner' => 1,
      'revision' => 10001
    ];

    $testObj = new class ($attributes) extends NetflexObject {};

    foreach ($attributes as $key => $value) {
      $this->assertSame(
        $value,
        $testObj->{$key}
      );
    }
  }

  public function testConstructFromObject () {
    $attributes = (object) [
      'id' => 10000,
      'name' => 'Test',
      'published' => true,
      'owner' => 1,
      'revision' => 10001
    ];

    $testObj = new class ($attributes) extends NetflexObject {};

    foreach ($attributes as $key => $value) {
      $this->assertSame(
        $value,
        $testObj->{$key}
      );
    }
  }

  public function testIdGetter () {
    $attributes = ['id' => '10000'];

    $testObj = new class ($attributes) extends NetflexObject {};
    $this->assertSame(
      10000,
      $testObj->id
    );
  }

  public function testDebugInfo () {
    $attributes = [
      'id' => '10000',
      'doubleValue' => 10,
    ];

    $testObj = new class ($attributes) extends NetflexObject {
      public function getDoubleValueAttribute ($value) {
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
}
