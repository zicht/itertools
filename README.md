# Zicht Iterator Tools Library
The Iterator Tools, or itertools for short, are a collection of convenience functions to handle
collections such as arrays, iterators, and strings.  Some of the naming and API is based on the 
Python itertools.

Common operations include:
- mapping
- filtering
- sorting
- grouping
- chaining
- reducing

## Example data
The examples below will use the following data to illustrate how various Iterator tools work:
```
$words = ['useful', 'god', 'oven', 'bland', 'notorious'];
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

## Usage within PHP code
### Fluent interface
One way to use the Iterator Tools is to convert the array, Iterator, string, etc into an
IterableIterator.  This class provides a fluent interface all of the common operations.
For example:

```
use function Zicht\Itertools\iterable;

$result = iterable($vehicles)->filter('is_cool')->mapBy('id')->map('type');
var_dump($result)
// [5 => 'unicicle', 9 => 'car']

```

### Mapping
Mapping converts one collection into another collection of equal size.  Using `map` allows 
manipulation of the collection values while `mapBy` allows manipulation of the collection keys.
For example:

```
use function Zicht\Itertools\iterable;

// Use a custom closure to map the values
$getTitle = function ($value, $key) {
    return sprintf('%s with %s wheels', $value['type'], $value['wheels']);
};
$titles = iterable($vehicles)->map(getTitle);
var_dump($titles->toArray());
// ['car with 4 wheels', ..., 'car with 8 wheels']

// Use a helper string to map the values to a property or array index
$types = iterable($vehicles)->map('type');
var_dump($types->toArray());
// ['car', 'bike', 'unicicle', 'car']

// Use a helper string to map the keys to a property or array index 
$vehiclesById = iterable($vehicles)->mapBy('id');
var_dump(array_keys($vehiclesById->toArray()));
// [1, 2, 5, 9]
```

There are several common mapping closures available in mappings.php.  Calling these functions returns
a closure that can be passed to `map` and `mapBy`.  For example:
```
use function Zicht\Itertools\iterable;
use function Zicht\Itertools\mappings\length;

$lengths = iterable($words)->map(length());
var_dump($lengths->toArray());
// [6, 3, 4, 5, 9]
```

## Usage within Twig template
_todo_
