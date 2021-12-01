<?php
declare(strict_types=1);

namespace gdejong\AoC2021\Utils;

use UnexpectedValueException;

class File
{
    /**
     * @return array<array-key, int>
     */
    public static function convertFileToIntArray(string $filename, string $delimiter = PHP_EOL): array
    {
        $strings = self::convertFileToStringArray($filename, $delimiter);

        $output = [];
        foreach ($strings as $line) {
            if (!is_numeric($line)) {
                throw new UnexpectedValueException("Value " . var_export($line, true) . " is not numeric");
            }
            $output[] = (int)$line;
        }

        return $output;
    }

    public static function convertFileToStringArray(string $filename, string $delimiter = PHP_EOL): array
    {
        $input = self::getFileContents($filename);

        return explode($delimiter, $input);
    }

    public static function getFileContents(string $filename): string
    {
        $contents = file_get_contents($filename);
        if ($contents === false) {
            die("Failed to open input file: " . $filename);
        }

        return trim($contents, "\n" . PHP_EOL);
    }
}
