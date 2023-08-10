# PHP morse code and wav(e) sound file generation

Supported character sets

- Arabic
- Cyrillic
- Greek (needs conversion to upper case letters (function included))
- Hebrew
- Japanese
- Korean
- Latin
- Persian
- Thai

## Examples

```php
<?php

use jblond\morse\Morse;
use jblond\morse\Wave;

require './vendor/autoload.php';

$morse = new Morse();
$morseBinary = $morse->stringToMorse('SOS');
$morse = $morse->dotDash($morseBinary);
echo $morse;
$wave = new Wave();
file_put_contents('sos.wav', $wave->generate('SOS'));
```

Non latin example

```PHP
<?php

use jblond\morse\Morse;

require './vendor/autoload.php';

$morse = new Morse();
$morse->setLetters('Greek'),
echo $morse->stringToMorse((new Greek())->stringToUpper('Τέλος εκπομπής'))

$morse->setLetters('Cyrillic'),
$morse->stringToMorse('Запомнить')
```

## Morse API

- `setLetters` Change the origin character set (letters / language)
  - available:  Arabic, Cyrillic, Greek, Hebrew, Japanese, Korean ([SKATS](https://en.wikipedia.org/wiki/SKATS)), Latin (default), Persian, and Thai.
- `getLetters` Get an array of the current selected character set
- `getCharacter` convert a single character into morse binary code. An invalid character will return a `#`.
- `stringToMorse` convert a string into binary morse code.
- `dotDash` converts binary morse code into dot and dash / dit and dah.

## Wav(e) API

- `setCwSpeed` set words per minute (cw speed). Default is 25.
- `setSampleRate` default is 11050. An audio CD would be  44100 aka 44.1 kHz (16 bit).
- `setFrequency` set the tone height. Default is 700 (cw tone).
- `generate` get the audio as binary.
License: MIT
