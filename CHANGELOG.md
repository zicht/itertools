# Change Log
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/)
and this project adheres to [Semantic Versioning](http://semver.org/).

## [Unreleased]
### Added|Changed|Deprecated|Removed|Fixed|Security
Nothing so far

## 2.12.3 - 2020-02-14
### Fixed
- Small code improvement on how `before` and `after` convert ISO date strings.

## 2.12.2 - 2020-01-31
### Fixed
- The `before` and `after` filter helpers will now convert ISO date string when the expected
  value is a `DateTimeInterface`.

## 2.12.1 - 2020-01-08
### Fixed
- Linter fixes.

## 2.12.0 - 2020-01-08
### Added
- Added `cache` and `string` mapping helper.
- Added `before` and `after` filter helpers.

## 2.11.0 - 2019-04-29
### Added
- Added `CollapseIterator` usable from php or twig.

## 2.10.14 - 2019-04-23
### Fixed
- The `select` mapper now accepts either an array or an object as its first parameter,
  when an object is given then`select` will create an array with objects, when an array is
  given then `select` will create an array with arrays, as before.

## 2.10.13 - 2018-12-07
### Fixed
- Update `composer.lock`.
- Update code to conform with `zicht/standards-php` 3.4.0.

## 2.10.12 - 2018-11-12
### Fixed
- `ChainTrait`, `MapTrait`, and `ZipTrait` would indicate that they throw `\ReflectionException`, 
  while this never happens.  This caused other code to give unnecessary warnings. 

## 2.10.11 - 2018-11-07
### Fixed
- Changed the auto loader to only include the src directory.

## 2.10.10 - 2018-07-02
### Added
- Support for Twig v2.

## 2.10.9 - 2018-06-14
### Fixed
- The `values`, `toArray`, and `items` traits will now work recursively.
  This is useful when you have a nested iterator and also iterate over
  those iterators in a nested way (php does not properly support this).

  In the below example, the `.values` is used to created a *nested* array, i.e.
  both the `GroupByIterator` and the nested `GroupedIterator` are replaced by an
  array, this allows multiple iterations to occur at the same time.

  ```twig
    {% for grouped in items|group_by('EventId')|sorted('first.EventDateTime').values %}
       {% set first_item = grouped|first %}
       ...
    {% endfor %}
  ```

## 2.10.8 - 2017-12-14
### Added
- Added mappers `json_encode` and `json_decode`.

## 2.10.7 - 2017-11-09
### Fixed
- Reducing using `min` or `max` now supports `\DateTime` instances.

## 2.10.6 - 2017-08-31
### Fixed
- Added missing `$sort` parameter to the `group_by` twig filter extension.

## 2.10.5 - 2017-08-04
### Added
- Added a new filter helper `filters\match`.

## 2.10.4 - 2017-07-31
### Changed
- Calling `values()` on `GroupByIterator` will return the `values()` of every
  item in the group, instead of the `GroupedIterator` instances.

## 2.10.3 - 2017-06-30
### Added
- Added `$discardEmptyContainer` parameter to `mappings/select`.

## 2.10.2 - 2017-06-22
### Added
- Added `not` filter to `filters.php`
### Deprecated
- We should no longer use `not_in(...)` and instead use `not(in(...))`.

## 2.10.1 - 2017-06-21
### Added
- Added `$strategy` parameter to `mappings/select`.
- Added `$discardNull` parameter to `mappings/select`.

## 2.10.0 - 2017-06-01
### Added
- DifferenceTrait, this allows a call like $a->difference($b).
- IntersectionTrait, this allows a call like $a->intersection($b).
- first_key and FirstTrait::firstKey, allowing to get the key of the first element in the iterable.
- last_key and LastTrait::lastKey, allowing to get the key of the last element in the iterable.
### Changed
- Interface definitions for every trait, allowing for optimizations by not having to convert certain
  instances when it is known to be of the correct type already.
- InfiniteIterableInterface and InfiniteIterableTrait: these represent all Interfaces and traits
  that apply to an infinite iterable.
- FiniteIterableInterface and FiniteIterableTrait: these represent all Interfaces and traits
  that apply to a finite iterable.

## 2.9.0 - 2017-04-04
### Added
- $strategy will use twig strategy when getting values, i.e.
  1. array keys
  2. object public property
  3. object public method
  4. object public method with 'get' prefixed [NEW]
  5. object public method with 'is' prefixed [NEW]
  6. object public method with 'has' prefixed [NEW]
  7. object public method __get
  8. otherwise, returns null

## 2.8.26 - 2017-02-27
### Changed
- $strategy can always be null, string, or \Closure

## 2.8.25 - 2017-02-16
### Added
- ZipIterator now provided keys(), values(), and items()
### Changes
- Propagate key property for filters
- Remove usage of Foo::class

  Foo::class was introduced in php 5.5.  We do not need, but it is nice
  to be, compatible with older php versions.
### Fixed
- Fixes bug in KeyValuePair

## 2.8.24 - 2017-01-11
### Added
- Adds mappings/lower and mappings/upper
### Changes
- Move get_mapping and get_reduction to the twig extension

## 2.8.23 - 2016-12-20
### Added
- Adds chain reduction
- Adds type mapping
- Adds parent::key() in callback
### Changed
- Made reductions\chain behavior stateless

  Before reductions\chain is released, I feel this change is needed to
  ensure that the reduction is stateless.

  This also fixes cases where the data list that is being iterated over
  is only a single element long.  This would result in that single
  element being returned (as per reduce behavior).  While we expect a
  ChainIterator as the reduce result.
### Fixed
- Fixes bug in slice combined with infinite iterator
- Fixes bug in filters in and not_in
- Fixes bug in get_reduction

## 2.8.21 - 2016-11-24
### Added
- Adds the GetterTrait to the GroupByIterator

## 2.8.20 - 2016-11-24
### Added
- Adds {Items|Keys|Values}Trait classes
### Fixes
- select with flatten enabled now behaves as follows:

  The select function will, when flatten is enabled, return an array with
  all values of the iterable.  This can now be done using
  iterable->values().

  Moreover, the select function did not properly handle iterables that had
  duplicate keys (because of the iterator_to_array implementation).  This
  is fixed properly when using the iterable->values() call.

## 2.8.19 - 2016-11-16
### Added
- Adds $STRICT to filters\in and filters\not_in
- Adds filters\equals
### Fixed
- Fixes GetterTrait: instanceof Trait always returns false

## 2.8.18 - 2016-11-09
### Added
- Adds key and select mapping
- Adds a random mapping used to sort items randomly
### Changed
- Optimize SortedIterator: we only need to call the value getter once
  per element in the iterable.  Before, the value getter was called
  multiple times per element

## 2.8.17 - 2016-11-02
### Changed
- Use __get method to retrieve value

## 2.8.16 - 2016-10-03
### Added
- Adds function iterable

## 2.8.15 - 2016-09-26
### Added
- Adds in and not_in filters

## 2.8.14 - 2016-09-05
### Fixed
- Compatability fix for PHP 5.4

  Note: Prior to PHP 5.5, empty() only supports variables; anything else
  will result in a parse error. In other words, the following will not
  work: empty(trim($name)). Instead, use trim($name) == false.

## 2.8.13 - 2016-09-01
### Added
- Add length

## 2.8.12 - 2016-09-01
### Added
- Adds reversed filter to twig extension

## 2.8.11 - 2016-08-31
### Added
- Provide filter closures with key and value
### Changed
- null now results in the identity function, which has the same result.
- Renamed $keyStrategy to $strategy

## 2.8.10 - 2016-08-29
### Fixed
- Fixes filter argument order.

## 2.8.9 - 2016-08-29
### Fixed
- Fixes reduce trait arguments

## 2.8.8 - 2016-08-23
### Changed
- Move util classes to functions

  The Conversions, Mappings, and Reductions classes were effectively
  namespaces.  These have been removed in favor of using actual
  namespaces.

## 2.8.7 - 2016-08-23
### Changed
- Split all traits into separate files

## 2.8.6 - 2016-08-19
### Added
- Adds chaining trait to UniqueIterator

## 2.8.5 - 2016-08-11
### Added
- GroupbyIterator should be able to chain
- Sorted should allow array access

## 2.8.4 - 2016-08-08
### Added
- Gives ArrayAccess to ChainIterator

## 2.8.3 - 2016-08-04
### Changed
- Move mixedToClosure to Conversions class

## 2.8.2 - 2016-08-01
### Added
- Add Mapppings util class and twig functions
### Changed
- Move conversions to Conversions util class

## 2.8.1 - 2016-06-30
### Added
### Changed
- rename KeyCallback to MapBy
### Fixed
- bugfix for ReversedIterator

## 2.8.0 - 2016-06-30
### Added
- add twig extension file

## 2.7.1 - 2016-06-29
### Added
- Adds chaining trait

## 2.7.0 - 2016-06-28
### Added
- dev branch for itertool chaining
- move method first

## 2.6.0 - 2016-06-23
### Added
- adds function first
### Changed
- move the reduction closures to their own Reductions class

## 2.5.3 - 2016-06-23
### Fixed
- fixes a bug where AccumulateIterator would call current on its inner iterator while this inner iterator was not valid

## 2.5.2 - 2016-06-22
### Fixed
- fixes bug where UniqueFilter would report an incorrect length

## 2.5.1 - 2016-06-15
### Added
- MapIterator now allows ArrayAccess

## 2.5.0 - 2016-06-15
### Changed
- the SortedIterator and GroupbyIterator now call their closure with both value and key

## 2.4.0 - 2016-05-31
### Changed
- interperate null as an empty list

## 2.3.1 - 2016-05-20
### Added
- adds traits for countable and __debugInfo
- add SliceIterator
### Changed
- When mixedToValueGetter gets null it will return a closure that behaves as an identity function
- move ArrayAccess methods to ArrayAccessTrait
### Fixed
- UniqueIterator should forget the items it has seen on rewind

## 2.3.0 - 2016-05-11
### Added
- adds the reduce operator
- adds __debugInfo magic method to all applicable iterators
- adds unique and uniqueBy
- adds any and all
- implemented countable in to the SortedIterator
### Changed
- adds functionality for keeping keys while iterating
- the closure is no longer required for the filter iterator
- the MapIterator will now keep the keys of the input iterator
- MapIterator now provides both iterator keys and values to the callbacks
### Fixed
- added temp var to support 5.4
- fixes key strategy for sorted and groupby
- fix iterator inception

## 2.0
The primary goal of version 2.0 was a different way of handling
keys in a sequence.  Version 1.0 handled sequences as Python would, i.e.
a sequence of values.  However, php iterators have both a value and
a key assigned to every item in the sequence, version 2.0 takes
this into account.

## 1.5.0 - 2016-02-10
### Added
- adds FilterIterator::toArray()
- adds Countable interface to FilterIterator
- adds toArray to groupby iterator
- implemented array access
### Changed
- renamed 'keyCallback' to 'mapBy', added 'select()' and internally renamed 'mixedToKeyStrategy' to 'mixedToValueGetter'

## 1.4.3 - 2015-11-03
### Added
- adds a few toArray methods

## 1.4.2 - 2015-11-03
### Added
- implements Countable interface for MapIterator

## 1.4.0 - 2015-10-30
### Added
- adds ArrayAccess to GroupedIterator
- adds support for doctrine PersistentCollection
- adds couting to ChainIterator
### Changed
- consider any doctrine collection to be iterable

## 1.3.0 - 2015-08-28
### Added
- adds revered
- adds stable sorting (i.e. items with the same sorting value retain their order)
### Changed
- rename SortIterator to SortedIterator

## 1.2.0 - 2015-08-28
### Changed
- groupby now also sorts by default

## 1.0
The 1.0 version was short lived, it had one big flaw that was fixed in
2.0.  1.0 has not been, and should not be, used in production code.
