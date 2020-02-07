<?php
declare(strict_types=1);

namespace Php;

final class Bit
{
    /** Decimal number for bit flags. */
    private int $value;

    public function __construct(int $value = 0)
    {
        $this->value = $value;
    }

    public function asInt(): int
    {
        return $this->value;
    }

    public function asStr(): string
    {
        return decbin($this->value);
    }

    /**
     * @param int|int[] $digits
     */
    public function on($digits): self
    {
        if (is_int($digits)) {
            $digits = [$digits];
        }

        $new = clone $this;
        foreach ($digits as $digit) {
            $new->value |= (1 << $digit);
        }
        return $new;
    }

    /**
     * @param int|int[] $digits
     */
    public function off($digits)
    {
        if (is_int($digits)) {
            $digits = [$digits];
        }

        $new = clone $this;
        foreach ($digits as $digit) {
            $new->value &= ~(1 << $digit);
        }
        return $new;
    }
}

