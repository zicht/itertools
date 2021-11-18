# UPGRADE 2.X TO 3.0

[PHP](#php):
* [Repeat](#repeat)
* [Reductions](#reductions)
* [Mapping](#mapping)
* [Filtering](#filtering)

[Twig](#twig):
* [Filters](#filters)
* [Functions](#functions)


## PHP

### Repeat
`Itertools\repeat($object, $times)` is now only available as a fluent interface like `iterable($object)->repeat($object, $times)`.

### Reductions
The first argument of `->reduce()` is now a required closure.

#### Example:
```php
use function Zicht\Itertools\reductions\add;

$myIterable->reduce(add());
```
becomes:
```php
use Zicht\Itertools\util\Reductions;

$myIterable->reduce(Reductions::add());
```

#### Migrations:
```markdown
Old      | New
-------- | -------------------
add()    | Reductions::add()
chain()  | Reductions::chain()
join()   | Reductions::join()
max()    | Reductions::max()
min()    | Reductions::min()
mul()    | Reductions::mul()
sub()    | Reductions::sub()
```


### Mapping

#### Example:
```php
use Zicht\Itertools\mappings;
use function Zicht\Itertools\iterable;

iterable($example)->map(length());
```
becomes:
```php
use \Zicht\Itertools\util\Mappings;
use function Zicht\Itertools\iterable;

iterable($example)->map(Mappings::length());
```

#### Migrations:
```markdown
Old             | New
--------------- | ----------------------
cache()         | Mappings::cache()
constant()      | Mappings::constant()
json_decode()   | Mappings::jsonEncode()
json_encode()   | Mappings::jsonDecode()
key()           | Mappings::key()
length()        | Mappings::length()
lower()         | Mappings::lower()
lstrip()        | Mappings::lstrip()
random()        | Mappings::random()
rstrip()        | Mappings::rstrip()
select()        | Mappings::select()
string()        | Mappings::string()
strip()         | Mappings::strip()
type()          | Mappings::type()
upper()         | Mappings::upper()
```


### Filtering

#### Example:
```php
use namespace Zicht\Itertools\filters;

not($strategy);
```
becomes:
```php
use Zicht\Itertools\util\Filters;

Filters::not($strategy);
```

#### Migrations:
```markdown
Old       | New
--------- | -------------------
after()   | Filters::after()
before()  | Filters::before()
equals()  | Filters::equals()
in()      | Filters::in()
match()   | Filters::match()
not()     | Filters::not()
not_in()  | Filters::not(Filters::in())
type()    | Filters::type()
```


## Twig

### Filters

#### Example:
```twig
{{ my_iterable|first }}
```
becomes:
```twig
{{ my_iterable|it.first }}
```

#### Migrations:
```markdown
Old        | New
---------- | ----------
all        | it.all
any        | it.any
chain      | it.chain
collapse   | it.collapse
filter     | it.filter
filterby   | it.filter
first      | it.first
groupby    | it.groupBy
groupBy    | it.groupBy
group_by   | it.groupBy
last       | it.last
map        | it.map
mapby      | it.mapBy
mapBy      | it.mapBy
map_by     | it.mapBy
reduce     | it.reduce
reversed   | it.reversed
sorted     | it.sorted
sum        | it.reduce
unique     | it.unique
uniqueby   | it.unique
zip        | it.zip
```


### Functions

#### Example:
```twig
{{ my_iterable|last }}
```
becomes:
```twig
{{ my_iterable|it.last }}
```

#### Migrations:
```markdown
Old        | New
---------- | ----------
chain      | it.chain
first      | it.first
last       | it.last
reducing   | itr
mapping    | itm
filtering  | itf
```
