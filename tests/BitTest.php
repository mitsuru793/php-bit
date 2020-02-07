<?php
declare(strict_types=1);

namespace Php;

use Helper\TestBase;

final class BitTest extends TestBase
{
    /**
     * @dataProvider constructProvider
     */
    public function testConstruct($init, int $expectedInt, string $expectedStr)
    {
        $bit = new Bit($init);
        $this->assertSame($expectedInt, $bit->asInt());
        $this->assertSame($expectedStr, $bit->asStr());
    }

    public function constructProvider()
    {
        return [
            'Integer 0.' => [
                'init' => 0,
                'expectedInt' => 0,
                'expectedStr' => '0',
            ],
            'String 0' => [
                'init' => '0',
                'expectedInt' => 0,
                'expectedStr' => '0',
            ],
            'Complex integer' => [
                'init' => 9,
                'expectedInt' => 9,
                'expectedStr' => '1001',
            ],
            'Complex string' => [
                'init' => '1001',
                'expectedInt' => 9,
                'expectedStr' => '1001',
            ],
            'First 0 is ignored.' => [
                'init' => '0010',
                'expectedInt' => 2,
                'expectedStr' => '10',
            ],
        ];
    }

    /**
     * @dataProvider onProvider
     */
    public function testOn(int $init, $onDigits, int $expectedInt, string $expectedStr)
    {
        $bit = new Bit($init);
        $bit = $bit->on($onDigits);
        $this->assertSame($expectedInt, $bit->asInt());
        $this->assertSame($expectedStr, $bit->asStr());
    }

    public function onProvider()
    {
        return [
            'Argument as digit starts 0.' => [
                'init' => 0,
                'onDigits' => 0,
                'expectedInt' => 1,
                'expectedStr' => '1',
            ],
            'Argument can be array.' => [
                'init' => 0,
                'onDigits' => [1, 3],
                'expectedInt' => 10,
                'expectedStr' => '1010',
            ],
            'Digit 0 remains.' => [
                'init' => 1,
                'onDigits' => 3,
                'expectedInt' => 9,
                'expectedStr' => '1001',
            ],
            'Already on flags do not change.' => [
                'init' => 9, // '1001'
                'onDigits' => [0, 1],
                'expectedInt' => 11,
                'expectedStr' => '1011',
            ],
        ];
    }

    /**
     * @dataProvider offProvider
     */
    public function testOff(int $init, $onDigits, int $expectedInt, string $expectedStr)
    {
        $bit = new Bit($init);
        $bit = $bit->off($onDigits);
        $this->assertSame($expectedInt, $bit->asInt());
        $this->assertSame($expectedStr, $bit->asStr());
    }

    public function offProvider()
    {
        return [
            'Argument as digit starts 0.' => [
                'init' => 1,
                'onDigits' => 0,
                'expectedInt' => 0,
                'expectedStr' => '0',
            ],
            'Argument can be array.' => [
                'init' => 9, // '1001'
                'onDigits' => [0, 3],
                'expectedInt' => 0,
                'expectedStr' => '0',
            ],
            'Digit 0 remains.' => [
                'init' => 9, // '1001'
                'onDigits' => 0,
                'expectedInt' => 8,
                'expectedStr' => '1000',
            ],
            'Already on flags do not change.' => [
                'init' => 9, // '1001'
                'onDigits' => [0, 1],
                'expectedInt' => 8,
                'expectedStr' => '1000',
            ],
        ];
    }
}
