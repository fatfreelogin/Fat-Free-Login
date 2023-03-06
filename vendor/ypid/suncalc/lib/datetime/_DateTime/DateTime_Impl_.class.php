<?php

class datetime__DateTime_DateTime_Impl_ {
	public function __construct(){}
	static $UNIX_EPOCH_DIFF = 62135596800.0;
	static $SECONDS_IN_MINUTE = 60;
	static $SECONDS_IN_HOUR = 3600;
	static $SECONDS_IN_DAY = 86400;
	static $SECONDS_IN_WEEK = 604800;
	static $SECONDS_IN_YEAR = 31536000;
	static $SECONDS_IN_LEAP_YEAR = 31622400;
	static $SECONDS_IN_3_YEARS = 94608000;
	static $SECONDS_IN_QUAD = 126230400.0;
	static $SECONDS_IN_HALF_QUAD = 63072000.0;
	static $SECONDS_IN_HALF_QUAD_LEAP = 63158400.0;
	static $SECONDS_IN_3_PART_QUAD = 94694400.0;
	static $SECONDS_IN_CQUAD = 12622780800.0;
	static $SECONDS_IN_CENTURY = 3155673600.0;
	static $SECONDS_IN_LEAP_CENTURY = 3155760000.0;
	static function now() {
		$time = time();
		return $time + 62135596800.0;
	}
	static function local() {
		$utc = null;
		{
			$time = time();
			$utc = $time + 62135596800.0;
		}
		{
			$time1 = $utc - 62135596800.0 + datetime__DateTime_DateTime_Impl_::getLocalOffset();
			return $time1 + 62135596800.0;
		}
	}
	static function make($year = null, $month = null, $day = null, $hour = null, $minute = null, $second = null) {
		if($second === null) {
			$second = 0;
		}
		if($minute === null) {
			$minute = 0;
		}
		if($hour === null) {
			$hour = 0;
		}
		if($day === null) {
			$day = 1;
		}
		if($month === null) {
			$month = 1;
		}
		if($year === null) {
			$year = 1970;
		}
		{
			$time = datetime_utils_DateTimeUtils::yearToStamp($year) + datetime_utils_DateTimeMonthUtils::toSeconds($month, ((_hx_mod($year, 4) === 0) ? datetime__DateTime_DateTime_Impl__0($day, $hour, $minute, $month, $second, $year) : false)) + ($day - 1) * 86400 + $hour * 3600 + $minute * 60 + $second - 62135596800.0;
			return $time + 62135596800.0;
		}
	}
	static function fromTime($time) {
		return $time + 62135596800.0;
	}
	static function fromString($str) {
		return datetime_utils_DateTimeUtils::fromString($str);
	}
	static function fromDate($date) {
		{
			$time = Math::ffloor($date->getTime() / 1000);
			return $time + 62135596800.0;
		}
	}
	static function daysInMonth($month, $isLeapYear = null) {
		if($isLeapYear === null) {
			$isLeapYear = false;
		}
		return datetime_utils_DateTimeMonthUtils::days($month, $isLeapYear);
	}
	static function weeksInYear($year) {
		$start = null;
		{
			$time = datetime_utils_DateTimeUtils::yearToStamp($year) - 62135596800.0;
			$start = $time + 62135596800.0;
		}
		$weekDay = datetime__DateTime_DateTime_Impl_::getWeekDay($start, null);
		if($weekDay === 4 || $weekDay === 3 && datetime__DateTime_DateTime_Impl_::isLeapYear($start)) {
			return 53;
		} else {
			return 52;
		}
	}
	static function isLeap($year) {
		if(_hx_mod($year, 4) === 0) {
			if(_hx_mod($year, 100) === 0) {
				return _hx_mod($year, 400) === 0;
			} else {
				return true;
			}
		} else {
			return false;
		}
	}
	static function getLocalOffset() {
		$now = Date::now();
		$local = null;
		{
			$year = $now->getFullYear();
			$month = $now->getMonth() + 1;
			$day = $now->getDate();
			$hour = $now->getHours();
			$minute = $now->getMinutes();
			$second = $now->getSeconds();
			{
				$time = datetime_utils_DateTimeUtils::yearToStamp($year) + datetime_utils_DateTimeMonthUtils::toSeconds($month, ((_hx_mod($year, 4) === 0) ? datetime__DateTime_DateTime_Impl__1($day, $hour, $local, $minute, $month, $now, $second, $year) : false)) + ($day - 1) * 86400 + $hour * 3600 + $minute * 60 + $second - 62135596800.0;
				$local = $time + 62135596800.0;
			}
		}
		return Std::int($local - 62135596800.0 - Std::int($now->getTime() / 1000));
	}
	static function _new($time) {
		return $time + 62135596800.0;
	}
	static function utc($this1) {
		{
			$time = $this1 - 62135596800.0 - datetime__DateTime_DateTime_Impl_::getLocalOffset();
			return $time + 62135596800.0;
		}
	}
	static function getYear($this1) {
		$cquads = Std::int($this1 / 12622780800.0) * 12622780800.0;
		$centuries = Std::int(($this1 - $cquads) / 3155673600.0) * 3155673600.0;
		if($centuries > 9467020800.) {
			$centuries -= 3155673600.0;
		}
		$quads = Std::int(($this1 - $cquads - $centuries) / 126230400.0) * 126230400.0;
		$years = Std::int(($this1 - $cquads - $centuries - $quads) / 31536000);
		return Std::int($cquads / 12622780800.0) * 400 + Std::int($centuries / 3155673600.0) * 100 + Std::int($quads / 126230400.0) * 4 + (datetime__DateTime_DateTime_Impl__2($centuries, $cquads, $quads, $this1, $years));
	}
	static function yearStart($this1) {
		$cquads = Std::int($this1 / 12622780800.0) * 12622780800.0;
		$centuries = Std::int(($this1 - $cquads) / 3155673600.0) * 3155673600.0;
		if($centuries > 9467020800.) {
			$centuries -= 3155673600.0;
		}
		$quads = Std::int(($this1 - $cquads - $centuries) / 126230400.0) * 126230400.0;
		$years = Std::int(($this1 - $cquads - $centuries - $quads) / 31536000);
		if($years === 4) {
			$years--;
		}
		return $cquads + $centuries + $quads + $years * 31536000 - 62135596800.0;
	}
	static function monthStart($this1, $month = null) {
		if($month === null) {
			$month = 0;
		}
		if($month === 0) {
			$days = Std::int(($this1 - 62135596800.0 - datetime__DateTime_DateTime_Impl_::yearStart($this1)) / 86400) + 1;
			$month = datetime_utils_DateTimeMonthUtils::getMonth($days, datetime__DateTime_DateTime_Impl_::isLeapYear($this1));
		}
		return datetime__DateTime_DateTime_Impl_::yearStart($this1) + datetime_utils_DateTimeMonthUtils::toSeconds($month, datetime__DateTime_DateTime_Impl_::isLeapYear($this1));
	}
	static function getMonthStart($this1, $month) {
		{
			$time = datetime__DateTime_DateTime_Impl_::monthStart($this1, $month);
			return $time + 62135596800.0;
		}
	}
	static function isLeapYear($this1) {
		$year = datetime__DateTime_DateTime_Impl_::getYear($this1);
		if(_hx_mod($year, 4) === 0) {
			if(_hx_mod($year, 100) === 0) {
				return _hx_mod($year, 400) === 0;
			} else {
				return true;
			}
		} else {
			return false;
		}
	}
	static function getMonth($this1) {
		$days = Std::int(($this1 - 62135596800.0 - datetime__DateTime_DateTime_Impl_::yearStart($this1)) / 86400) + 1;
		return datetime_utils_DateTimeMonthUtils::getMonth($days, datetime__DateTime_DateTime_Impl_::isLeapYear($this1));
	}
	static function getDay($this1) {
		$days = Std::int(($this1 - 62135596800.0 - datetime__DateTime_DateTime_Impl_::yearStart($this1)) / 86400) + 1;
		return datetime_utils_DateTimeMonthUtils::getMonthDay($days, datetime__DateTime_DateTime_Impl_::isLeapYear($this1));
	}
	static function daysInThisMonth($this1) {
		$month = null;
		{
			$days = Std::int(($this1 - 62135596800.0 - datetime__DateTime_DateTime_Impl_::yearStart($this1)) / 86400) + 1;
			$month = datetime_utils_DateTimeMonthUtils::getMonth($days, datetime__DateTime_DateTime_Impl_::isLeapYear($this1));
		}
		return datetime_utils_DateTimeMonthUtils::days($month, $month === 2 && datetime__DateTime_DateTime_Impl_::isLeapYear($this1));
	}
	static function getYearDay($this1) {
		return Std::int(($this1 - 62135596800.0 - datetime__DateTime_DateTime_Impl_::yearStart($this1)) / 86400) + 1;
	}
	static function weeksInThisYear($this1) {
		return datetime__DateTime_DateTime_Impl_::weeksInYear(datetime__DateTime_DateTime_Impl_::getYear($this1));
	}
	static function getWeekDay($this1, $mondayBased = null) {
		if($mondayBased === null) {
			$mondayBased = false;
		}
		$month = null;
		{
			$days = Std::int(($this1 - 62135596800.0 - datetime__DateTime_DateTime_Impl_::yearStart($this1)) / 86400) + 1;
			$month = datetime_utils_DateTimeMonthUtils::getMonth($days, datetime__DateTime_DateTime_Impl_::isLeapYear($this1));
		}
		$a = Std::int((14 - $month) / 12);
		$y = datetime__DateTime_DateTime_Impl_::getYear($this1) - $a;
		$m = $month + 12 * $a - 2;
		$weekDay = null;
		$weekDay = _hx_mod((7000 + (datetime__DateTime_DateTime_Impl__3($a, $m, $mondayBased, $month, $this1, $weekDay, $y) + $y + Std::int($y / 4) - Std::int($y / 100) + Std::int($y / 400) + Std::int(31 * $m / 12))), 7);
		if($mondayBased && $weekDay === 0) {
			return 7;
		} else {
			return $weekDay;
		}
	}
	static function getWeekDayNum($this1, $weekDay, $num = null) {
		if($num === null) {
			$num = 1;
		}
		$time = datetime_utils_DateTimeUtils::getWeekDayNum($this1 - 62135596800.0 + 62135596800.0, $weekDay, $num);
		return $time + 62135596800.0;
	}
	static function getWeek($this1) {
		$week = Std::int((Std::int(($this1 - 62135596800.0 - datetime__DateTime_DateTime_Impl_::yearStart($this1)) / 86400) + 1 - datetime__DateTime_DateTime_Impl_::getWeekDay($this1, true) + 10) / 7);
		$year = datetime__DateTime_DateTime_Impl_::getYear($this1);
		if($week < 1) {
			return datetime__DateTime_DateTime_Impl_::weeksInYear($year - 1);
		} else {
			if($week > 52 && $week > datetime__DateTime_DateTime_Impl_::weeksInYear($year)) {
				return 1;
			} else {
				return $week;
			}
		}
	}
	static function getHour($this1) {
		return Std::int(($this1 - Math::ffloor($this1 / 86400) * 86400) / 3600);
	}
	static function getHour12($this1) {
		$hour = Std::int(($this1 - Math::ffloor($this1 / 86400) * 86400) / 3600);
		if($hour === 0) {
			return 12;
		} else {
			if($hour > 12) {
				return $hour - 12;
			} else {
				return $hour;
			}
		}
	}
	static function getMinute($this1) {
		return Std::int(($this1 - Math::ffloor($this1 / 3600) * 3600) / 60);
	}
	static function getSecond($this1) {
		return Std::int($this1 - Math::ffloor($this1 / 60) * 60);
	}
	static function add($this1, $period) {
		$time = null;
		switch($period->index) {
		case 0:{
			$n = _hx_deref($period)->params[0];
			$time = datetime_utils_DateTimeUtils::addYear($this1 - 62135596800.0 + 62135596800.0, $n);
		}break;
		case 1:{
			$n1 = _hx_deref($period)->params[0];
			$time = datetime_utils_DateTimeUtils::addMonth($this1 - 62135596800.0 + 62135596800.0, $n1);
		}break;
		case 2:{
			$n2 = _hx_deref($period)->params[0];
			$time = $this1 - 62135596800.0 + $n2 * 86400;
		}break;
		case 3:{
			$n3 = _hx_deref($period)->params[0];
			$time = $this1 - 62135596800.0 + $n3 * 3600;
		}break;
		case 4:{
			$n4 = _hx_deref($period)->params[0];
			$time = $this1 - 62135596800.0 + $n4 * 60;
		}break;
		case 5:{
			$n5 = _hx_deref($period)->params[0];
			$time = $this1 - 62135596800.0 + $n5;
		}break;
		case 6:{
			$n6 = _hx_deref($period)->params[0];
			$time = $this1 - 62135596800.0 + $n6 * 7 * 86400;
		}break;
		}
		return $time + 62135596800.0;
	}
	static function sub($this1, $period) {
		$time = null;
		switch($period->index) {
		case 0:{
			$n = _hx_deref($period)->params[0];
			$time = datetime_utils_DateTimeUtils::addYear($this1 - 62135596800.0 + 62135596800.0, -$n);
		}break;
		case 1:{
			$n1 = _hx_deref($period)->params[0];
			$time = datetime_utils_DateTimeUtils::addMonth($this1 - 62135596800.0 + 62135596800.0, -$n1);
		}break;
		case 2:{
			$n2 = _hx_deref($period)->params[0];
			$time = $this1 - 62135596800.0 - $n2 * 86400;
		}break;
		case 3:{
			$n3 = _hx_deref($period)->params[0];
			$time = $this1 - 62135596800.0 - $n3 * 3600;
		}break;
		case 4:{
			$n4 = _hx_deref($period)->params[0];
			$time = $this1 - 62135596800.0 - $n4 * 60;
		}break;
		case 5:{
			$n5 = _hx_deref($period)->params[0];
			$time = $this1 - 62135596800.0 - $n5;
		}break;
		case 6:{
			$n6 = _hx_deref($period)->params[0];
			$time = $this1 - 62135596800.0 - $n6 * 7 * 86400;
		}break;
		}
		return $time + 62135596800.0;
	}
	static function snap($this1, $period) {
		$time = null;
		switch($period->index) {
		case 0:{
			$d = _hx_deref($period)->params[0];
			$time = datetime_utils_DateTimeSnapUtils::snapYear($this1 - 62135596800.0 + 62135596800.0, $d);
		}break;
		case 1:{
			$d1 = _hx_deref($period)->params[0];
			$time = datetime_utils_DateTimeSnapUtils::snapMonth($this1 - 62135596800.0 + 62135596800.0, $d1);
		}break;
		case 2:{
			$d2 = _hx_deref($period)->params[0];
			$time = datetime_utils_DateTimeSnapUtils::snapDay($this1 - 62135596800.0 + 62135596800.0, $d2);
		}break;
		case 3:{
			$d3 = _hx_deref($period)->params[0];
			$time = datetime_utils_DateTimeSnapUtils::snapHour($this1 - 62135596800.0 + 62135596800.0, $d3);
		}break;
		case 4:{
			$d4 = _hx_deref($period)->params[0];
			$time = datetime_utils_DateTimeSnapUtils::snapMinute($this1 - 62135596800.0 + 62135596800.0, $d4);
		}break;
		case 5:{
			$d5 = _hx_deref($period)->params[0];
			if($d5 === 1) {
				$time = $this1 - 62135596800.0 + 1;
			} else {
				$time = $this1 - 62135596800.0;
			}
		}break;
		case 6:{
			$day = _hx_deref($period)->params[1];
			$d6 = _hx_deref($period)->params[0];
			$time = datetime_utils_DateTimeSnapUtils::snapWeek($this1 - 62135596800.0 + 62135596800.0, $d6, $day);
		}break;
		}
		return $time + 62135596800.0;
	}
	static function toString($this1) {
		$Y = datetime__DateTime_DateTime_Impl_::getYear($this1);
		$M = null;
		{
			$days = Std::int(($this1 - 62135596800.0 - datetime__DateTime_DateTime_Impl_::yearStart($this1)) / 86400) + 1;
			$M = datetime_utils_DateTimeMonthUtils::getMonth($days, datetime__DateTime_DateTime_Impl_::isLeapYear($this1));
		}
		$D = null;
		{
			$days1 = Std::int(($this1 - 62135596800.0 - datetime__DateTime_DateTime_Impl_::yearStart($this1)) / 86400) + 1;
			$D = datetime_utils_DateTimeMonthUtils::getMonthDay($days1, datetime__DateTime_DateTime_Impl_::isLeapYear($this1));
		}
		$h = Std::int(($this1 - Math::ffloor($this1 / 86400) * 86400) / 3600);
		$m = Std::int(($this1 - Math::ffloor($this1 / 3600) * 3600) / 60);
		$s = Std::int($this1 - Math::ffloor($this1 / 60) * 60);
		return "" . _hx_string_rec($Y, "") . "-" . _hx_string_or_null((datetime__DateTime_DateTime_Impl__4($D, $M, $Y, $h, $m, $s, $this1))) . "-" . _hx_string_or_null((datetime__DateTime_DateTime_Impl__5($D, $M, $Y, $h, $m, $s, $this1))) . " " . _hx_string_or_null((datetime__DateTime_DateTime_Impl__6($D, $M, $Y, $h, $m, $s, $this1))) . ":" . _hx_string_or_null((datetime__DateTime_DateTime_Impl__7($D, $M, $Y, $h, $m, $s, $this1))) . ":" . _hx_string_or_null((datetime__DateTime_DateTime_Impl__8($D, $M, $Y, $h, $m, $s, $this1)));
	}
	static function format($this1, $format) {
		return datetime_utils_DateTimeUtils::strftime($this1 - 62135596800.0 + 62135596800.0, $format);
	}
	static function getTime($this1) {
		return $this1 - 62135596800.0;
	}
	static function getDate($this1) {
		return Date::fromTime(($this1 - 62135596800.0) * 1000);
	}
	static function gt($this1, $dt) {
		return $this1 - 62135596800.0 > $dt - 62135596800.0;
	}
	static function gte($this1, $dt) {
		return $this1 - 62135596800.0 >= $dt - 62135596800.0;
	}
	static function lt($this1, $dt) {
		return $this1 - 62135596800.0 < $dt - 62135596800.0;
	}
	static function lte($this1, $dt) {
		return $this1 - 62135596800.0 <= $dt - 62135596800.0;
	}
	static function eq($this1, $dt) {
		return $this1 - 62135596800.0 === $dt - 62135596800.0;
	}
	static function neq($this1, $dt) {
		return $this1 - 62135596800.0 !== $dt - 62135596800.0;
	}
	static function mathPlus1($this1, $period) {
		return datetime__DateTime_DateTime_Impl_::add($this1, $period);
	}
	static function mathPlus2($this1, $period) {
		return datetime__DateTime_DateTime_Impl_::add($this1, $period);
	}
	static function mathPlus3($this1, $period) {
		{
			$time = null;
			$time = $this1 = datetime__DateTime_DateTime_Impl__9($period, $this1, $time) + 62135596800.0;
			return $time + 62135596800.0;
		}
	}
	static function mathMinus1($this1, $period) {
		return datetime__DateTime_DateTime_Impl_::sub($this1, $period);
	}
	static function mathMinus2($this1, $period) {
		{
			$time = null;
			$time = $this1 = datetime__DateTime_DateTime_Impl__10($period, $this1, $time) + 62135596800.0;
			return $time + 62135596800.0;
		}
	}
	static function dtiCreate($this1, $begin) {
		return datetime__DateTimeInterval_DateTimeInterval_Impl_::create($begin, $this1 - 62135596800.0 + 62135596800.0);
	}
	static function dtiMinus($this1, $dti) {
		return datetime__DateTimeInterval_DateTimeInterval_Impl_::subFrom($dti, $this1 - 62135596800.0 + 62135596800.0);
	}
	static function dtiPlus1($this1, $dti) {
		return datetime__DateTimeInterval_DateTimeInterval_Impl_::addTo($dti, $this1 - 62135596800.0 + 62135596800.0);
	}
	static function dtiPlus2($this1, $dti) {
		return datetime__DateTimeInterval_DateTimeInterval_Impl_::addTo($dti, $this1 - 62135596800.0 + 62135596800.0);
	}
	static function dtiMinus2($this1, $dti) {
		{
			$time = null;
			$time = $this1 = datetime__DateTime_DateTime_Impl__11($dti, $this1, $time) + 62135596800.0;
			return $time + 62135596800.0;
		}
	}
	static function dtiPlus3($this1, $dti) {
		{
			$time = null;
			$time = $this1 = datetime__DateTime_DateTime_Impl__12($dti, $this1, $time) + 62135596800.0;
			return $time + 62135596800.0;
		}
	}
	function __toString() { return 'datetime._DateTime.DateTime_Impl_'; }
}
function datetime__DateTime_DateTime_Impl__0(&$day, &$hour, &$minute, &$month, &$second, &$year) {
	if(_hx_mod($year, 100) === 0) {
		return _hx_mod($year, 400) === 0;
	} else {
		return true;
	}
}
function datetime__DateTime_DateTime_Impl__1(&$day, &$hour, &$local, &$minute, &$month, &$now, &$second, &$year) {
	if(_hx_mod($year, 100) === 0) {
		return _hx_mod($year, 400) === 0;
	} else {
		return true;
	}
}
function datetime__DateTime_DateTime_Impl__2(&$centuries, &$cquads, &$quads, &$this1, &$years) {
	if($years === 4) {
		return $years;
	} else {
		return $years + 1;
	}
}
function datetime__DateTime_DateTime_Impl__3(&$a, &$m, &$mondayBased, &$month, &$this1, &$weekDay, &$y) {
	{
		$days1 = Std::int(($this1 - 62135596800.0 - datetime__DateTime_DateTime_Impl_::yearStart($this1)) / 86400) + 1;
		return datetime_utils_DateTimeMonthUtils::getMonthDay($days1, datetime__DateTime_DateTime_Impl_::isLeapYear($this1));
	}
}
function datetime__DateTime_DateTime_Impl__4(&$D, &$M, &$Y, &$h, &$m, &$s, &$this1) {
	if($M < 10) {
		return "0" . _hx_string_rec($M, "");
	} else {
		return "" . _hx_string_rec($M, "");
	}
}
function datetime__DateTime_DateTime_Impl__5(&$D, &$M, &$Y, &$h, &$m, &$s, &$this1) {
	if($D < 10) {
		return "0" . _hx_string_rec($D, "");
	} else {
		return "" . _hx_string_rec($D, "");
	}
}
function datetime__DateTime_DateTime_Impl__6(&$D, &$M, &$Y, &$h, &$m, &$s, &$this1) {
	if($h < 10) {
		return "0" . _hx_string_rec($h, "");
	} else {
		return "" . _hx_string_rec($h, "");
	}
}
function datetime__DateTime_DateTime_Impl__7(&$D, &$M, &$Y, &$h, &$m, &$s, &$this1) {
	if($m < 10) {
		return "0" . _hx_string_rec($m, "");
	} else {
		return "" . _hx_string_rec($m, "");
	}
}
function datetime__DateTime_DateTime_Impl__8(&$D, &$M, &$Y, &$h, &$m, &$s, &$this1) {
	if($s < 10) {
		return "0" . _hx_string_rec($s, "");
	} else {
		return "" . _hx_string_rec($s, "");
	}
}
function datetime__DateTime_DateTime_Impl__9(&$period, &$this1, &$time) {
	{
		$this2 = datetime__DateTime_DateTime_Impl_::add($this1, $period);
		return $this2 - 62135596800.0;
	}
}
function datetime__DateTime_DateTime_Impl__10(&$period, &$this1, &$time) {
	{
		$this2 = datetime__DateTime_DateTime_Impl_::sub($this1, $period);
		return $this2 - 62135596800.0;
	}
}
function datetime__DateTime_DateTime_Impl__11(&$dti, &$this1, &$time) {
	{
		$this2 = datetime__DateTimeInterval_DateTimeInterval_Impl_::subFrom($dti, $this1 - 62135596800.0 + 62135596800.0);
		return $this2 - 62135596800.0;
	}
}
function datetime__DateTime_DateTime_Impl__12(&$dti, &$this1, &$time) {
	{
		$this2 = datetime__DateTimeInterval_DateTimeInterval_Impl_::addTo($dti, $this1 - 62135596800.0 + 62135596800.0);
		return $this2 - 62135596800.0;
	}
}
