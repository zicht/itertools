<?php

namespace Zicht\Itertools\lib;

use ArrayIterator;
use Closure;
use Countable;
use Iterator;
use IteratorIterator;
use Zicht\Itertools\lib\Traits\CountableTrait;
use Zicht\Itertools\lib\Traits\DebugInfoTrait;
use Zicht\Itertools\lib\Traits\ItertoolChainingTrait;

class SortedIterator extends IteratorIterator implements Countable
{
    use CountableTrait;
    use DebugInfoTrait;
    use ItertoolChainingTrait;

    public function __construct(Closure $func, Iterator $iterable, $reverse = false)
    {
        $data = [];
        foreach ($iterable as $key => $value) {
            $data []= array('key' => $key, 'value' => $value);
        }

        if ($reverse) {
            $cmp = function ($a, $b) use ($func) {
                $keyA = call_user_func($func, $a['value'], $a['key']);
                $keyB = call_user_func($func, $b['value'], $b['key']);
                return $keyA == $keyB ? 0 : ($keyA < $keyB ? 1 : -1);
            };
        } else {
            $cmp = function ($a, $b) use ($func) {
                $keyA = call_user_func($func, $a['value'], $a['key']);
                $keyB = call_user_func($func, $b['value'], $b['key']);
                return $keyA == $keyB ? 0 : ($keyA < $keyB ? -1 : 1);
            };
        }

        $this->mergesort($data, $cmp);

        parent::__construct(new ArrayIterator($data));
    }

    public function key()
    {
        return $this->getInnerIterator()->current()['key'];
    }

    public function current()
    {
        return $this->getInnerIterator()->current()['value'];
    }

    public function toArray()
    {
        return iterator_to_array($this);
    }

    /**
     * As the manual says, "If two members compare as equal, their
     * order in the sorted array is undefined."  This means that the
     * sort used is not "stable" and may change the order of elements
     * that compare equal.
     *
     * Sometimes you really do need a stable sort. For example, if you
     * sort a list by one field, then sort it again by another field,
     * but don't want to lose the ordering from the previous field.
     * In that case it is better to use usort with a comparison
     * function that takes both fields into account, but if you can't
     * do that then use the function below. It is a merge sort, which
     * is guaranteed O(n*log(n)) complexity, which means it stays
     * reasonably fast even when you use larger lists (unlike
     * bubblesort and insertion sort, which are O(n^2)).
     *
     * http://www.php.net/manual/en/function.usort.php#38827
     *
     * @param array $array
     * @param Closure $func
     */
    protected function mergesort(array &$array, Closure $cmp_function)
    {
        // Arrays of size < 2 require no action.
        if (count($array) < 2)
            return;

        // Split the array in half
        $halfway = count($array) / 2;
        $array1 = array_slice($array, 0, $halfway);
        $array2 = array_slice($array, $halfway);

        // Recurse to sort the two halves
        $this->mergesort($array1, $cmp_function);
        $this->mergesort($array2, $cmp_function);

        // If all of $array1 is <= all of $array2, just append them.
        if (call_user_func($cmp_function, end($array1), $array2[0]) < 1) {
            $array = array_merge($array1, $array2);
            return;
        }

        // Merge the two sorted arrays into a single sorted array
        $array = array();
        $ptr1 = $ptr2 = 0;
        while ($ptr1 < count($array1) && $ptr2 < count($array2)) {
            if (call_user_func($cmp_function, $array1[$ptr1], $array2[$ptr2]) < 1) {
                $array[] = $array1[$ptr1++];
            }
            else {
                $array[] = $array2[$ptr2++];
            }
        }

        // Merge the remainder
        while ($ptr1 < count($array1)) $array[] = $array1[$ptr1++];
        while ($ptr2 < count($array2)) $array[] = $array2[$ptr2++];
        return;
    }
}
