<?php
declare(strict_types=1);

namespace gdejong\AoC2021\Day04;

use LogicException;

class Bingo
{
    public function part1(array $input): int
    {
        $numbers_drawn = array_map(static function ($value) {
            return (int)$value;
        }, preg_split('/,/', trim($input[0])));
        unset($input[0]);

        // initialize the boards
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

        foreach ($numbers_drawn as $drawn_number) {
            foreach ($boards as $board) {
                $board->markAsDrawn($drawn_number);

                if ($board->hasBingo()) {
                    return $board->sumUnmarkedNumbers() * $drawn_number;
                }
            }
        }

        throw new LogicException("failed to find a bingo");
    }
}
