<?php
declare(strict_types=1);

namespace gdejong\AoC2021\Day09;

class Point
{
    public function __construct(
        public int $x,
        public int $y,
        public int $value,
    )
    {
    }
}
