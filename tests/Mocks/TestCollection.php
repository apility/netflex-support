<?php

namespace Mocks;

use Netflex\Support\ItemCollection;

class TestCollection extends ItemCollection
{
  protected static $type = TestObject::class;
}
