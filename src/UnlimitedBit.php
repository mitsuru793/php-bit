<?php
declare(strict_types=1);

namespace Php;

class UnlimitedBit implements Bit
{
    /** Decimal number for bit flags. */
    private int $value;

    /**
     * @param int|string
     */
    public function __construct($value = 0)
    {
        if (is_string($value)) {
            $value = bindec($value);
        }
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

    public function on($digits)
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

    public function and($other)
    {
        if (is_string($other)) {
            $other = bindec($other);
        } elseif ($other instanceof Bit) {
            $other = $other->asInt();
        }

        $new = clone $this;
        $new->value &= $other;
        return $new;
    }

    public function or($other)
    {
        if (is_string($other)) {
            $other = bindec($other);
        } elseif ($other instanceof Bit) {
            $other = $other->asInt();
        }

        $new = clone $this;
        $new->value |= $other;
        return $new;
    }
}

