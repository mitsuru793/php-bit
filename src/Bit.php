<?php
declare(strict_types=1);

namespace Php;

interface Bit
{
    public function asInt(): int;

    public function asStr(): string;

    /**
     * @param int|int[] $digits
     * @return static
     */
    public function on($digits);

    /**
     * @param int|int[] $digits
     * @return static
     */
    public function off($digits);

    /**
     * @param int|string|static $other Not digit, but bit value. 5 is '101'
     * @return static
     */
    public function and($other);

    /**
     * @param int|string|static $other Not digit, but bit value. 5 is '101'
     * @return static
     */
    public function or($other);
}
