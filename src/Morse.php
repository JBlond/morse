<?php

namespace jblond\morse;

use jblond\morse\CharacterSet\Arabic;
use jblond\morse\CharacterSet\Cyrillic;
use jblond\morse\CharacterSet\Greek;
use jblond\morse\CharacterSet\Hebrew;
use jblond\morse\CharacterSet\Japanese;
use jblond\morse\CharacterSet\Korean;
use jblond\morse\CharacterSet\Latin;
use jblond\morse\CharacterSet\Persian;
use jblond\morse\CharacterSet\Thai;

/**
 *
 */
class Morse
{
    /**
     * @var array
     */
    protected array $letters = [];

    /**
     *
     */
    public function __construct()
    {
        $this->setLetters();
    }

    /**
     * @param string $letters
     * @return string
     */
    public function setLetters(string $letters = 'Latin'): string
    {
        $this->letters = match($letters) {
            'Cyrillic' => (new Cyrillic())->get(),
            'Greek' => (new Greek())->get(),
            'Hebrew' => (new Hebrew())->get(),
            'Arabic' => (new Arabic())->get(),
            'Persian' => (new Persian())->get(),
            'Japanese' => (new Japanese())->get(),
            'Korean' => (new Korean())->get(),
            'Thai' => (new Thai())->get(),
            default => (new Latin())->get()
        };
        return $letters;
    }

    protected function mb_array_search(string $needle, array $haystack)
    {
        foreach ($haystack as $key => $value){
            if(mb_strtolower($value) === mb_strtolower($needle)){
                return $key;
            }
        }
        return false;
    }
    /**
     * @param string $input
     * @return string
     */
    public function getCharacter(string $input): string
    {
        if($input === ' '){
            return '/ ';
        }
        $result = $this->mb_array_search($input, $this->letters);
        if($result !== false){
            return $result . ' ';
        }
        $result = $this->mb_array_search(strtoupper($input), $this->letters);
        if($result !== false){
            return $result . ' ';
        }
        //echo '[' . $input . ']';
        return '#';
    }

    /**
     * @param string $string
     * @return string
     */
    public function stringToMorse(string $string): string
    {
        $morseCode = '';
        $stringArray = preg_split('//u', $string);
        foreach ($stringArray as $character){
            if($character === ''){
                continue;
            }
            $morseCode .= $this->getCharacter($character);
        }
        return $morseCode;
    }

    /**
     * @param string $string
     * @param string $dot
     * @param string $dash
     * @param string $pause
     * @return string
     */
    public function dotDash(string $string, string $dot = '.', string $dash = '-', string $pause = '/'): string
    {
        $return = '';
        $array = str_split($string);
        foreach ($array as $character){
            $return .= str_replace(['0', '1', '  '],[$dot, $dash, $pause], $character);
        }
        return $return;
    }
}
