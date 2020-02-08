# PHP Bit

```php
// construct
$bit = new UnlimitedBit(2);
$bit = new UnlimitedBit('0010');

assert($bit->asInt() === 2);
assert($bit->asSTr() === '10');

// immutable
assert($bit->on(4)->asStr() === '1010');
assert($bit->asStr() === '10');

assert($bit->on(4)->off(2)->asStr() === '1000');
```

Both of the followings implement interface 'Bit'.

* UnlimitedBit
* LimitedBit
