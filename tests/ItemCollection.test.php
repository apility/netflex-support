<?php

use PHPUnit\Framework\TestCase;

use Mocks\TestObject;
use Mocks\TestCollection;
use Netflex\Support\ItemCollection;

final class ItemCollectionTest extends TestCase
{
  public function testIsAbstract()
  {
    $this->expectException(Error::class);
    new ItemCollection();
  }

  public function testCanConstructWithArray()
  {
    $testCollection = TestCollection::factory([
      ['id' => 1],
      ['id' => 2]
    ]);

    $this->assertSame(
      2,
      $testCollection->count()
    );

    $this->assertInstanceOf(
      TestObject::class,
      $testCollection->first()
    );

    $this->assertSame(
      1,
      $testCollection->first()->id
    );
  }

  public function testCanConstructWithObjects()
  {
    $testCollection = TestCollection::factory([
      TestObject::factory(['id' => 1]),
      TestObject::factory(['id' => 2])
    ]);

    $this->assertSame(
      2,
      $testCollection->count()
    );

    $this->assertInstanceOf(
      TestObject::class,
      $testCollection->first()
    );

    $this->assertSame(
      1,
      $testCollection->first()->id
    );
  }

  public function testToArray()
  {
    $testCollection = TestCollection::factory([
      TestObject::factory(['id' => 1]),
      null,
      TestObject::factory(['id' => 2]),
      null
    ]);

    $this->assertSame(
      4,
      $testCollection->count()
    );

    $this->assertSame(
      2,
      count($testCollection->toArray())
    );
  }

  public function testNestedSerialization()
  {
    $testChildItem1 = TestObject::factory(['id' => 1]);

    $testChildItem2 = TestObject::factory([
      'id' => 2,
      'children' => TestCollection::factory([
        TestObject::factory(['id' => 3])
      ])
    ]);

    $testCollection = TestCollection::factory([
      $testChildItem1,
      $testChildItem2
    ]);

    $this->assertSame(
      $testChildItem1->jsonSerialize(),
      $testCollection->jsonSerialize()[0]
    );

    $this->assertSame(
      $testChildItem2->children->first()->id,
      $testCollection->jsonSerialize()[1]['children'][0]['id']
    );
  }
}
