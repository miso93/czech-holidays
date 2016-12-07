<?php
/**
 * @link https://github.com/miso93/czech-holidays
 * @copyright Copyright (c) 2015 Michal Čech
 * @license MIT License
 */

namespace Miso93;

class CzechHolidays
{
	/** @var array */
	private static $fixedHolidays = [
		'01-01' => 'Deň obnovy samostatného Českého štátu',

		'05-01' => 'Sviatok práce',
		'05-08' => 'Deň oslobodenia od fašizmu - 1945',

		'07-05' => 'Deň slovanských vierozvestov Cyrila a Metoda',
		'07-06' => 'Deň upálenia majstra Jana Husa - 1415',

		'09-28' => 'Deň Českej štátnosti',

		'10-28' => 'Deň vzniku samostatného Československého štátu - 1918',
		'11-17' => 'Deň boja za slobodu a demokraciu - 1989',

		'12-24' => 'Štedrý deň',
		'12-25' => 'Prvý sviatok vianočný',
		'12-26' => 'Druhý sviatok vianočný',
	];

	/** @var array */
	private static $easterHolidays = [
		'friday' => 'Veľký piatok',
		'monday' => 'Veľkonočný pondelok'
	];

	/**
	 * Constructor to disable instantiation
	 * @throws CzechHolidaysException
	 */
	public function __construct()
	{
		throw new CzechHolidaysException('Class cannot be instantiated');
	}

	/**
	 * Gets holidays for specified year
	 * @param int $year
	 * @param int $month
	 * @return array
	 */
	public static function getHolidays($year = null, $month = null)
	{
		$year = $year ?: date('Y');
		$easterSunday = (new \DateTime)->setTimestamp(EasterDate::get($year));

		$holidays = [
			$easterSunday->sub(new \DateInterval('P2D'))->format('Y-m-d') => self::$easterHolidays['friday'],
			$easterSunday->add(new \DateInterval('P3D'))->format('Y-m-d') => self::$easterHolidays['monday'],
		];

		foreach (self::$fixedHolidays as $key => $holiday) {
			$holidays[$year . '-' . $key] = $holiday;
		}

		ksort($holidays);

		if ($month !== null) {
			return self::getHolidaysForYearAndMonth($holidays, $year, $month);
		}
		else {
			return $holidays;
		}
	}

	/**
	 * Gets holiday for specified year and month
	 * @param array $holidays
	 * @param int $year
	 * @param int $month
	 * @return array
	 * @throws CzechHolidaysException
	 */
	private static function getHolidaysForYearAndMonth(array $holidays, $year, $month)
	{
		if (!checkdate($month, 1, $year)) {
			throw new CzechHolidaysException('Invalid input year or month');
		}

		foreach ($holidays as $key => $holiday) {
			if (substr($key, 0, 7) !== sprintf("%4d-%02d", $year, $month)) {
				unset($holidays[$key]);
			}
		}

		return $holidays;
	}

	/**
	 * Returns if day is holiday
	 * @param int
	 * @param int
	 * @param int
	 * @return bool
	 * @throws CzechHolidaysException
	 */
	public static function isDayHoliday($year, $month, $day)
	{
		if (!checkdate($month, $day, $year)) {
			throw new CzechHolidaysException('Invalid input year, month or day');
		}

		$isHoliday = false;

		foreach (self::getHolidays($year) as $key => $holiday) {
			if ($key === sprintf("%4d-%02d-%02d", $year, $month, $day)) {
				$isHoliday = true;
				break;
			}
		}

		return $isHoliday;
	}

	/**
	 * Returns if today is holiday
	 * @return bool
	 * @throws CzechHolidaysException
	 */
	public static function isTodayHoliday()
	{
		return self::isDayHoliday(date('Y'), date('m'), date('d'));
	}
}

class CzechHolidaysException extends \Exception
{
}
