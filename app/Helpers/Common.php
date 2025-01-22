<?php

namespace App\Helpers;

use App\Enums\Gender;
use App\Enums\BikeType;
use App\Enums\PaymentType;
use DateTime;

class Common
{
	private static $crypt_number = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
	private static $crypt_hash = [
		"VTMxmJTx", // 0
		"iIX1SPoF", // 1
		"RoHebhiA", // 2
		"BRNhJWko", // 3
		"ybKFdaZA", // 4
		"paGKzvym", // 5
		"tZqJtdQF", // 6
		"HPnRLdwH", // 7
		"xrSwmZvY", // 8
		"eDaDETJM", // 9
	];

	public static function encrypt($val)
	{
		$encrypt = str_replace(self::$crypt_number, self::$crypt_hash, $val);
		return $encrypt;
	}

	public static function decrypt($val)
	{
		$decrypt = str_replace(self::$crypt_hash, self::$crypt_number, $val);
		return ($decrypt == $val) ? null : $decrypt;
	}

	public static function option($request)
	{
		$opt = [
			'month' => [
				'1' => __('label.january'),
				'2' => __('label.february'),
				'3' => __('label.march'),
				'4' => __('label.april'),
				'5' => __('label.may'),
				'6' => __('label.june'),
				'7' => __('label.july'),
				'8' => __('label.august'),
				'9' => __('label.september'),
				'10' => __('label.october'),
				'11' => __('label.november'),
				'12' => __('label.december')
			],
			'gender' => [
				Gender::Male->value => __('label.male'),
				Gender::Female->value => __('label.female'),
			],
			'education_level' => [
				'sd' => 'SD',
				'smp' => 'SMP',
				'sma' => 'SMA',
			],

			'bike_type' => [
				BikeType::Matic->value => __('label.matic'),
				BikeType::Manual->value => __('label.manual'),
				BikeType::Electric->value => __('label.electric'),
			],
			'payment_type' => [
				PaymentType::Cash->value => __('label.cash'),
				PaymentType::Transfer->value => __('label.transfer'),
				PaymentType::Qris->value => __('label.qris'),
			],
		];

		if ($request == 'year') {
			$years = [];

			for ($y = 2022; $y <= date('Y', strtotime('+2 year')); $y++)
				$years[$y] = $y;

			$opt['year'] = $years;
		}

		return $opt[$request];
	}

	public static function dateFormat($date, $format = 'dd mmmm yyyy', $lang = 'auto')
	{
		$time = strtotime($date);
		$day = date('d', $time);
		$dayName = self::dayFormat(date('N', $time), 'dddd', $lang);
		$mmmm = self::monthFormat(date('n', $time), 'mmmm', $lang);
		$mmm = self::monthFormat(date('n', $time), 'mmm', $lang);
		$mm = date('m', $time);
		$yyyy = date('Y', $time);
		$yy = date('y', $time);
		$hh = date('H', $time);
		$ii = date('i', $time);

		$search = ['day', 'dd', 'mmmm', 'mmm', 'mm', 'yyyy', 'yy', 'hh', 'ii'];
		$replace = [$dayName, $day, $mmmm, $mmm, $mm, $yyyy, $yy, $hh, $ii];

		return str_replace($search, $replace, $format);
	}

	public static function monthFormat($month, $format = 'mmmm', $lang = 'auto') // date('n')
	{
		if ($format == 'mmmm') {
			if ($lang == 'auto') {
				$fm = [
					__('label.january'),
					__('label.february'),
					__('label.march'),
					__('label.april'),
					__('label.may'),
					__('label.june'),
					__('label.july'),
					__('label.august'),
					__('label.september'),
					__('label.october'),
					__('label.november'),
					__('label.december'),
				];
			} else {
				$fm = [
					'January',
					'February',
					'March',
					'April',
					'May',
					'June',
					'July',
					'August',
					'September',
					'October',
					'November',
					'December',
				];
			}
		} elseif ($format == 'mmm') {
			if ($lang == 'auto') {
				$fm = [
					__('label.jan'),
					__('label.feb'),
					__('label.mar'),
					__('label.apr'),
					__('label.may'),
					__('label.jun'),
					__('label.jul'),
					__('label.aug'),
					__('label.sep'),
					__('label.oct'),
					__('label.nov'),
					__('label.dec'),
				];
			} else {
				$fm = [
					'Jan',
					'Feb',
					'Mar',
					'Apr',
					'May',
					'Jun',
					'Jul',
					'Aug',
					'Sep',
					'Oct',
					'Nov',
					'Dec',
				];
			}
		} elseif ($format == 'romawi') {
			$fm = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
		}

		return $fm[$month - 1];
	}

	public static function dayFormat($day, $format = 'dddd', $lang = 'auto') // date('N')
	{
		if ($format == 'dddd') {
			$fd = [
				__('label.monday'),
				__('label.tuesday'),
				__('label.wednesday'),
				__('label.thursday'),
				__('label.friday'),
				__('label.saturday'),
				__('label.sunday'),
			];
		} elseif ($format == 'ddd') {
			$fd = [
				__('label.mon'),
				__('label.tue'),
				__('label.wed'),
				__('label.thu'),
				__('label.fri'),
				__('label.sat'),
				__('label.sun'),
			];
		}

		return $fd[$day - 1];
	}

	public static function phoneFormat($phone)
	{
		$length = strlen($phone);
		$phone1 = substr($phone, 0, 4);
		$phone2 = substr($phone, 4, 4);
		$phone3 = substr($phone, 8, 4);
		$phone4 = ($length > 12) ? '-' . substr($phone, 12, $length - 12) : '';

		return $phone1 . '-' . $phone2 . '-' . $phone3 . $phone4;
	}

	public static function phoneCorrection($phone)
	{
		$phone = str_replace(' ', '', $phone);
		$phone_code = substr($phone, 0, 2);
		$phone_code_plus = substr($phone, 0, 3);

		if ($phone_code == '62')
			$phone = '0' . substr($phone, 2, strlen($phone));
		else if ($phone_code_plus == '+62')
			$phone = '0' . substr($phone, 3, strlen($phone));

		return $phone;
	}

	public static function rounding($amount)
	{
		$hundreds = substr($amount, strlen($amount) - 3, 1) + 1;
		$round = substr($amount, 0, strlen($amount) - 3) . $hundreds . '00';

		return $round;
	}

	public static function randomString($len = 8)
	{
		$pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

		return substr(str_shuffle(str_repeat($pool, ceil($len / strlen($pool)))), 0, $len);
	}
}
