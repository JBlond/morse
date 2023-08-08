<?php

namespace jblond\morse\CharacterSet;

use jblond\morse\CharacterSet\Character;

class Hebrew implements Character
{
    /**
     * @var array|string[]
     */
    protected array $letters = [
        // Hebrew Alphabet => https://he.wikipedia.org/wiki/%D7%A7%D7%95%D7%93_%D7%9E%D7%95%D7%A8%D7%A1
        '01' => 'א', '1000' => 'ב', '110' => 'ג', '100' => 'ד', '111' => 'ה', '0' => 'ו',
        '1100' => 'ז', '0000' => 'ח', '001' => 'ט', '00' => 'י', '101' => 'כ', '0100' => 'ל',
        '11' => 'מ', '10' => 'נ', '1010' => 'ס', '0111' => 'ע', '0110' => 'פ', '011' => 'צ',
        '1101' => 'ק', '010' => 'ר', '000' => 'ש', '1' => 'ת',
        // numbers
        '11111' => '0', '01111' => '1', '00111' => '2', '00011' => '3', '00001' => '4',
        '00000' => '5', '10000' => '6', '11000' => '7', '11100' => '8', '11110' => '9',
        // Punctuation
        '010101' => '.', '110011' => ',', '001100' => '?', '011110' => '\'', '101011' => '!', '10010' => '/',
        '10110' => '(', '101101' => ')', '01000' => '&', '111000' => ':', '101010' => ';', '10001' => '=',
        '01010' => '+', '100001' => '-', '001101' => '_', '010010' => '"', '0001001' => '$', '011010' => '@',
        '00101' => '¿', '110001' => '¡',
    ];

    /**
     * @return array|string[]
     */
    public function get(): array
    {
        return $this->letters;
    }
}
