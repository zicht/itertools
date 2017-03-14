# Change Log
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/)
and this project adheres to [Semantic Versioning](http://semver.org/).

## [Unreleased]
Nothing so far

## 1.0
The 1.0 version was short lived, it had one big flaw that was fixed in
2.0.  1.0 has not been, and should not be, used in production code.

## 1.2.0 - 2015-08-28
- groupby now also sorts by default
- fixes groupby unittests after adding $sort parameter

## 1.3.0 - 2015-08-28
- adds revered
- rename SortIterator to SortedIterator
- adds stable sorting (i.e. items with the same sorting value retain their order)

## 1.4.0 - 2015-10-30
- adds ArrayAccess to GroupedIterator
- adds support for doctrine PersistentCollection
- consider any doctrine collection to be iterable
- add toArray method
- adds couting to ChainIterator

## 1.4.2 - 2015-11-03
- implements Countable interface for MapIterator

## 1.4.3 - 2015-11-03
- adds a few toArray methods

## 1.5.0 - 2016-02-10
- renamed 'keyCallback' to 'mapBy', added 'select()' and internally renamed 'mixedToKeyStrategy' to 'mixedToValueGetter'
- adds FilterIterator::toArray()
- adds Countable interface to FilterIterator
- adds toArray to groupby iterator
- implemented array access

## 2.0
The primary goal of version 2.0 was a different way of handling
keys in a sequence.  Version 1.0 handled sequences as Python would, i.e.
a sequence of values.  However, php iterators have both a value and
a key assigned to every item in the sequence, version 2.0 takes
this into account.

## 2.3.0 - 2016-05-11
- the MapIterator will now keep the keys of the input iterator
- adds unit tests for new MapIterator behavior where it keeps the keys working properly
- Better feedback when an assert fails
- the closure is no longer required for the filter iterator
- adds the reduce operator
- added temp var to support 5.4
- Summary: adds tests and functionality for keeping keys while iterating
- Summary: Possible key strategy fix for groupby and WIP for sorted
  
  Need to get the key strategy for sorted fixed before we can verify
  that groupby works properly as it heavily depends on sorted.

- Summary: fixes key strategy for sorted and groupby
- Summary: enable and fix test with duplicate groups
- adds __debugInfo magic method to all applicable iterators
- adds unique and uniqueBy
- small fix in the groupby iterator debug info
- fix iterator inception
- adds any and all
- add test for mixedToIterator
- adds __length__ to the dump
- MapIterator now provides both iterator keys and values to the callbacks
- update documentation
- implemented countable in to the SortedIterator
- add doctrine/collections dependency
- check all tests that they properly check for the value of keys
- fixes syntax error

## 2.3.1 - 2016-05-20
- adds traits for countable and __debvugInfo and tests for countable
- bugfix: UniqueIterator should forget the items it has seen on rewind.
- When mixedToValueGetter gets null it will return a closure that behaves as an identity function
- move ArrayAccess methods to ArrayAccessTrait
- add SliceIterator
- fixes bug in SliceIterator... should also check if the InnerIterator is still valid
- add negative indexes to SliceIterator

## 2.4.0 - 2016-05-31
- interperate null as an empty list

## 2.5.0 - 2016-06-15
- the SortedIterator and GroupbyIterator now call their closure with both value and key

## 2.5.1 - 2016-06-15
- MapIterator should allow ArrayAccess

## 2.5.2 - 2016-06-22
- fixes bug where UniqueFilter whould report an incorrect length

## 2.5.3 - 2016-06-23
- fixes a bug where AccumulateIterator would call current on its inner iterator while this inner iterator was not valid

## 2.6.0 - 2016-06-23
- move the reduction closures to their own Reductions class
- adds function first

## 2.7.0 - 2016-06-28
- dev branch for itertool chaining
- docs
- move method first
- adds unittests

## 2.7.1 - 2016-06-29
- Adds chaining trait

## 2.8.0 - 2016-06-30
- adds unittests
- add twig extension file

## 2.8.1 - 2016-06-30
- rename KeyCallback to MapBy
- bugfix and test for ReversedIterator
- ignore build and vendor directory
- adds test to cover invalid number of arguments
- adds tests for (deprecated) uniqueBy
- unittests for any function
- unittests for all function
- fix in any test

## 2.8.2 - 2016-08-01
- Add Mapppings util class and twig functions
- Documentation
- Move conversions to Conversions util class

## 2.8.3 - 2016-08-04
- Move mixedToClosure to Conversions class
- Code cleanup

## 2.8.4 - 2016-08-08
- Gives ArrayAccess to ChainIterator

## 2.8.5 - 2016-08-11
- GroupbyIterator should be able to chain
- Sorted should allow array access
- CS
  Prefer to call base php classes using \ClassName instead of having a
  use statement at the top of the file.  Less lines of code is generally
  better.

## 2.8.6 - 2016-08-19
- Adds chaining trait to UniqueIterator

## 2.8.7 - 2016-08-23
- Split all traits into separate files

## 2.8.8 - 2016-08-23
- Move util classes to functions
  
  The Conversions, Mappings, and Reductions classes were effectively
  namespaces.  These have been removed in favor of using actual
  namespaces.

## 2.8.9 - 2016-08-29
- Fixes reduce trait arguments

## 2.8.10 - 2016-08-29
- Fixes filter argument order.

## 2.8.11 - 2016-08-31
- null now results in the identity function, which has the same result.
- Renamed $keyStrategy to $strategy
- Prevent unnecessary function wrap
- Provide filter closures with key and value

## 2.8.12 - 2016-09-01
- Adds reversed filter to twig extension

## 2.8.13 - 2016-09-01
- Add length and Doc-comments

## 2.8.14 - 2016-09-05
- Compatability fix for PHP 5.4
  
  Note: Prior to PHP 5.5, empty() only supports variables; anything else
  will result in a parse error. In other words, the following will not
  work: empty(trim($name)). Instead, use trim($name) == false.

## 2.8.15 - 2016-09-26
- Adds in and not_in filters

## 2.8.16 - 2016-10-03
- Update Readme file
- Adds function iterable

## 2.8.17 - 2016-11-02
- Use __get method to retrieve value
- Adds documentation

## 2.8.18 - 2016-11-09
- Documentation and code styling
- Additional Zip tests
- Adds key and select mapping
- Optimize SortedIterator
  
  We only need to call the value getter once per element in the iterable.

- Adds a random mapping used to sort items randomly
- The twig extension was using deprecated methods
- Fix namespace in unittest

## 2.8.19 - 2016-11-16
- Adds $STRICT to filters\in and filters\not_in
- Adds filters\equals
- Fixes GetterTrait
  
  instanceof Trait always returns false...

## 2.8.20 - 2016-11-24
- Moves the toArray behavior to a trait
- Adds {Items|Keys|Values}Trait classes
- Use {Items|Keys|Values}Trait classes
- Adds {Items|Keys|Values}Trait tests
- Bugfix for select with flatten
  
  The select function will, when flatten is enabled, return an array with
  all values of the iterable.  This can now be done using
  iterable->values().
  
  Moreover, the select function did not properly handle iterables that had
  duplicate keys (because of the iterator_to_array implementation).  This
  is fixed properly when using the iterable->values() call.

## 2.8.21 - 2016-11-24
- Adds the GetterTrait to the GroupByIterator

## 2.8.23 - 2016-12-20
- Fixes bug in slice combined with infinite iterator
- Adds chain reduction
- Add unittests for mappings
- Coverage tests for select
- Coverage tests for filterBy
- Remove unnecessary iterator wrapping
- Add type mapping
- Add documentation
- Fixes bug in filters in and not_in
- Adds unit tests
- Fixes bug in get_reduction
- add license; fix composer warning
- Use neutral words in examples
- Made reductions\chain behavior stateless
  
  Before reductions\chain is released, I feel this change is needed to
  ensure that the reduction is stateless.
  
  This also fixes cases where the data list that is being iterated over
  is only a single element long.  This would result in that single
  element being returned (as per reduce behavior).  While we expect a
  ChainIterator as the reduce result.

- add parent::key() in callback
- Add unittest to check $key is passed to closure

## 2.8.24 - 2017-01-11
- Code cleanup
- Deprecated filters should be marked deprecated
- Move get_mapping and get_reduction to the twig extension
- Fixes incorrect example
- Twig extension cleanup
- add maintainer
- Unit tests for twig extension
- Adds mappings/lower and mappings/upper

## 2.8.25 - 2017-02-16
- Remove usage of Foo::class
  
  Foo::class was introduced in php 5.5.  We do not need, but it is nice
  to be, compatible with older php versions.

- Enable scrutinizer
- Cleanup/make compatible with sqruitinizer
- Update README.md
- Adds unit tests for conversions
- Fixes bug in KeyValuePair
- Adds unit tests for KeyValuePair
- Add coverage for Traits
- Fixes documentation
- Fixes unused parameter name
- Propagate key property for filters
- Zip iterator should provide keys(), values(), and items()
- Fixes inconsistent API

## 2.8.26 - 2017-02-27
- $strategy can always be null, string, or \Closure
- Define $length even though it is not needed
- Defensive programming, ensure $this is \Traversable
- Do not use deprecated function
- solves major issues reported by scrutinizer
