[![Build Status](https://scrutinizer-ci.com/g/zicht/itertools/badges/build.png?b=master)](https://scrutinizer-ci.com/g/zicht/itertools/build-status/master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/zicht/itertools/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/zicht/itertools/?branch=master) 
[![Code Coverage](https://scrutinizer-ci.com/g/zicht/itertools/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/zicht/itertools/?branch=master)

# Zicht Iterator Tools Library
The Iterator Tools, or itertools for short, are a collection of
convenience tools to handle sequences of data such as arrays,
iterators, and strings.  Some of the naming and API is based on the
Python itertools.

Common operations include:
- [mapping](#mapping): `map` and `mapBy`
- [filtering](#filtering): `filter`, `difference`
- [sorting](#sorting): `sorted`
- [grouping](#grouping): `groupBy`
- [reducing](#reducing): `accumulate` and `reduce`

## Example data
The examples below will use the following data to illustrate how
various Iterator tools work:

```php
$words = ['Useful', 'Goonies', 'oven', 'Bland', 'notorious'];
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

## Getter strategy
Many itertools can be passed a `$strategy` parameter.  This parameter
is used to obtain a value from the elements in the collection.  The
`$strategy` can be one of three things:

1. null, in which case the element itself is returned.  For example:

    ```php
    use function Zicht\Itertools\iterable;

    $result = iterable($words)->map(null);
    var_dump($result);
    // {0: 'Useful', 1: 'Goonies', 2: 'oven', 3: 'Bland', 4: 'notorious'}
    ```

2. a closure, in which case the closure is called with the element
   value and key as parameters to be used to compute a return value.
   For example:

    ```php
    use function Zicht\Itertools\iterable;

    $getDouble = function($value, $key) {
        return 2 * $value;
    };
    $result = iterable($numbers)->map($getDouble);
    var_dump($result);
    // {0: 2, 1: 6, 2: 4, 3: 10, 4: 8}
    ```

3. a string, in which case this string is used to create a closure
   that tries to find public properties, methods, or array indexes.
   For example:

    ```php
    use function Zicht\Itertools\iterable;

    $result = iterable($vehicles)->map('type');
    var_dump($result);
    // {0: 'car', 1: 'bike', 2: 'unicicle', 3: 'car'}
    ```

   The string can consist of multiple dot separated words, allowing
   access to nested properties, methods, and array indexes.

   If one of the words in the string can not be resolved into an
   existing propety, method, or array index, the value `null` will be
   returned.  For example:

    ```php
    use function Zicht\Itertools\iterable;

    $result = iterable($vehicles)->map('colors.2');
    var_dump($result);
    // {0: 'blue', 1: 'blue', 2: null, 3: null}
    ```

## Fluent interface
One way to use the Iterator Tools is to convert the array, Iterator,
string, etc into an `IterableIterator`.  This class provides a fluent
interface to all of the common operations.  For example:

```php
use function Zicht\Itertools\iterable;

$result = iterable($vehicles)->filter('is_cool')->mapBy('id')->map('type');
var_dump($result);
// {5: 'unicicle', 9: 'car'}
```

## Mapping
Mapping converts one collection into another collection of equal
length.  Using `map` allows manipulation of the elements while `mapBy`
allows manipulation of the collection keys.

For example, we can use a closure to create a title for each element
in `$vehicles`:

```php
use function Zicht\Itertools\iterable;

$getTitle = function ($value, $key) {
    return sprintf('%s with %s wheels', $value['type'], $value['wheels']);
};
$titles = iterable($vehicles)->map($getTitle);
var_dump($titles);
// {0: 'car with 4 wheels', ..., 3: 'car with 8 wheels'}
```

Using the string [getter strategy](#getter-strategy) we can easily get
the types for each element in `$vehicles` mapped by the vehicle
identifiers.  For example:

```php
use function Zicht\Itertools\iterable;

$types = iterable($vehicles)->mapBy('id')->map('type');
var_dump($types);
// {1: 'car', 2: 'bike', 5: 'unicicle', 9: 'car'}
```

There are several common mapping closures available
in [mappings.php](src/Zicht/Itertools/mappings.php).  Calling these
functions returns a closure that can be passed to `map` and `mapBy`.
For example:

```php
use function Zicht\Itertools\iterable;
use function Zicht\Itertools\mappings\length;

$lengths = iterable($words)->map(length());
var_dump($lengths);
// {0: 6, 1: 3, 2: 4, 3: 5, 4: 9}
```

## Filtering
Filtering converts one collection into another, possibly shorter,
collection.  Using `filter` each element in the collection is
evaluated, the elements that are considered `empty` will be rejected,
while the elements that are not `empty` will be allowd to pass through
the filter.

For example, we can use a closure to determine if an element is
expensive, the `filter` will then only allow the expensive elements
through:

```php
use function Zicht\Itertools\iterable;

$isExpensive = function($value, $key) {
    return $value['price'] >= 10000;
}
$expensiveTypes = iterable($vehicles)->filter($isExpensive)->map('type');
var_dump($expensiveTypes);
// {1: 'car', 9: 'car'}
```

Using the string [getter strategy](#getter-strategy) we can get only
the `$vehicles` that are considered to be cool.  For example:

```php
use function Zicht\Itertools\iterable;

$coolVehicleTypes = iterable($vehicles)->filter('is_cool')->map('type');
var_dump($coolVehicleTypes);
// {5: 'unicicle', 9: 'car'}
```

There are several common filter closures available
in [filters.php](src/Zicht/Itertools/filters.php).  Calling these
function returns a closure that can be passed to `filter`.  For
example:

```php
use function Zicht\Itertools\iterable;
use function Zicht\Itertools\filters\in;

$movieWords = iterable($words)->filter(in(['Shining', 'My little pony', 'Goonies']));
var_dump($movieWords);
// {1: 'Goonies'}
```

## Sorting
`sorted` converts one collection into another collection of equal size
but with the elements possibly reordered.

For example, using the `null` [getter strategy](#getter-strategy),
which is the default, we will sort using the element values in
ascending order:

```php
use function Zicht\Itertools\iterable;

$ordered = iterable($numbers)->sorted();
var_dump($ordered);
// {0: 1, 2: 2, 1: 3, 4: 4, 3: 5}
```

The sorting algorithm will preserve the keys and is guarateed to be
stable.  I.e. when elements are sorted using the same value, then the
sorted order is guarateed to be the same as the order of the input
elements.  This is contrary to the standard PHP sorting functions.

Using the closure [getter strategy](#getter-strategy) the returned
value is used to determine the order.  The closure is called exactly
once per element, and the resulting values must be comparable.  For
example:

```php
use function Zicht\Itertools\iterable;

$getLower = function ($value, $key) {
    return strtolower($value);
};
$ordered = iterable($words)->sorted($getLower);
var_dump($ordered);
// {3: 'Bland', 1: 'Goonies', 2: 'oven', 0: 'Useful', 4: 'notorious'};
```

The [mappings.php](src/Zicht/Itertools/mappings.php) provides a
mapping closure which returns a random number.  This can be used to
sort a collection in a random order.  For example:

```php
use function Zicht\Itertools\iterable;
use function Zicht\Itertools\mappings\random;

$randomized = iterable($words)->sorted(random());
var_dump($randomized);
// {... randomly ordere words ...}
```

## Grouping
`groupBy` converts one collection into one or more collections that
group the elements together on a specific criteria.

For example, using the string [getter strategy](#getter-strategy) we
can group all the `$vehicles` of the same type together:

```php
use function Zicht\Itertools\iterable;

$vehiclesByType = iterable($vehicles)->groupBy('type');
var_dump($vehiclesByType);
// {'bike': {1: [...]}, 'car': {0: [...], 3: [...]} 'unicicle': {2: [...]}}
```

Not that the original keys of the vehicles are still part of the
resulting groups, and the elements within each group keep the order
that they had in the input, i.e. it uses the stable sorting provided
by [`sorted`](#sorting).

## Reducing
`reduce` converts a collection into a single value by calling a
closure of two arguments comulatively to the elements in the
collection, from left to right.

For example, without any arguments `reduce` will add all elements of
the collection together:

```php
use function Zicht\Itertools\iterable;

$sum = iterable($numbers)->reduce();
var_dump($sum);
// 15
```

In the above exmple, the default closure that is used looks like this:

```php
function add($a, $b) {
    return $a + $b;
}
```

Given that `$numbers` consists of the elements {1, 3, 2, 5, 4}, the
`add` closure is called four times:

```php
$sum = add(add(add(add(1, 3), 2), 5), 4);
var_dump($sum);
// 15
```

There are several common reduction closures available
in [reductions.php](src/Zicht/Itertools/reductions.php).  Calling
these functions returns a closure that can be passed to `reduction`.
For example:

```php
use function Zicht\Itertools\iterable;
use Zicht\Itertools\reductions;

$scentence = iterable($words)->reduce(reductions\join(' - '));
var_dump($scentence);
// 'Useful - Goonies - oven - Bland - notorious'
```

# Maintainer(s)
* Boudewijn Schoon <boudewijn@zicht.nl>
