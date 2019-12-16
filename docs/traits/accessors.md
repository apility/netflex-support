# Netflex\Support\Accessors

This trait provides a simple and reusable way to implement getters and setters for any class.

## Properties

### $attributes

This is a protected array that acts as the storage container for the actual properties.

If no getter or setter methods are defined for that particual property, it is returned as is.

### $modified

When a property is modified the key of the property that was modified is added to this array.

### $readOnlyAttributes

All keys names that appears in this array is considered read-only, and it will not be possible to modify this value.

## Examples

```php
use Netflex\Support\Accessors;

class MyClass {
  use Accessors;

  protected $attributes = [
    'test' => 'it works',
    'pageNumber' => '1'
  ];

  public function getPageNumberAttribute ($pageNumber) {
    return (int) $pageNumber;
  }

  public function setPageNumberAttribute ($pageNumber) {
    $pageNumber = (int) $pageNumber;
    if ($pageNumber < 1) {
      $pageNumber = 1;
    }

    $this->attributes['pageNumber'] = (string) $pageNumber;
  }
}

$myClassInstance = new MyClass();

echo $myClassInstance->test;
// returns 'it works'

echo $myClassInstance->pageNumber;
// invokes the getPageNumberAttribute getter method
// and returns 1 as int instead of string

$myClassInstance->pageNumber = -4;
// invokes the setPageNumberAttribute setter method
echo $myClassInstance->pageNumber;
// returns 1
```
