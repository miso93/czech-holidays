[![Build status](https://travis-ci.org/miso93/czech-holidays.svg?branch=master)](https://travis-ci.org/miso93/czech-holidays)

Czech Holidays
===============

Simple PHP library/helper for getting Czech holidays. <br>
This project is simple refactor of [Slovak Holidays](https://github.com/rekurzia/slovak-holidays)

Installation
------------

```bash

composer require miso93/czech-holidays

```

Usage
-----

Very easy, static:

```php

\Miso93\CzechHolidays::getHolidays(); // for current year
\Miso93\CzechHolidays::getHolidays(2014); // only for year
\Miso93\CzechHolidays::getHolidays(2014, 8); // for year and month
\Miso93\CzechHolidays::isTodayHoliday(); // date('Y-m-d')
\Miso93\CzechHolidays::isDayHoliday(2015, 12, 24);

```

License
-------

This software is licensed under MIT License.
