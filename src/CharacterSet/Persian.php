<?php

namespace jblond\morse\CharacterSet;

use jblond\morse\CharacterSet\Character;

class Persian implements Character
{
    /**
     * @var array|string[]
     */
    protected array $letters = [
        // Persian Alphabet => https://en.wikipedia.org/wiki/Morse_code_for_non-Latin_alphabets
        '01' => 'ا' , '1000' => 'ب' , '0110' => 'پ', '1' => 'ت', '1010' => 'ث', '0111' => 'ج',
        '1110' => 'چ', '0000' => 'ح', '1001' => 'خ', '100' => 'د', '0001' => 'ذ', '010' => 'ر',
        '1100' => 'ز', '110' => 'ژ', '000' => 'س', '1111' => 'ش', '0101' => 'ص', '00100' => 'ض',
        '001' => 'ط', '1011' => 'ظ', '111' => 'ع', '0011' => 'غ', '0010' => 'ف', '111000' => 'ق',
        '101' => 'ک', '1101' => 'گ', '0100' => 'ل', '11' => 'م', '10' => 'ن', '011' => 'و',
        '0' => 'ه' , '00' => 'ی',
        // numbers
        '11111' => '0', '01111' => '1', '00111' => '2', '00011' => '3', '00001' => '4',
        '00000' => '5', '10000' => '6', '11000' => '7', '11100' => '8', '11110' => '9',
        // Punctuation
        '010101' => '.', '110011' => ',', '001100' => '?', '011110' => '\'', '101011' => '!', '10010' => '/',
        '10110' => '(', '101101' => ')', '01000' => '&', '101010' => ';', '10001' => '=',
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
