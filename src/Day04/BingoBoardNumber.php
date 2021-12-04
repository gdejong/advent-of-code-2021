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

    public function __toString(): string
    {
        $output = (string)$this->number;
        if ($this->drawn) {
            $output .= "!";
        } else {
            $output .= " ";
        }
        return str_pad($output, 4, " ", STR_PAD_LEFT);
    }
}
