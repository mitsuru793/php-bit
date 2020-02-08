<?php
declare(strict_types=1);

use Mitsuru793\Bit\UnlimitedBit;

require_once __DIR__ . '/../vendor/autoload.php';

// construct
$bit = new UnlimitedBit(2);
$bit = new UnlimitedBit('0010');

assert($bit->asInt() === 2);
assert($bit->asSTr() === '10');

// immutable
assert($bit->on(4)->asStr() === '1010');
assert($bit->asStr() === '10');

assert($bit->on(4)->off(2)->asStr() === '1000');
