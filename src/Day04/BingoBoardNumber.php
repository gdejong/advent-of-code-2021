<?php
declare(strict_types=1);

namespace gdejong\AoC2021\Day04;

class BingoBoardNumber
{
    public int $number;
    public bool $drawn = false;

    public function __construct(int $number)
    {
        $this->number = $number;
    }
}
