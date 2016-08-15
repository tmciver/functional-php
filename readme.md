# Functional PHP

## Running Tests

This project uses [Composer](getcomposer.org) for dependency management and
[PHPUnit](phpunit.de) for unit testing.  PHPUnit requires access to autoloading
and the autoloading files must be first be generated by composer with the
following command:

    $ composer dump-autoload

Then, run the unit tests with

    $ phpunit

## Usage

Currently this library only supports Functors and Monads (Applicative is on the
way) and there are three data types that support them: `Maybe`, `Either` and
`MaybeT`.  If you're familiar with Functors and Monads from another language
such as Haskell, then this should be intuitive.

### Maybe

`Maybe` is intended to be used to represent the lack of a value.  Typically, you
would use `Maybe` when you might ordinarily return a null value from a
function.  Note that `Maybe` should not be used to represent an error condition;
that's what `Either` is for.

#### Maybe Example

The main data structure in PHP is the array.  But someone with a background in
functional programming might find this data structure a bit strange and the
functions that operate on it to behave unexpectedly.  For instance, the first
thing one might want to do with an array is to get the first element of the
array.  Surpisingly, there is not a single function that does this but an
implemenation that one can find online is the following:

```php
// $array initialized elsewhere
reset($array);
$firstElement = current($array);
```

So `current` returns the current element but that may not necessarily be the
first element which is why the call to `reset` is necessary.  But `reset`
mutates a pointer internally held by the array and a functional programmer has
an expectation that their data structures are not going to be mutated out from
under them.  Let's see if we can do better.

A function to get the first element of an array or list is typically called
`head`.  In Haskell calling `head` on an empty list is an error and halts the
program if not handled appropriately but we can do better in this respect as
well.  Our version of `head` will return a `Maybe`.

```php
function head($array) {
   if (is_array($array)) {
      if (count($array) > 0) {
	     $vals = array_values($array);
	     $h = Maybe::fromValue($array[0]);
	  } else {
	     $h = Maybe::nothing();
	  }
   } else {
      $h = Maybe::nothing();
   }

   return $h;
}
```

When given a non-empty array, the above function will return `Just($v)` where
`$v` is the first value of the array argument.  It will return `Nothing` in all
other cases.  See the file `test/Maybe/HeadTest.php` for examples of using this
function.

#### Maybe Functor

Functors are usually defined as things that can be mapped over.  Some may
naively think that lists/arrays are the only data structures that can be mapped
over but this is not the case.  Lots of things can be Functors and this includes
`Maybe`.

So what could we do with the `head` function that was defined above?  Well we
could map the value we get over a regular function like so:

```php
$a = ['apples', 'oranges', 'bananas'];
$maybeUppercaseOfFirstElement = head($a)->map('strtoupper');
```

In this case `$maybeUppercaseOfFirstElement` would be `Just('APPLES')`.  But if
`$a` had been an empty array, then it would have been `Nothing()` and the
`strtoupper` function would never have been run.  You can also chain `map`s:

```php
$a = ['apples', 'oranges', 'bananas'];
$maybeUppercaseOfFirstLetterOfFirstElement = head($a)->map('strtoupper')
                                                     ->map(function ($str) {
													    return substr($str, 0, 1);
													 });
```

If you can forgive the very long but descriptive name,
`$maybeUppercaseOfFirstLetterOfFirstElement` would be `Just('A')` in this case
(it still has that value if you can't forgive it).  There are a couple of things
to note here.  First, `map` takes a `callable`.  In PHP `callable`s take
several forms but one of them is a string and in the first call to `map`, I
passed in the string version of a built-in PHP function.  In the second case I
pass in an anonymous function, also a `callable`.

Second, `callable`s passed into `map` must be functions of one argument and
that argument will be the value _wrapped_ in the `Maybe`.  Third, the value
returned by this function will _automatically_ be wrapped back up in a `Maybe`.
So the result of calling `map` on a `Maybe` is again a `Maybe` which is what
allows us to chain calls to `map` this way.

#### Maybe Monad

Monad is similar to Functor.  It is implemented using the `Monad` interface
which also contains only a single method, namely `flatMap`.  But whereas `map`
takes a _normal_ function, `flatMap` takes a function that returns a `Monad` of the
same type on which `flatMap` is currently being called.

For example, say we have an integer contained in a `Just`:

```php
use TMciver\Functional\Just;

$maybeAnInt = Maybe::fromValue(1);
```

and we want to apply the following function to the contained integer:

```php
function maybeAddOne($i) {
    if ($i % 2 == 0) { // is even
	    $maybeVal = Maybe::fromValue($i + 1);
	} else {
	    $maybeVal = Maybe::nothing();
	}

    return $maybeVal;
}
```

(note that this function expects an integer argument - not an integer wrapped in
a Maybe).  Then you simply do

```php
$maybeAnIntPlusOne = $maybeAnInt->flatMap(function($j) {
	return maybeAddOne($j);
});
```

Note that `flatMap` can be called with any `callable` so the above could also have
been written:

```php
$maybeAnIntPlusOne = $maybeAnInt->flatMap('maybeAddOne');
```

See
[PHP's documentation on `callable`](http://php.net/manual/en/language.types.callable.php)
for more info.  If calling a function using a string seems strange, good; it
*is* strange! :)

### Either

TBD

### MaybeT

TBD

### Applicative

There currently exists an `Applicative` interface but it contains no methods.
Applicative functionality will be added in the future.
