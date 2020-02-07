<?php
declare(strict_types=1);

namespace Php;

class UnlimitedBit implements Bit
{
    use UnlimitedBitTrait;

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
}
