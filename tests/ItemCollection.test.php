<?php

use PHPUnit\Framework\TestCase;
use Netflex\Support\ItemCollection;
use Netflex\Support\ReactiveObject;

final class ItemCollectionTest extends TestCase
{
  public function testCanConstructWithArray()
  {
    $testCollection = ItemCollection::factory([
      ['id' => 1],
      ['id' => 2]
    ]);

    $this->assertSame(
      2,
      $testCollection->count()
    );

    $this->assertInstanceOf(
      ReactiveObject::class,
      $testCollection->first()
    );

    $this->assertSame(
      1,
      $testCollection->first()->id
    );
  }

  public function testCanConstructWithObjects()
  {
    $testCollection = ItemCollection::factory([
      ReactiveObject::factory(['id' => 1]),
      ReactiveObject::factory(['id' => 2])
    ]);

    $this->assertSame(
      2,
      $testCollection->count()
    );

    $this->assertInstanceOf(
      ReactiveObject::class,
      $testCollection->first()
    );

    $this->assertSame(
      1,
      $testCollection->first()->id
    );
  }

  public function testToArray()
  {
    $testCollection = ItemCollection::factory([
      ReactiveObject::factory(['id' => 1]),
      null,
      ReactiveObject::factory(['id' => 2]),
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
    $testChildItem1 = ReactiveObject::factory(['id' => 1]);

    $testChildItem2 = ReactiveObject::factory([
      'id' => 2,
      'children' => ItemCollection::factory([
        ReactiveObject::factory(['id' => 3])
      ])
    ]);

    $testCollection = ItemCollection::factory([
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
