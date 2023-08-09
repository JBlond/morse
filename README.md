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

License: MIT
