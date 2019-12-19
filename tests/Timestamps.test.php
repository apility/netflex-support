<?php

use Mocks\TestObjectWithTimestamps;
use PHPUnit\Framework\TestCase;
use Carbon\Carbon;
use Netflex\Support\ReactiveObject;

final class TimestampsTest extends TestCase
{
  public function setUp(): void
  {
    $this->getterCalled = 0;
    $this->setterCalled = 0;

    $this->created = Carbon::parse('2019-12-19 11:00:00');
    $this->updated = Carbon::parse('2019-12-19 11:02:00');
    $this->y2k = Carbon::parse('2000-01-01 00:00:00');

    $this->testItem = new TestObjectWithTimestamps([
      'created' => $this->created->toDateTimeString(),
      'updated' => $this->updated->toDateTimeString(),
      'notATimeStamp' => $this->y2k->toDateString(),
    ], null, $this);
  }

  public function testTypecasting()
  {
    $this->assertInstanceOf(Carbon::class, $this->testItem->created);
    $this->assertInstanceOf(Carbon::class, $this->testItem->updated);
    $this->assertIsString($this->testItem->notATimeStamp);
  }

  public function testIsCorrectlyCasted()
  {
    $this->assertSame(
      $this->created->toDateTimeString(),
      $this->testItem->created->toDateTimeString()
    );

    $this->assertSame(
      $this->updated->toDateTimeString(),
      $this->testItem->updated->toDateTimeString()
    );
  }

  public function testAssignmentFromCarbon()
  {
    $timestamp = Carbon::parse('2020-05-17 00:00:00');
    $this->testItem->updated = $timestamp;

    $this->assertEquals(
      $timestamp,
      $this->testItem->updated
    );
  }

  public function testAssignmentFromString()
  {
    $timestamp = '2020-04-01 00:00:00';
    $this->testItem->updated = $timestamp;

    $this->assertEquals(
      Carbon::parse($timestamp),
      $this->testItem->updated
    );
  }

  public function testDefaultAttribute()
  {
    $this->assertInstanceOf(Carbon::class, $this->testItem->defaultTimestamp);

    $this->assertSame(
      '1990-02-28 00:00:00',
      $this->testItem->defaultTimestamp->toDateTimeString()
    );

    $this->testItem->defaultTimestamp = '1337-01-01 13:37:00';

    $this->assertSame(
      '1337-01-01 13:37:00',
      $this->testItem->defaultTimestamp->toDateTimeString()
    );
  }

  public function testRespectsReadOnlyFlag()
  {
    $before = $this->testItem->created->toDateTimeString();
    $this->testItem->created = '2020-05-17 00:00:00';

    $this->assertSame(
      $before,
      $this->testItem->created->toDateTimeString()
    );
  }

  public function testJsonSerialization()
  {
    $json = $this->testItem->jsonSerialize();

    $this->assertIsString($json['created']);
    $this->assertIsString($json['updated']);
    $this->assertIsString($json['defaultTimestamp']);
  }
}
