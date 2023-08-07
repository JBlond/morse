# PHP morse code and wav(e) sound file generation

```php
<?php

use jblond\morse\Morse;
use jblond\morse\Wave;

require './vendor/autoload.php';

$character = new Morse();
$morseBinary = $character->stringToMorse('SOS');
$morse = $character->dotDash($morseBinary);
echo $morse;
$wave = new Wave();
file_put_contents('sos.wav', $wave->generate('SOS'));
```
