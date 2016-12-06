<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../src/Miso93/CzechHolidays.php';
require __DIR__ . '/../src/Miso93/EasterDate.php';

date_default_timezone_set('Europe/Bratislava');

Tester\Environment::setup();