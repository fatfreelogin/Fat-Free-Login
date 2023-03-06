<?php

class datetime_utils_DateTimeSnapUtils {
	public function __construct() {}
	static function snapYear($dt, $direction) { if(!php_Boot::$skip_constructor) {
		switch($direction) {
		case -1:{
			return datetime__DateTime_DateTime_Impl_::yearStart($dt);
		}break;
		case 1:{
			$next = null;
			{
				$time = datetime_utils_DateTimeUtils::addYear($dt, 1);
				$next = $time + 62135596800.0;
			}
			return datetime__DateTime_DateTime_Impl_::yearStart($next);
		}break;
		case 0:{
			$next1 = datetime__DateTime_DateTime_Impl_::yearStart(datetime_utils_DateTimeSnapUtils_0($direction, $dt));
			$previous = datetime__DateTime_DateTime_Impl_::yearStart($dt);
			if($next1 - ($dt - 62135596800.0) > $dt - 62135596800.0 - $previous) {
				return $previous;
			} else {
				return $next1;
			}
		}break;
		}
	}}
	static function snapMonth($dt, $direction) {
		$month = null;
		{
			$days = Std::int(($dt - 62135596800.0 - datetime__DateTime_DateTime_Impl_::yearStart($dt)) / 86400) + 1;
			$month = datetime_utils_DateTimeMonthUtils::getMonth($days, datetime__DateTime_DateTime_Impl_::isLeapYear($dt));
		}
		$isLeap = datetime__DateTime_DateTime_Impl_::isLeapYear($dt);
		switch($direction) {
		case -1:{
			return datetime__DateTime_DateTime_Impl_::yearStart($dt) + datetime_utils_DateTimeMonthUtils::toSeconds($month, $isLeap);
		}break;
		case 1:{
			return datetime__DateTime_DateTime_Impl_::yearStart($dt) + datetime_utils_DateTimeMonthUtils::toSeconds($month, $isLeap) + datetime_utils_DateTimeMonthUtils::days($month, $isLeap) * 86400;
		}break;
		case 0:{
			$previous = datetime__DateTime_DateTime_Impl_::yearStart($dt) + datetime_utils_DateTimeMonthUtils::toSeconds($month, $isLeap);
			$next = datetime__DateTime_DateTime_Impl_::yearStart($dt) + datetime_utils_DateTimeMonthUtils::toSeconds($month, $isLeap) + datetime_utils_DateTimeMonthUtils::days($month, $isLeap) * 86400;
			if($next - ($dt - 62135596800.0) > $dt - 62135596800.0 - $previous) {
				return $previous;
			} else {
				return $next;
			}
		}break;
		}
	}
	static function snapDay($dt, $direction) {
		$days = ($dt - 62135596800.0) / 86400;
		switch($direction) {
		case -1:{
			return Math::ffloor($days) * 86400;
		}break;
		case 1:{
			return Math::fceil($days) * 86400;
		}break;
		case 0:{
			return Math::fround($days) * 86400;
		}break;
		}
	}
	static function snapHour($dt, $direction) {
		$hours = ($dt - 62135596800.0) / 3600;
		switch($direction) {
		case -1:{
			return Math::ffloor($hours) * 3600;
		}break;
		case 1:{
			return Math::fceil($hours) * 3600;
		}break;
		case 0:{
			return Math::fround($hours) * 3600;
		}break;
		}
	}
	static function snapMinute($dt, $direction) {
		$minutes = ($dt - 62135596800.0) / 60;
		switch($direction) {
		case -1:{
			return Math::ffloor($minutes) * 60;
		}break;
		case 1:{
			return Math::fceil($minutes) * 60;
		}break;
		case 0:{
			return Math::fround($minutes) * 60;
		}break;
		}
	}
	static function snapWeek($dt, $direction, $required) {
		$current = datetime__DateTime_DateTime_Impl_::getWeekDay($dt, null);
		$days = Math::ffloor(($dt - 62135596800.0) / 86400);
		switch($direction) {
		case -1:{
			$diff = null;
			if($current >= $required) {
				$diff = $current - $required;
			} else {
				$diff = $current + 7 - $required;
			}
			return ($days - $diff) * 86400;
		}break;
		case 1:{
			$diff1 = null;
			if($required > $current) {
				$diff1 = $required - $current;
			} else {
				$diff1 = $required + 7 - $current;
			}
			return ($days + $diff1) * 86400;
		}break;
		case 0:{
			$diff2 = null;
			if($current >= $required) {
				$diff2 = $current - $required;
			} else {
				$diff2 = $current + 7 - $required;
			}
			$previous = ($days - $diff2) * 86400;
			$diff3 = null;
			if($required > $current) {
				$diff3 = $required - $current;
			} else {
				$diff3 = $required + 7 - $current;
			}
			$next = ($days + $diff3) * 86400;
			if($next - ($dt - 62135596800.0) > $dt - 62135596800.0 - $previous) {
				return $previous;
			} else {
				return $next;
			}
		}break;
		}
	}
	function __toString() { return 'datetime.utils.DateTimeSnapUtils'; }
}
function datetime_utils_DateTimeSnapUtils_0(&$direction, &$dt) {
	{
		$time1 = datetime_utils_DateTimeUtils::addYear($dt, 1);
		return $time1 + 62135596800.0;
	}
}
