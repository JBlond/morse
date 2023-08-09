<?php

declare(strict_types=1);

namespace jblond\morse\CharacterSet;

class Greek implements Character
{
    /**
     * @var array|string[]
     */
    protected array $letters = [
        // Greek Alphabet => https://en.wikipedia.org/wiki/Morse_code_for_non-Latin_alphabets
        '01' => 'Α', '1000' => 'Β', '110' => 'Γ', '100' => 'Δ', '0' => 'Ε', '1100' => 'Ζ',
        '0000' => 'Η', '1010' => 'Θ', '00' => 'Ι', '101' => 'Κ', '0100' => 'Λ', '11' => 'Μ',
        '10' => 'Ν', '1001' => 'Ξ', '111' => 'Ο', '0110' => 'Π', '010' => 'Ρ', '000' => 'Σ',
        '1' => 'Τ', '1011' => 'Υ', '0010' => 'Φ', '1111' => 'Χ', '1101' => 'Ψ', '011' => 'Ω',
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

    /**
     * from https://github.com/vdw/Greek-string-to-uppercase/blob/master/MY_string_helper.php
     * @param $string
     * @return string
     */
    public function stringToUpper($string): string
    {

        $latin_check = '/[\x{0030}-\x{007f}]/u';

        if (preg_match($latin_check, $string)) {
            $string = strtoupper($string);
        }

        $letters                             = [
                                                 'α', 'β', 'γ', 'δ', 'ε', 'ζ', 'η',
                                                 'θ', 'ι', 'κ', 'λ', 'μ', 'ν', 'ξ',
                                                 'ο', 'π', 'ρ', 'σ', 'τ', 'υ', 'φ',
                                                 'χ', 'ψ', 'ω'
                                             ];
        $letters_accent                      = ['ά', 'έ', 'ή', 'ί', 'ό', 'ύ', 'ώ'];
        $letters_upper_accent                = ['Ά', 'Έ', 'Ή', 'Ί', 'Ό', 'Ύ', 'Ώ'];
        $letters_upper_solvents              = ['ϊ', 'ϋ'];
        $letters_other                       = ['ς'];

        $letters_to_uppercase                = [
                                                'Α', 'Β', 'Γ', 'Δ', 'Ε', 'Ζ', 'Η',
                                                'Θ', 'Ι', 'Κ', 'Λ', 'Μ', 'Ν', 'Ξ',
                                                'Ο', 'Π', 'Ρ', 'Σ', 'Τ', 'Υ', 'Φ',
                                                'Χ', 'Ψ', 'Ω'
                                             ];
        $letters_accent_to_uppercase         = ['Α', 'Ε', 'Η', 'Ι', 'Ο', 'Υ', 'Ω'];
        $letters_upper_accent_to_uppercase   = ['Α', 'Ε', 'Η', 'Ι', 'Ο', 'Υ', 'Ω'];
        $letters_upper_solvents_to_uppercase = ['Ι', 'Υ'];
        $letters_other_to_uppercase          = ['Σ'];

        $lowercase = array_merge(
            $letters,
            $letters_accent,
            $letters_upper_accent,
            $letters_upper_solvents,
            $letters_other
        );
        $uppercase = array_merge(
            $letters_to_uppercase,
            $letters_accent_to_uppercase,
            $letters_upper_accent_to_uppercase,
            $letters_upper_solvents_to_uppercase,
            $letters_other_to_uppercase
        );

        return str_replace($lowercase, $uppercase, $string);
    }
}
