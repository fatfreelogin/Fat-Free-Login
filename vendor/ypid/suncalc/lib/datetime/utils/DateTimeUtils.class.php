<?php

class datetime_utils_DateTimeUtils {
	public function __construct() {}
	static function fromString($str) { if(!php_Boot::$skip_constructor) {
		if(strlen($str) === 10 || ord(substr($str,10,1)) === 32) {
			return datetime_utils_DateTimeUtils::parse($str);
		} else {
			if(ord(substr($str,10,1)) === 84) {
				return datetime_utils_DateTimeUtils::fromIsoString($str);
			} else {
				throw new HException("`" . _hx_string_or_null($str) . "` - incorrect date/time format. Should be either `YYYY-MM-DD hh:mm:ss` or `YYYY-MM-DD` or `YYYY-MM-DDThh:mm:ss[.SSS]Z`");
			}
		}
	}}
	static function parse($str) {
		$ylength = _hx_index_of($str, "-", null);
		if($ylength < 1 || strlen($str) - $ylength !== 6 && strlen($str) - $ylength !== 15) {
			throw new HException("`" . _hx_string_or_null($str) . "` - incorrect date/time format. Should be either `YYYY-MM-DD hh:mm:ss` or `YYYY-MM-DD`");
		}
		if(strlen($str) - $ylength === 6) {
			$str .= " 00:00:00";
		}
		$year = Std::parseInt(_hx_substr($str, 0, $ylength));
		$month = Std::parseInt(_hx_substr($str, $ylength + 1, 2));
		$day = Std::parseInt(_hx_substr($str, $ylength + 4, 2));
		$hour = Std::parseInt(_hx_substr($str, $ylength + 7, 2));
		$minute = Std::parseInt(_hx_substr($str, $ylength + 10, 2));
		$second = Std::parseInt(_hx_substr($str, $ylength + 13, 2));
		if($year === null || $month === null || $day === null || $hour === null || $minute === null || $second === null) {
			throw new HException("`" . _hx_string_or_null($str) . "` - incorrect date/time format. Should be either `YYYY-MM-DD hh:mm:ss` or `YYYY-MM-DD`");
		}
		{
			$time = datetime_utils_DateTimeUtils::yearToStamp($year) + datetime_utils_DateTimeMonthUtils::toSeconds($month, ((_hx_mod($year, 4) === 0) ? datetime_utils_DateTimeUtils_0($day, $hour, $minute, $month, $second, $str, $year, $ylength) : false)) + ($day - 1) * 86400 + $hour * 3600 + $minute * 60 + $second - 62135596800.0;
			return $time + 62135596800.0;
		}
	}
	static function fromIsoString($str) {
		$dotPos = _hx_index_of($str, ".", null);
		$zPos = _hx_index_of($str, "Z", null);
		if(ord(substr($str,strlen($str) - 1,1)) !== 90) {
			throw new HException("`" . _hx_string_or_null($str) . "` - incorrect date/time format. Not an ISO 8601 UTC/Zulu string: Z not found.");
		}
		if(strlen($str) > 20) {
			if(ord(substr($str,19,1)) !== 46) {
				throw new HException("`" . _hx_string_or_null($str) . "` - incorrect date/time format. Not an ISO 8601 string: Millisecond specification erroneous.");
			}
			if(ord(substr($str,23,1)) !== 90) {
				throw new HException("`" . _hx_string_or_null($str) . "` - incorrect date/time format. Not an ISO 8601 string: Timezone specification erroneous.");
			}
		}
		return datetime_utils_DateTimeUtils::parse(_hx_string_or_null(_hx_substr($str, 0, 10)) . " " . _hx_string_or_null(_hx_substr($str, 11, 8)));
	}
	static function clamp($value, $min, $max) {
		if($value < $min) {
			return $min;
		} else {
			if($value > $max) {
				return $max;
			} else {
				return $value;
			}
		}
	}
	static function yearToStamp($year) {
		$year--;
		$cquads = Std::int($year / 400);
		$quads = Std::int(($year - $cquads * 400) / 4);
		$excessDays = Std::int($quads / 25);
		return $cquads * 12622780800.0 + $quads * 126230400.0 - $excessDays * 86400 + ($year - $cquads * 400 - $quads * 4) * 31536000;
	}
	static function addYear($dt, $amount) {
		$year = datetime__DateTime_DateTime_Impl_::getYear($dt) + $amount;
		$time = $dt - 62135596800.0 - (datetime__DateTime_DateTime_Impl_::yearStart($dt) + datetime_utils_DateTimeMonthUtils::toSeconds(datetime_utils_DateTimeUtils_1($amount, $dt, $year), datetime__DateTime_DateTime_Impl_::isLeapYear($dt)));
		return datetime_utils_DateTimeUtils::yearToStamp($year) + datetime_utils_DateTimeMonthUtils::toSeconds(datetime_utils_DateTimeUtils_2($amount, $dt, $time, $year), ((_hx_mod($year, 4) === 0) ? datetime_utils_DateTimeUtils_3($amount, $dt, $time, $year) : false)) + $time - 62135596800.0;
	}
	static function addMonth($dt, $amount) {
		$month = null;
		$month = datetime_utils_DateTimeUtils_4($amount, $dt, $month) + $amount;
		if($month >= 12) {
			$years = Std::int($month / 12);
			{
				$time = datetime_utils_DateTimeUtils::addYear($dt, $years);
				$dt = $time + 62135596800.0;
			}
			$month -= $years * 12;
		} else {
			if($month < 0) {
				$years1 = Std::int($month / 12) - 1;
				{
					$time1 = datetime_utils_DateTimeUtils::addYear($dt, $years1);
					$dt = $time1 + 62135596800.0;
				}
				$month -= $years1 * 12;
			}
		}
		$isLeap = datetime__DateTime_DateTime_Impl_::isLeapYear($dt);
		$day = null;
		{
			$value = null;
			{
				$days1 = Std::int(($dt - 62135596800.0 - datetime__DateTime_DateTime_Impl_::yearStart($dt)) / 86400) + 1;
				$value = datetime_utils_DateTimeMonthUtils::getMonthDay($days1, datetime__DateTime_DateTime_Impl_::isLeapYear($dt));
			}
			$max = datetime_utils_DateTimeMonthUtils::days($month, $isLeap);
			if($value < 1) {
				$day = 1;
			} else {
				if($value > $max) {
					$day = $max;
				} else {
					$day = $value;
				}
			}
		}
		return datetime__DateTime_DateTime_Impl_::yearStart($dt) + datetime_utils_DateTimeMonthUtils::toSeconds($month, $isLeap) + ($day - 1) * 86400 + Std::int(($dt - Math::ffloor($dt / 86400) * 86400) / 3600) * 3600 + Std::int(($dt - Math::ffloor($dt / 3600) * 3600) / 60) * 60 + Std::int($dt - Math::ffloor($dt / 60) * 60);
	}
	static function getWeekDayNum($dt, $weekDay, $num) {
		$month = null;
		{
			$days = Std::int(($dt - 62135596800.0 - datetime__DateTime_DateTime_Impl_::yearStart($dt)) / 86400) + 1;
			$month = datetime_utils_DateTimeMonthUtils::getMonth($days, datetime__DateTime_DateTime_Impl_::isLeapYear($dt));
		}
		if($num > 0) {
			$start = null;
			{
				$time = datetime__DateTime_DateTime_Impl_::monthStart($dt, $month) - 1;
				$start = $time + 62135596800.0;
			}
			$first = datetime__DateTime_DateTime_Impl_::snap($start, datetime_DTSnap::Week(1, $weekDay));
			{
				$this1 = null;
				{
					$period = datetime_DTPeriod::Week($num - 1);
					$this1 = datetime__DateTime_DateTime_Impl_::add($first, $period);
				}
				return $this1 - 62135596800.0;
			}
		} else {
			if($num < 0) {
				$start1 = null;
				{
					$time1 = datetime__DateTime_DateTime_Impl_::monthStart($dt, $month + 1) - 1;
					$start1 = $time1 + 62135596800.0;
				}
				$first1 = datetime__DateTime_DateTime_Impl_::snap($start1, datetime_DTSnap::Week(-1, $weekDay));
				{
					$this2 = null;
					{
						$period1 = datetime_DTPeriod::Week($num + 1);
						$this2 = datetime__DateTime_DateTime_Impl_::add($first1, $period1);
					}
					return $this2 - 62135596800.0;
				}
			} else {
				return $dt - 62135596800.0;
			}
		}
	}
	static function strftime($dt, $format) {
		$prevPos = 0;
		$pos = _hx_index_of($format, "%", null);
		$str = "";
		while($pos >= 0) {
			$str .= _hx_string_or_null(_hx_substring($format, $prevPos, $pos));
			$pos++;
			{
				$_g = ord(substr($format,$pos,1));
				switch($_g) {
				case 100:{
					$s = null;
					$s = _hx_string_rec(datetime_utils_DateTimeUtils_5($_g, $dt, $format, $pos, $prevPos, $s, $str), "") . "";
					if(strlen("0") === 0 || strlen($s) >= 2) {
						$str .= _hx_string_or_null($s);
					} else {
						$str .= _hx_string_or_null(str_pad($s, Math::ceil((2 - strlen($s)) / strlen("0")) * strlen("0") + strlen($s), "0", STR_PAD_LEFT));
					}
				}break;
				case 101:{
					$s1 = null;
					$s1 = _hx_string_rec(datetime_utils_DateTimeUtils_6($_g, $dt, $format, $pos, $prevPos, $s1, $str), "") . "";
					if(strlen(" ") === 0 || strlen($s1) >= 2) {
						$str .= _hx_string_or_null($s1);
					} else {
						$str .= _hx_string_or_null(str_pad($s1, Math::ceil((2 - strlen($s1)) / strlen(" ")) * strlen(" ") + strlen($s1), " ", STR_PAD_LEFT));
					}
				}break;
				case 106:{
					$day = Std::int(($dt - 62135596800.0 - datetime__DateTime_DateTime_Impl_::yearStart($dt)) / 86400) + 1;
					{
						$s2 = "" . _hx_string_rec($day, "");
						if(strlen("0") === 0 || strlen($s2) >= 3) {
							$str .= _hx_string_or_null($s2);
						} else {
							$str .= _hx_string_or_null(str_pad($s2, Math::ceil((3 - strlen($s2)) / strlen("0")) * strlen("0") + strlen($s2), "0", STR_PAD_LEFT));
						}
					}
				}break;
				case 117:{
					$str .= _hx_string_rec(datetime__DateTime_DateTime_Impl_::getWeekDay($dt, true), "") . "";
				}break;
				case 119:{
					$str .= _hx_string_rec(datetime__DateTime_DateTime_Impl_::getWeekDay($dt, null), "") . "";
				}break;
				case 109:{
					$s3 = null;
					$s3 = _hx_string_rec(datetime_utils_DateTimeUtils_7($_g, $dt, $format, $pos, $prevPos, $s3, $str), "") . "";
					if(strlen("0") === 0 || strlen($s3) >= 2) {
						$str .= _hx_string_or_null($s3);
					} else {
						$str .= _hx_string_or_null(str_pad($s3, Math::ceil((2 - strlen($s3)) / strlen("0")) * strlen("0") + strlen($s3), "0", STR_PAD_LEFT));
					}
				}break;
				case 67:{
					$s4 = _hx_string_rec(Std::int(datetime__DateTime_DateTime_Impl_::getYear($dt) / 100), "") . "";
					if(strlen("0") === 0 || strlen($s4) >= 2) {
						$str .= _hx_string_or_null($s4);
					} else {
						$str .= _hx_string_or_null(str_pad($s4, Math::ceil((2 - strlen($s4)) / strlen("0")) * strlen("0") + strlen($s4), "0", STR_PAD_LEFT));
					}
				}break;
				case 121:{
					$s5 = _hx_substr((_hx_string_rec(datetime__DateTime_DateTime_Impl_::getYear($dt), "") . ""), -2, null);
					if(strlen("0") === 0 || strlen($s5) >= 2) {
						$str .= _hx_string_or_null($s5);
					} else {
						$str .= _hx_string_or_null(str_pad($s5, Math::ceil((2 - strlen($s5)) / strlen("0")) * strlen("0") + strlen($s5), "0", STR_PAD_LEFT));
					}
				}break;
				case 89:{
					$str .= _hx_string_rec(datetime__DateTime_DateTime_Impl_::getYear($dt), "") . "";
				}break;
				case 86:{
					$s6 = _hx_string_rec(datetime__DateTime_DateTime_Impl_::getWeek($dt), "") . "";
					if(strlen("0") === 0 || strlen($s6) >= 2) {
						$str .= _hx_string_or_null($s6);
					} else {
						$str .= _hx_string_or_null(str_pad($s6, Math::ceil((2 - strlen($s6)) / strlen("0")) * strlen("0") + strlen($s6), "0", STR_PAD_LEFT));
					}
				}break;
				case 72:{
					$s7 = _hx_string_rec(Std::int(($dt - Math::ffloor($dt / 86400) * 86400) / 3600), "") . "";
					if(strlen("0") === 0 || strlen($s7) >= 2) {
						$str .= _hx_string_or_null($s7);
					} else {
						$str .= _hx_string_or_null(str_pad($s7, Math::ceil((2 - strlen($s7)) / strlen("0")) * strlen("0") + strlen($s7), "0", STR_PAD_LEFT));
					}
				}break;
				case 107:{
					$s8 = _hx_string_rec(Std::int(($dt - Math::ffloor($dt / 86400) * 86400) / 3600), "") . "";
					if(strlen(" ") === 0 || strlen($s8) >= 2) {
						$str .= _hx_string_or_null($s8);
					} else {
						$str .= _hx_string_or_null(str_pad($s8, Math::ceil((2 - strlen($s8)) / strlen(" ")) * strlen(" ") + strlen($s8), " ", STR_PAD_LEFT));
					}
				}break;
				case 73:{
					$s9 = _hx_string_rec(datetime__DateTime_DateTime_Impl_::getHour12($dt), "") . "";
					if(strlen("0") === 0 || strlen($s9) >= 2) {
						$str .= _hx_string_or_null($s9);
					} else {
						$str .= _hx_string_or_null(str_pad($s9, Math::ceil((2 - strlen($s9)) / strlen("0")) * strlen("0") + strlen($s9), "0", STR_PAD_LEFT));
					}
				}break;
				case 108:{
					$s10 = _hx_string_rec(datetime__DateTime_DateTime_Impl_::getHour12($dt), "") . "";
					if(strlen(" ") === 0 || strlen($s10) >= 2) {
						$str .= _hx_string_or_null($s10);
					} else {
						$str .= _hx_string_or_null(str_pad($s10, Math::ceil((2 - strlen($s10)) / strlen(" ")) * strlen(" ") + strlen($s10), " ", STR_PAD_LEFT));
					}
				}break;
				case 77:{
					$s11 = _hx_string_rec(Std::int(($dt - Math::ffloor($dt / 3600) * 3600) / 60), "") . "";
					if(strlen("0") === 0 || strlen($s11) >= 2) {
						$str .= _hx_string_or_null($s11);
					} else {
						$str .= _hx_string_or_null(str_pad($s11, Math::ceil((2 - strlen($s11)) / strlen("0")) * strlen("0") + strlen($s11), "0", STR_PAD_LEFT));
					}
				}break;
				case 112:{
					if(Std::int(($dt - Math::ffloor($dt / 86400) * 86400) / 3600) < 12) {
						$str .= "AM";
					} else {
						$str .= "PM";
					}
				}break;
				case 80:{
					if(Std::int(($dt - Math::ffloor($dt / 86400) * 86400) / 3600) < 12) {
						$str .= "am";
					} else {
						$str .= "pm";
					}
				}break;
				case 114:{
					$str .= _hx_string_or_null(datetime_utils_DateTimeUtils_8($_g, $dt, $format, $pos, $prevPos, $str)) . _hx_string_or_null(datetime_utils_DateTimeUtils_9($_g, $dt, $format, $pos, $prevPos, $str)) . _hx_string_or_null(datetime_utils_DateTimeUtils_10($_g, $dt, $format, $pos, $prevPos, $str));
				}break;
				case 82:{
					$str .= _hx_string_or_null(datetime_utils_DateTimeUtils_11($_g, $dt, $format, $pos, $prevPos, $str)) . _hx_string_or_null(datetime_utils_DateTimeUtils_12($_g, $dt, $format, $pos, $prevPos, $str));
				}break;
				case 83:{
					$s17 = _hx_string_rec(Std::int($dt - Math::ffloor($dt / 60) * 60), "") . "";
					if(strlen("0") === 0 || strlen($s17) >= 2) {
						$str .= _hx_string_or_null($s17);
					} else {
						$str .= _hx_string_or_null(str_pad($s17, Math::ceil((2 - strlen($s17)) / strlen("0")) * strlen("0") + strlen($s17), "0", STR_PAD_LEFT));
					}
				}break;
				case 84:{
					$str .= _hx_string_or_null(datetime_utils_DateTimeUtils_13($_g, $dt, $format, $pos, $prevPos, $str)) . _hx_string_or_null(datetime_utils_DateTimeUtils_14($_g, $dt, $format, $pos, $prevPos, $str)) . _hx_string_or_null(datetime_utils_DateTimeUtils_15($_g, $dt, $format, $pos, $prevPos, $str));
				}break;
				case 68:{
					$str .= _hx_string_or_null(datetime_utils_DateTimeUtils_16($_g, $dt, $format, $pos, $prevPos, $str)) . _hx_string_or_null(datetime_utils_DateTimeUtils_17($_g, $dt, $format, $pos, $prevPos, $str)) . _hx_string_or_null(datetime_utils_DateTimeUtils_18($_g, $dt, $format, $pos, $prevPos, $str));
				}break;
				case 70:{
					$str .= _hx_string_rec(datetime__DateTime_DateTime_Impl_::getYear($dt), "") . "-" . _hx_string_or_null(datetime_utils_DateTimeUtils_19($_g, $dt, $format, $pos, $prevPos, $str)) . _hx_string_or_null(datetime_utils_DateTimeUtils_20($_g, $dt, $format, $pos, $prevPos, $str));
				}break;
				case 115:{
					$str .= _hx_string_rec($dt - 62135596800.0, "") . "";
				}break;
				case 37:{
					$str .= "%";
				}break;
				}
				unset($_g);
			}
			$prevPos = $pos + 1;
			$pos = _hx_index_of($format, "%", $pos + 1);
		}
		$str .= _hx_string_or_null(_hx_substring($format, $prevPos, null));
		return $str;
	}
	function __toString() { return 'datetime.utils.DateTimeUtils'; }
}
function datetime_utils_DateTimeUtils_0(&$day, &$hour, &$minute, &$month, &$second, &$str, &$year, &$ylength) {
	if(_hx_mod($year, 100) === 0) {
		return _hx_mod($year, 400) === 0;
	} else {
		return true;
	}
}
function datetime_utils_DateTimeUtils_1(&$amount, &$dt, &$year) {
	{
		$days = Std::int(($dt - 62135596800.0 - datetime__DateTime_DateTime_Impl_::yearStart($dt)) / 86400) + 1;
		return datetime_utils_DateTimeMonthUtils::getMonth($days, datetime__DateTime_DateTime_Impl_::isLeapYear($dt));
	}
}
function datetime_utils_DateTimeUtils_2(&$amount, &$dt, &$time, &$year) {
	{
		$days1 = Std::int(($dt - 62135596800.0 - datetime__DateTime_DateTime_Impl_::yearStart($dt)) / 86400) + 1;
		return datetime_utils_DateTimeMonthUtils::getMonth($days1, datetime__DateTime_DateTime_Impl_::isLeapYear($dt));
	}
}
function datetime_utils_DateTimeUtils_3(&$amount, &$dt, &$time, &$year) {
	if(_hx_mod($year, 100) === 0) {
		return _hx_mod($year, 400) === 0;
	} else {
		return true;
	}
}
function datetime_utils_DateTimeUtils_4(&$amount, &$dt, &$month) {
	{
		$days = Std::int(($dt - 62135596800.0 - datetime__DateTime_DateTime_Impl_::yearStart($dt)) / 86400) + 1;
		return datetime_utils_DateTimeMonthUtils::getMonth($days, datetime__DateTime_DateTime_Impl_::isLeapYear($dt));
	}
}
function datetime_utils_DateTimeUtils_5(&$_g, &$dt, &$format, &$pos, &$prevPos, &$s, &$str) {
	{
		$days = Std::int(($dt - 62135596800.0 - datetime__DateTime_DateTime_Impl_::yearStart($dt)) / 86400) + 1;
		return datetime_utils_DateTimeMonthUtils::getMonthDay($days, datetime__DateTime_DateTime_Impl_::isLeapYear($dt));
	}
}
function datetime_utils_DateTimeUtils_6(&$_g, &$dt, &$format, &$pos, &$prevPos, &$s1, &$str) {
	{
		$days1 = Std::int(($dt - 62135596800.0 - datetime__DateTime_DateTime_Impl_::yearStart($dt)) / 86400) + 1;
		return datetime_utils_DateTimeMonthUtils::getMonthDay($days1, datetime__DateTime_DateTime_Impl_::isLeapYear($dt));
	}
}
function datetime_utils_DateTimeUtils_7(&$_g, &$dt, &$format, &$pos, &$prevPos, &$s3, &$str) {
	{
		$days2 = Std::int(($dt - 62135596800.0 - datetime__DateTime_DateTime_Impl_::yearStart($dt)) / 86400) + 1;
		return datetime_utils_DateTimeMonthUtils::getMonth($days2, datetime__DateTime_DateTime_Impl_::isLeapYear($dt));
	}
}
function datetime_utils_DateTimeUtils_8(&$_g, &$dt, &$format, &$pos, &$prevPos, &$str) {
	{
		$s12 = _hx_string_rec(datetime__DateTime_DateTime_Impl_::getHour12($dt), "") . ":";
		if(strlen("0") === 0 || strlen($s12) >= 3) {
			return $s12;
		} else {
			return str_pad($s12, Math::ceil((3 - strlen($s12)) / strlen("0")) * strlen("0") + strlen($s12), "0", STR_PAD_LEFT);
		}
		unset($s12);
	}
}
function datetime_utils_DateTimeUtils_9(&$_g, &$dt, &$format, &$pos, &$prevPos, &$str) {
	{
		$s13 = _hx_string_rec(Std::int(($dt - Math::ffloor($dt / 3600) * 3600) / 60), "") . ":";
		if(strlen("0") === 0 || strlen($s13) >= 3) {
			return $s13;
		} else {
			return str_pad($s13, Math::ceil((3 - strlen($s13)) / strlen("0")) * strlen("0") + strlen($s13), "0", STR_PAD_LEFT);
		}
		unset($s13);
	}
}
function datetime_utils_DateTimeUtils_10(&$_g, &$dt, &$format, &$pos, &$prevPos, &$str) {
	{
		$s14 = _hx_string_rec(Std::int($dt - Math::ffloor($dt / 60) * 60), "") . "";
		if(strlen("0") === 0 || strlen($s14) >= 2) {
			return $s14;
		} else {
			return str_pad($s14, Math::ceil((2 - strlen($s14)) / strlen("0")) * strlen("0") + strlen($s14), "0", STR_PAD_LEFT);
		}
		unset($s14);
	}
}
function datetime_utils_DateTimeUtils_11(&$_g, &$dt, &$format, &$pos, &$prevPos, &$str) {
	{
		$s15 = _hx_string_rec(Std::int(($dt - Math::ffloor($dt / 86400) * 86400) / 3600), "") . ":";
		if(strlen("0") === 0 || strlen($s15) >= 3) {
			return $s15;
		} else {
			return str_pad($s15, Math::ceil((3 - strlen($s15)) / strlen("0")) * strlen("0") + strlen($s15), "0", STR_PAD_LEFT);
		}
		unset($s15);
	}
}
function datetime_utils_DateTimeUtils_12(&$_g, &$dt, &$format, &$pos, &$prevPos, &$str) {
	{
		$s16 = _hx_string_rec(Std::int(($dt - Math::ffloor($dt / 3600) * 3600) / 60), "") . "";
		if(strlen("0") === 0 || strlen($s16) >= 2) {
			return $s16;
		} else {
			return str_pad($s16, Math::ceil((2 - strlen($s16)) / strlen("0")) * strlen("0") + strlen($s16), "0", STR_PAD_LEFT);
		}
		unset($s16);
	}
}
function datetime_utils_DateTimeUtils_13(&$_g, &$dt, &$format, &$pos, &$prevPos, &$str) {
	{
		$s18 = _hx_string_rec(Std::int(($dt - Math::ffloor($dt / 86400) * 86400) / 3600), "") . ":";
		if(strlen("0") === 0 || strlen($s18) >= 3) {
			return $s18;
		} else {
			return str_pad($s18, Math::ceil((3 - strlen($s18)) / strlen("0")) * strlen("0") + strlen($s18), "0", STR_PAD_LEFT);
		}
		unset($s18);
	}
}
function datetime_utils_DateTimeUtils_14(&$_g, &$dt, &$format, &$pos, &$prevPos, &$str) {
	{
		$s19 = _hx_string_rec(Std::int(($dt - Math::ffloor($dt / 3600) * 3600) / 60), "") . ":";
		if(strlen("0") === 0 || strlen($s19) >= 3) {
			return $s19;
		} else {
			return str_pad($s19, Math::ceil((3 - strlen($s19)) / strlen("0")) * strlen("0") + strlen($s19), "0", STR_PAD_LEFT);
		}
		unset($s19);
	}
}
function datetime_utils_DateTimeUtils_15(&$_g, &$dt, &$format, &$pos, &$prevPos, &$str) {
	{
		$s20 = _hx_string_rec(Std::int($dt - Math::ffloor($dt / 60) * 60), "") . "";
		if(strlen("0") === 0 || strlen($s20) >= 2) {
			return $s20;
		} else {
			return str_pad($s20, Math::ceil((2 - strlen($s20)) / strlen("0")) * strlen("0") + strlen($s20), "0", STR_PAD_LEFT);
		}
		unset($s20);
	}
}
function datetime_utils_DateTimeUtils_16(&$_g, &$dt, &$format, &$pos, &$prevPos, &$str) {
	{
		$s21 = null;
		$s21 = _hx_string_rec(datetime_utils_DateTimeUtils_21($_g, $dt, $format, $pos, $prevPos, $s21, $str), "") . "/";
		if(strlen("0") === 0 || strlen($s21) >= 3) {
			return $s21;
		} else {
			return str_pad($s21, Math::ceil((3 - strlen($s21)) / strlen("0")) * strlen("0") + strlen($s21), "0", STR_PAD_LEFT);
		}
		unset($s21);
	}
}
function datetime_utils_DateTimeUtils_17(&$_g, &$dt, &$format, &$pos, &$prevPos, &$str) {
	{
		$s22 = null;
		$s22 = _hx_string_rec(datetime_utils_DateTimeUtils_22($_g, $dt, $format, $pos, $prevPos, $s22, $str), "") . "/";
		if(strlen("0") === 0 || strlen($s22) >= 3) {
			return $s22;
		} else {
			return str_pad($s22, Math::ceil((3 - strlen($s22)) / strlen("0")) * strlen("0") + strlen($s22), "0", STR_PAD_LEFT);
		}
		unset($s22);
	}
}
function datetime_utils_DateTimeUtils_18(&$_g, &$dt, &$format, &$pos, &$prevPos, &$str) {
	{
		$s23 = _hx_substr((_hx_string_rec(datetime__DateTime_DateTime_Impl_::getYear($dt), "") . ""), -2, null);
		if(strlen("0") === 0 || strlen($s23) >= 2) {
			return $s23;
		} else {
			return str_pad($s23, Math::ceil((2 - strlen($s23)) / strlen("0")) * strlen("0") + strlen($s23), "0", STR_PAD_LEFT);
		}
		unset($s23);
	}
}
function datetime_utils_DateTimeUtils_19(&$_g, &$dt, &$format, &$pos, &$prevPos, &$str) {
	{
		$s24 = null;
		$s24 = _hx_string_rec(datetime_utils_DateTimeUtils_23($_g, $dt, $format, $pos, $prevPos, $s24, $str), "") . "-";
		if(strlen("0") === 0 || strlen($s24) >= 3) {
			return $s24;
		} else {
			return str_pad($s24, Math::ceil((3 - strlen($s24)) / strlen("0")) * strlen("0") + strlen($s24), "0", STR_PAD_LEFT);
		}
		unset($s24);
	}
}
function datetime_utils_DateTimeUtils_20(&$_g, &$dt, &$format, &$pos, &$prevPos, &$str) {
	{
		$s25 = null;
		$s25 = _hx_string_rec(datetime_utils_DateTimeUtils_24($_g, $dt, $format, $pos, $prevPos, $s25, $str), "") . "";
		if(strlen("0") === 0 || strlen($s25) >= 2) {
			return $s25;
		} else {
			return str_pad($s25, Math::ceil((2 - strlen($s25)) / strlen("0")) * strlen("0") + strlen($s25), "0", STR_PAD_LEFT);
		}
		unset($s25);
	}
}
function datetime_utils_DateTimeUtils_21(&$_g, &$dt, &$format, &$pos, &$prevPos, &$s21, &$str) {
	{
		$days3 = Std::int(($dt - 62135596800.0 - datetime__DateTime_DateTime_Impl_::yearStart($dt)) / 86400) + 1;
		return datetime_utils_DateTimeMonthUtils::getMonth($days3, datetime__DateTime_DateTime_Impl_::isLeapYear($dt));
	}
}
function datetime_utils_DateTimeUtils_22(&$_g, &$dt, &$format, &$pos, &$prevPos, &$s22, &$str) {
	{
		$days4 = Std::int(($dt - 62135596800.0 - datetime__DateTime_DateTime_Impl_::yearStart($dt)) / 86400) + 1;
		return datetime_utils_DateTimeMonthUtils::getMonthDay($days4, datetime__DateTime_DateTime_Impl_::isLeapYear($dt));
	}
}
function datetime_utils_DateTimeUtils_23(&$_g, &$dt, &$format, &$pos, &$prevPos, &$s24, &$str) {
	{
		$days5 = Std::int(($dt - 62135596800.0 - datetime__DateTime_DateTime_Impl_::yearStart($dt)) / 86400) + 1;
		return datetime_utils_DateTimeMonthUtils::getMonth($days5, datetime__DateTime_DateTime_Impl_::isLeapYear($dt));
	}
}
function datetime_utils_DateTimeUtils_24(&$_g, &$dt, &$format, &$pos, &$prevPos, &$s25, &$str) {
	{
		$days6 = Std::int(($dt - 62135596800.0 - datetime__DateTime_DateTime_Impl_::yearStart($dt)) / 86400) + 1;
		return datetime_utils_DateTimeMonthUtils::getMonthDay($days6, datetime__DateTime_DateTime_Impl_::isLeapYear($dt));
	}
}
