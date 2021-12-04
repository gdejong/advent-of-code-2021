<?php
declare(strict_types=1);

namespace gdejong\AoC2021\Day04;

class Bingo
{
    public function part1(array $input): int
    {
        $numbers_drawn = $input[0];
        unset($input[0]);

        $boards = [];

        $board = null;
        foreach ($input as $row) {
            if (empty($row)) {
                $board = new BingoBoard();
                $boards[] = $board;

                continue;
            }

            $board->addRow($row);
        }

        foreach ($boards as $board) {
            echo $board . PHP_EOL;
        }

        die;
    }
}
