<?php

use jblond\morse\Morse;
use jblond\morse\Wave;

require '../vendor/autoload.php';

$morse = new Morse();
$morseBinary = $morse->stringToMorse('SOS');
$morseCode = $morse->dotDash($morseBinary);
echo $morseCode;
$wave = new Wave();
$wave->setCwSpeed(10);
file_put_contents('sos.wav', $wave->generate('SOS'));
