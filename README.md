# Zicht Iterator Tools Library
The Iterator Tools, or itertools for short, are a collection of 
convenience functions to handle collections such as arrays, iterators, 
and strings.  Some of the naming and API is based on the Python 
itertools.

Common operations include:
- [mapping](#mapping): `map` and `mapBy`
- [filtering](#filtering): `filter`
- [sorting](#sorting): `sorted`
- [grouping](#grouping): `groupBy`
- [chaining](#chaining): `chain`
- [reducing](#reducing): `accumulate` and `reduce`

## Example data
The examples below will use the following data to illustrate how various
Iterator tools work:

```php
$words = ['Useful', 'god', 'oven', 'Bland', 'notorious'];
$numbers = [1, 3, 2, 5, 4],
$vehicles = [
    [
        'id' => 1,
        'type' => 'car', 
        'wheels' => 4, 
        'colors' => ['red', 'green', 'blue'], 
        'is_cool' => false, 
        'price' => 20000,
    ],
    [
        'id' => 2,
        'type' => 'bike', 
        'wheels' => 2, 
        'colors' => ['red', 'green', 'blue'], 
        'is_cool' => false, 
        'price' => 600,
    ],
    [
        'id' => 5,
        'type' => 'unicicle', 
        'wheels' => 1, 
        'colors' => ['red'], 
        'is_cool' => true, 
        'price' => 150,
    ],
    [
        'id' => 9,
        'type' => 'car', 
        'wheels' => 8, 
        'colors' => ['blue'], 
        'is_cool' => true, 
        'price' => 100000,
    ],
];

```

## Fluent interface
One way to use the Iterator Tools is to convert the array, Iterator, 
string, etc into an `IterableIterator`.  This class provides a fluent 
interface all of the common operations.  For example:

```php
use function Zicht\Itertools\iterable;

$result = iterable($vehicles)->filter('is_cool')->mapBy('id')->map('type');
var_dump($result);
// 5: 'unicicle', 9: 'car'

```

## Mapping
Mapping converts one collection into another collection of equal size.
Using `map` allows manipulation of the items while `mapBy` allows 
manipulation of the collection keys.  For example:

```php
use function Zicht\Itertools\iterable;

$getTitle = function ($value, $key) {
    return sprintf('%s with %s wheels', $value['type'], $value['wheels']);
};
$titles = iterable($vehicles)->map(getTitle);
var_dump($titles->toArray());
// 'car with 4 wheels', ..., 'car with 8 wheels'
```

Instead of a closure, `map` and `mapBy` also accept a string.  This 
string will be used to find a property or array index within the element 
which will become the new value or key.  For example:

```php
use function Zicht\Itertools\iterable;

$types = iterable($vehicles)->map('type');
var_dump($types->toArray());
// 'car', 'bike', 'unicicle', 'car'

$vehiclesById = iterable($vehicles)->mapBy('id');
var_dump(array_keys($vehiclesById->toArray()));
// 1, 2, 5, 9
```

There are several common mapping closures available in mappings.php.
Calling these functions returns a closure that can be passed to `map` 
and `mapBy`.  For example:

```php
use function Zicht\Itertools\iterable;
use function Zicht\Itertools\mappings\length;

$lengths = iterable($words)->map(length());
var_dump($lengths->toArray());
// 6, 3, 4, 5, 9
```

## Filtering
Filtering converts one collection into another, possibly shorter, 
collection.  Using `filter` each element in the collection is evaluated.
For example:

```php
use function Zicht\Itertools\iterable;

$isExpensive = function($value, $key) {
    return $value['price'] > 10000;
}
$expensive = iterable($vehicles)->filter($isExpensive);
var_dump($expensive->map('type'));
// 1: 'car', 9: 'car'
```

Instead of a closure, `filter` also accepts a string.  This string will
be used to find a property or array index within the element which will
be evaluated using `empty`.

```php
use function Zicht\Itertools\iterable;

$cool = iterable($vehicles)->filter('is_cool');
var_dump($cool->map('type'));
// 5: 'unicicle', 9: 'car'
```

There are several common filter closures available in filters.php.
Calling these function returns a closure that can be passed to `filter`.
For example:

```php
use function Zicht\Itertools\iterable;
use function Zicht\Itertools\filters\in;

$religiousWords = iterable($words)->filter(in(['allah', 'evi', 'god']));
var_dump($religiousWords);
// 'god'
```

## Sorting
`sorted` converts one collection into another collection of equal size
but with the elements sorted.  Without any arguments the elements are 
sorted ascending using their own value, for example:

```php
use function Zicht\Itertools\iterable;

$ordered = iterable($numbers)->sorted();
var_dump($ordered);
// 1, 2, 3, 4, 5
```

The first argument is used to obtain the sorting value to order by.
This can be a string, in which case it is used to find a property or 
array index within the element, or it can be a closure that returns the 
sorting value.  For example: 

```php
use function Zicht\Itertools\iterable;

$getLower = function ($value, $key) {
    return strtolower($value);
};
$ordered = iterable($words)->sorted($getLower);
var_dump($ordered);
// 'Bland', 'god', ,  'oven','Useful', 'notorious'];
// 1, 2, 3, 4, 5
```

## Grouping
_todo_

## Chaining
_todo_

## Reducing
_todo_
