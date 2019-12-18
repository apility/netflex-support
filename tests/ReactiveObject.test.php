<?php

use Mocks\TestObject;
use PHPUnit\Framework\TestCase;
use Netflex\Support\ReactiveObject;

final class ReactiveObjectTest extends TestCase
{
  public function testIsAbstract()
  {
    $this->expectException(Error::class);
    new ReactiveObject();
  }

  public function testConstructFromArray()
  {
    $attributes = [
      'id' => 10000,
      'name' => 'Test',
      'published' => true,
      'owner' => 1,
      'revision' => 10001
    ];

    $testObj = TestObject::factory($attributes);

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

    $testObj = TestObject::factory($attributes);

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

    $testObj = TestObject::factory($attributes);

    $this->assertSame(
      10000,
      $testObj->id
    );
  }

  public function testGetters()
  {
    $attributes = [
      'id' => '10000',
      'doubleValue' => 10,
    ];

    $testObj = TestObject::factory($attributes);

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

    $testObj = TestObject::factory($attributes);

    $this->assertSame($attributes, $testObj->jsonSerialize());

    $attributes['id'] = '1234';
    $testObj = TestObject::factory($attributes);

    $attributes['id'] = 1234;

    $this->assertSame($attributes, $testObj->jsonSerialize());
  }

  public function testJsonSerializationInvokesGetters()
  {
    $attributes = [
      'id' => 10000,
      'doubleValue' => 10,
    ];

    $testObj = TestObject::factory($attributes);

    $this->assertNotSame($attributes, $testObj->jsonSerialize());
    $this->assertSame(20, $testObj->jsonSerialize()['doubleValue']);
  }

  public function testArrayAccess()
  {
    $testObj = TestObject::factory([
      'id' => 10000,
      'name' => 'Test',
      'empty' => null,
      'doubleValue' => 4
    ]);

    $this->assertSame(
      10000,
      $testObj['id']
    );

    $this->assertSame(
      'Test',
      $testObj['name']
    );

    $this->assertSame(
      8,
      $testObj['doubleValue']
    );

    $testObj['newKey'] = 'Test123';

    $this->assertSame(
      'Test123',
      $testObj['newKey']
    );

    $this->assertSame(
      'Test123',
      $testObj->newKey
    );

    unset($testObj['newKey']);

    $this->assertNull(
      $testObj['newKey']
    );
  }
}
