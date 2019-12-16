# Netflex\Support\Helpers

This namespace contains various helper classes and methods used throughout Netflex.

## Str

This class contains static methods for string manipulation

### Methods

Str::toCamelCase - Converts a string to camelCase

#### Description

```php
Str::toCamelCase( string $str) : string
```

#### Parameters

**str**
<br>The string to convert to camelCase

#### Return values

Returns string

#### Examples

```php
use Netflex\Support\Str;

echo Str::toCamelCase('camel_case_string');

// returns 'camelCaseString'
```

<hr>
