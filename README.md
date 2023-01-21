# LatLng
PHP utilities to use with geolocation

## Usage

### Composer

Within your `vendor` directory, create a directory called `MMannes` and inside it clone this repository with `git clone https://github.com/mmannes/LatLng.git`.

### Manually

Clone this repository with `git clone https://github.com/mmannes/LatLng.git` inside your working directory and include the `LatLng.php` file manually.

## Example

```php
<?php

use MMannes\LatLng;

require_once './LatLng.php';

$coordinate_1 = new LatLng(-26.304440, -48.845560);
$coordinate_2 = new LatLng(-26.473056, -49.002778);

$distance = LatLng::distance($coordinate_1, $coordinate_2);

echo $distance . ' quilometers'; // prints 24.412543705112 quilometers
```


