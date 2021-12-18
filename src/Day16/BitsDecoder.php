<?php
declare(strict_types=1);

namespace gdejong\AoC2021\Day16;

use LogicException;

class BitsDecoder
{
    private array $decoded_packet_values = [];
    private int $version_sum = 0;

    public function part1(string $hex): int
    {
        $hex = trim($hex);
        $binary = "";
        $input_length = strlen($hex);
        for ($i = 0; $i < $input_length; $i++) {
            $binary .= match ($hex[$i]) {
                "0" => "0000",
                "1" => "0001",
                "2" => "0010",
                "3" => "0011",
                "4" => "0100",
                "5" => "0101",
                "6" => "0110",
                "7" => "0111",
                "8" => "1000",
                "9" => "1001",
                "A" => "1010",
                "B" => "1011",
                "C" => "1100",
                "D" => "1101",
                "E" => "1110",
                "F" => "1111",
            };
        }

        $this->decodeAll($binary);

        return $this->version_sum;
    }

    private function decodeAll(string $binary): void
    {
        while ($binary) {
            // If we only have zeroes left, we are done
            if (bindec($binary) === 0) {
                break;
            }

            $binary = $this->decodeSinglePacket($binary);
        }
    }

    private function decodeSinglePacket(string $binary): string
    {
        // Every packet begins with a standard header: the first three bits encode the packet version
        $packet_version = $this->readBinaryCharsAsInt($binary, 3);

        $this->version_sum += $packet_version;

        // And the next three bits encode the packet type ID
        $packet_type_id = $this->readBinaryCharsAsInt($binary, 3);

        // Packets with type ID 4 represent a literal value. Literal value packets encode a single binary number.
        // To do this, the binary number is padded with leading zeroes until its length is a multiple of four bits,
        // and then it is broken into groups of four bits. Each group is prefixed by a 1 bit except the last group,
        // which is prefixed by a 0 bit. These groups of five bits immediately follow the packet header.
        if ($packet_type_id === 4) {
            $literal_value_in_binary = "";
            while (true) {
                $group_type = $this->readBinaryCharsAsInt($binary, 1);
                $literal_value_in_binary .= $this->readBinaryChars($binary, 4);

                if ($group_type === 0) {
                    break;
                }
            }
            $literal_value = bindec($literal_value_in_binary);
            $this->decoded_packet_values[] = $literal_value;
        } else {
            // Every other type of packet (any packet with a type ID other than 4) represent an operator that
            // performs some calculation on one or more sub-packets contained within.
            // An operator packet contains one or more packets.

            $length_type_id = $this->readBinaryCharsAsInt($binary, 1);

            // If the length type ID is 0, then the next 15 bits are a number that represents the total length
            // in bits of the sub-packets contained by this packet.
            if ($length_type_id === 0) {
                $length_of_sub_packets = $this->readBinaryCharsAsInt($binary, 15);

                $packet_data = $this->readBinaryChars($binary, $length_of_sub_packets);

                $this->decodeAll($packet_data);
            } elseif ($length_type_id === 1) {
                // If the length type ID is 1, then the next 11 bits are a number that represents the number of
                // sub-packets immediately contained by this packet.
                $nr_of_sub_packets = $this->readBinaryCharsAsInt($binary, 11);
                for ($i = 0; $i < $nr_of_sub_packets; $i++) {
                    $binary = $this->decodeSinglePacket($binary);
                }
            } else {
                throw new LogicException("Invalid length type id");
            }

        }

        return $binary;
    }

    private function readBinaryCharsAsInt(string &$input, int $length): int
    {
        return (int)bindec($this->readBinaryChars($input, $length));
    }

    private function readBinaryChars(string &$input, int $length): string
    {
        // Take the first N chars
        $read = substr($input, 0, $length);

        // Remove the first chars (we can modify $input here directly since we are using a pass-by-reference variable)
        $input = substr($input, $length);

        return $read;
    }
}
