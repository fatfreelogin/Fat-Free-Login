<?php

class datetime_cores_DateTimeIntervalCore {
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		$this->seconds = -1;
		$this->minutes = -1;
		$this->hours = -1;
		$this->days = -1;
		$this->months = -1;
		$this->years = -1;
		$this->negative = false;
	}}
	public $negative;
	public $begin;
	public $end;
	public $years;
	public $months;
	public $days;
	public $hours;
	public $minutes;
	public $seconds;
	public function getYears() {
		if($this->years < 0) {
			$this->years = datetime__DateTime_DateTime_Impl_::getYear($this->end) - datetime__DateTime_DateTime_Impl_::getYear($this->begin);
			$m1 = null;
			{
				$this1 = $this->begin;
				$days = Std::int(($this1 - 62135596800.0 - datetime__DateTime_DateTime_Impl_::yearStart($this1)) / 86400) + 1;
				$m1 = datetime_utils_DateTimeMonthUtils::getMonth($days, datetime__DateTime_DateTime_Impl_::isLeapYear($this1));
			}
			$m2 = null;
			{
				$this2 = $this->end;
				$days1 = Std::int(($this2 - 62135596800.0 - datetime__DateTime_DateTime_Impl_::yearStart($this2)) / 86400) + 1;
				$m2 = datetime_utils_DateTimeMonthUtils::getMonth($days1, datetime__DateTime_DateTime_Impl_::isLeapYear($this2));
			}
			if($m2 < $m1) {
				$this->years--;
			} else {
				if($m1 === $m2) {
					$d1 = null;
					{
						$this3 = $this->begin;
						$days2 = Std::int(($this3 - 62135596800.0 - datetime__DateTime_DateTime_Impl_::yearStart($this3)) / 86400) + 1;
						$d1 = datetime_utils_DateTimeMonthUtils::getMonthDay($days2, datetime__DateTime_DateTime_Impl_::isLeapYear($this3));
					}
					$d2 = null;
					{
						$this4 = $this->end;
						$days3 = Std::int(($this4 - 62135596800.0 - datetime__DateTime_DateTime_Impl_::yearStart($this4)) / 86400) + 1;
						$d2 = datetime_utils_DateTimeMonthUtils::getMonthDay($days3, datetime__DateTime_DateTime_Impl_::isLeapYear($this4));
					}
					if($d2 < $d1) {
						$this->years--;
					} else {
						if($d1 === $d2) {
							$h1 = null;
							{
								$this5 = $this->begin;
								$h1 = Std::int(($this5 - Math::ffloor($this5 / 86400) * 86400) / 3600);
							}
							$h2 = null;
							{
								$this6 = $this->end;
								$h2 = Std::int(($this6 - Math::ffloor($this6 / 86400) * 86400) / 3600);
							}
							if($h2 < $h1) {
								$this->years--;
							} else {
								if($h2 === $h1) {
									$m11 = null;
									{
										$this7 = $this->begin;
										$m11 = Std::int(($this7 - Math::ffloor($this7 / 3600) * 3600) / 60);
									}
									$m21 = null;
									{
										$this8 = $this->end;
										$m21 = Std::int(($this8 - Math::ffloor($this8 / 3600) * 3600) / 60);
									}
									if($m21 < $m11) {
										$this->years--;
									} else {
										if($m21 === $m11 && datetime_cores_DateTimeIntervalCore_0($this, $d1, $d2, $h1, $h2, $m1, $m11, $m2, $m21) < datetime_cores_DateTimeIntervalCore_1($this, $d1, $d2, $h1, $h2, $m1, $m11, $m2, $m21)) {
											$this->years--;
										}
									}
								}
							}
						}
					}
				}
			}
		}
		return $this->years;
	}
	public function getMonths() {
		if($this->months < 0) {
			$monthBegin = null;
			{
				$this1 = $this->begin;
				$days = Std::int(($this1 - 62135596800.0 - datetime__DateTime_DateTime_Impl_::yearStart($this1)) / 86400) + 1;
				$monthBegin = datetime_utils_DateTimeMonthUtils::getMonth($days, datetime__DateTime_DateTime_Impl_::isLeapYear($this1));
			}
			$monthEnd = null;
			{
				$this2 = $this->end;
				$days1 = Std::int(($this2 - 62135596800.0 - datetime__DateTime_DateTime_Impl_::yearStart($this2)) / 86400) + 1;
				$monthEnd = datetime_utils_DateTimeMonthUtils::getMonth($days1, datetime__DateTime_DateTime_Impl_::isLeapYear($this2));
			}
			if($monthBegin <= $monthEnd) {
				$this->months = $monthEnd - $monthBegin;
			} else {
				$this->months = 12 - $monthBegin + $monthEnd;
			}
			$d1 = null;
			{
				$this3 = $this->begin;
				$days2 = Std::int(($this3 - 62135596800.0 - datetime__DateTime_DateTime_Impl_::yearStart($this3)) / 86400) + 1;
				$d1 = datetime_utils_DateTimeMonthUtils::getMonthDay($days2, datetime__DateTime_DateTime_Impl_::isLeapYear($this3));
			}
			$d2 = null;
			{
				$this4 = $this->end;
				$days3 = Std::int(($this4 - 62135596800.0 - datetime__DateTime_DateTime_Impl_::yearStart($this4)) / 86400) + 1;
				$d2 = datetime_utils_DateTimeMonthUtils::getMonthDay($days3, datetime__DateTime_DateTime_Impl_::isLeapYear($this4));
			}
			if($d2 < $d1) {
				$this->months--;
			} else {
				if($d1 === $d2) {
					$h1 = null;
					{
						$this5 = $this->begin;
						$h1 = Std::int(($this5 - Math::ffloor($this5 / 86400) * 86400) / 3600);
					}
					$h2 = null;
					{
						$this6 = $this->end;
						$h2 = Std::int(($this6 - Math::ffloor($this6 / 86400) * 86400) / 3600);
					}
					if($h2 < $h1) {
						$this->months--;
					} else {
						if($h2 === $h1) {
							$m1 = null;
							{
								$this7 = $this->begin;
								$m1 = Std::int(($this7 - Math::ffloor($this7 / 3600) * 3600) / 60);
							}
							$m2 = null;
							{
								$this8 = $this->end;
								$m2 = Std::int(($this8 - Math::ffloor($this8 / 3600) * 3600) / 60);
							}
							if($m2 < $m1) {
								$this->months--;
							} else {
								if($m2 === $m1 && datetime_cores_DateTimeIntervalCore_2($this, $d1, $d2, $h1, $h2, $m1, $m2, $monthBegin, $monthEnd) < datetime_cores_DateTimeIntervalCore_3($this, $d1, $d2, $h1, $h2, $m1, $m2, $monthBegin, $monthEnd)) {
									$this->months--;
								}
							}
						}
					}
				}
			}
		}
		return $this->months;
	}
	public function getTotalMonths() {
		return $this->getYears() * 12 + $this->getMonths();
	}
	public function getDays() {
		if($this->days < 0) {
			$dayBegin = null;
			{
				$this1 = $this->begin;
				$days = Std::int(($this1 - 62135596800.0 - datetime__DateTime_DateTime_Impl_::yearStart($this1)) / 86400) + 1;
				$dayBegin = datetime_utils_DateTimeMonthUtils::getMonthDay($days, datetime__DateTime_DateTime_Impl_::isLeapYear($this1));
			}
			$dayEnd = null;
			{
				$this2 = $this->end;
				$days1 = Std::int(($this2 - 62135596800.0 - datetime__DateTime_DateTime_Impl_::yearStart($this2)) / 86400) + 1;
				$dayEnd = datetime_utils_DateTimeMonthUtils::getMonthDay($days1, datetime__DateTime_DateTime_Impl_::isLeapYear($this2));
			}
			if($dayBegin <= $dayEnd) {
				$this->days = $dayEnd - $dayBegin;
			} else {
				$this->days = datetime_utils_DateTimeMonthUtils::days(datetime_cores_DateTimeIntervalCore_4($this, $dayBegin, $dayEnd), datetime__DateTime_DateTime_Impl_::isLeapYear($this->begin)) - $dayBegin + $dayEnd;
			}
			$h1 = null;
			{
				$this4 = $this->begin;
				$h1 = Std::int(($this4 - Math::ffloor($this4 / 86400) * 86400) / 3600);
			}
			$h2 = null;
			{
				$this5 = $this->end;
				$h2 = Std::int(($this5 - Math::ffloor($this5 / 86400) * 86400) / 3600);
			}
			if($h2 < $h1) {
				$this->days--;
			} else {
				if($h2 === $h1) {
					$m1 = null;
					{
						$this6 = $this->begin;
						$m1 = Std::int(($this6 - Math::ffloor($this6 / 3600) * 3600) / 60);
					}
					$m2 = null;
					{
						$this7 = $this->end;
						$m2 = Std::int(($this7 - Math::ffloor($this7 / 3600) * 3600) / 60);
					}
					if($m2 < $m1) {
						$this->days--;
					} else {
						if($m2 === $m1 && datetime_cores_DateTimeIntervalCore_5($this, $dayBegin, $dayEnd, $h1, $h2, $m1, $m2) < datetime_cores_DateTimeIntervalCore_6($this, $dayBegin, $dayEnd, $h1, $h2, $m1, $m2)) {
							$this->days--;
						}
					}
				}
			}
		}
		return $this->days;
	}
	public function getTotalDays() {
		return Std::int(($this->end - 62135596800.0 - ($this->begin - 62135596800.0)) / 86400);
	}
	public function getHours() {
		if($this->hours < 0) {
			$hourBegin = null;
			{
				$this1 = $this->begin;
				$hourBegin = Std::int(($this1 - Math::ffloor($this1 / 86400) * 86400) / 3600);
			}
			$hourEnd = null;
			{
				$this2 = $this->end;
				$hourEnd = Std::int(($this2 - Math::ffloor($this2 / 86400) * 86400) / 3600);
			}
			if($hourBegin <= $hourEnd) {
				$this->hours = $hourEnd - $hourBegin;
			} else {
				$this->hours = 24 - $hourBegin + $hourEnd;
			}
			$m1 = null;
			{
				$this3 = $this->begin;
				$m1 = Std::int(($this3 - Math::ffloor($this3 / 3600) * 3600) / 60);
			}
			$m2 = null;
			{
				$this4 = $this->end;
				$m2 = Std::int(($this4 - Math::ffloor($this4 / 3600) * 3600) / 60);
			}
			if($m2 < $m1) {
				$this->hours--;
			} else {
				if($m2 === $m1 && datetime_cores_DateTimeIntervalCore_7($this, $hourBegin, $hourEnd, $m1, $m2) < datetime_cores_DateTimeIntervalCore_8($this, $hourBegin, $hourEnd, $m1, $m2)) {
					$this->hours--;
				}
			}
		}
		return $this->hours;
	}
	public function getTotalHours() {
		return Std::int(($this->end - 62135596800.0 - ($this->begin - 62135596800.0)) / 3600);
	}
	public function getMinutes() {
		if($this->minutes < 0) {
			$minuteBegin = null;
			{
				$this1 = $this->begin;
				$minuteBegin = Std::int(($this1 - Math::ffloor($this1 / 3600) * 3600) / 60);
			}
			$minuteEnd = null;
			{
				$this2 = $this->end;
				$minuteEnd = Std::int(($this2 - Math::ffloor($this2 / 3600) * 3600) / 60);
			}
			if($minuteBegin <= $minuteEnd) {
				$this->minutes = $minuteEnd - $minuteBegin;
			} else {
				$this->minutes = 60 - $minuteBegin + $minuteEnd;
			}
			if(datetime_cores_DateTimeIntervalCore_9($this, $minuteBegin, $minuteEnd) < datetime_cores_DateTimeIntervalCore_10($this, $minuteBegin, $minuteEnd)) {
				$this->minutes--;
			}
		}
		return $this->minutes;
	}
	public function getTotalMinutes() {
		return Std::int(($this->end - 62135596800.0 - ($this->begin - 62135596800.0)) / 60);
	}
	public function getSeconds() {
		if($this->seconds < 0) {
			$secondBegin = null;
			{
				$this1 = $this->begin;
				$secondBegin = Std::int($this1 - Math::ffloor($this1 / 60) * 60);
			}
			$secondEnd = null;
			{
				$this2 = $this->end;
				$secondEnd = Std::int($this2 - Math::ffloor($this2 / 60) * 60);
			}
			if($secondBegin <= $secondEnd) {
				$this->seconds = $secondEnd - $secondBegin;
			} else {
				$this->seconds = 60 - $secondBegin + $secondEnd;
			}
		}
		return $this->seconds;
	}
	public function getTotalSeconds() {
		return $this->end - 62135596800.0 - ($this->begin - 62135596800.0);
	}
	public function getTotalWeeks() {
		return Std::int(($this->end - 62135596800.0 - ($this->begin - 62135596800.0)) / 604800);
	}
	public function __call($m, $a) {
		if(isset($this->$m) && is_callable($this->$m))
			return call_user_func_array($this->$m, $a);
		else if(isset($this->__dynamics[$m]) && is_callable($this->__dynamics[$m]))
			return call_user_func_array($this->__dynamics[$m], $a);
		else if('toString' == $m)
			return $this->__toString();
		else
			throw new HException('Unable to call <'.$m.'>');
	}
	function __toString() { return 'datetime.cores.DateTimeIntervalCore'; }
}
function datetime_cores_DateTimeIntervalCore_0(&$__hx__this, &$d1, &$d2, &$h1, &$h2, &$m1, &$m11, &$m2, &$m21) {
	{
		$this9 = $__hx__this->end;
		return Std::int($this9 - Math::ffloor($this9 / 60) * 60);
	}
}
function datetime_cores_DateTimeIntervalCore_1(&$__hx__this, &$d1, &$d2, &$h1, &$h2, &$m1, &$m11, &$m2, &$m21) {
	{
		$this10 = $__hx__this->begin;
		return Std::int($this10 - Math::ffloor($this10 / 60) * 60);
	}
}
function datetime_cores_DateTimeIntervalCore_2(&$__hx__this, &$d1, &$d2, &$h1, &$h2, &$m1, &$m2, &$monthBegin, &$monthEnd) {
	{
		$this9 = $__hx__this->end;
		return Std::int($this9 - Math::ffloor($this9 / 60) * 60);
	}
}
function datetime_cores_DateTimeIntervalCore_3(&$__hx__this, &$d1, &$d2, &$h1, &$h2, &$m1, &$m2, &$monthBegin, &$monthEnd) {
	{
		$this10 = $__hx__this->begin;
		return Std::int($this10 - Math::ffloor($this10 / 60) * 60);
	}
}
function datetime_cores_DateTimeIntervalCore_4(&$__hx__this, &$dayBegin, &$dayEnd) {
	{
		$this3 = $__hx__this->begin;
		$days2 = Std::int(($this3 - 62135596800.0 - datetime__DateTime_DateTime_Impl_::yearStart($this3)) / 86400) + 1;
		return datetime_utils_DateTimeMonthUtils::getMonth($days2, datetime__DateTime_DateTime_Impl_::isLeapYear($this3));
	}
}
function datetime_cores_DateTimeIntervalCore_5(&$__hx__this, &$dayBegin, &$dayEnd, &$h1, &$h2, &$m1, &$m2) {
	{
		$this8 = $__hx__this->end;
		return Std::int($this8 - Math::ffloor($this8 / 60) * 60);
	}
}
function datetime_cores_DateTimeIntervalCore_6(&$__hx__this, &$dayBegin, &$dayEnd, &$h1, &$h2, &$m1, &$m2) {
	{
		$this9 = $__hx__this->begin;
		return Std::int($this9 - Math::ffloor($this9 / 60) * 60);
	}
}
function datetime_cores_DateTimeIntervalCore_7(&$__hx__this, &$hourBegin, &$hourEnd, &$m1, &$m2) {
	{
		$this5 = $__hx__this->end;
		return Std::int($this5 - Math::ffloor($this5 / 60) * 60);
	}
}
function datetime_cores_DateTimeIntervalCore_8(&$__hx__this, &$hourBegin, &$hourEnd, &$m1, &$m2) {
	{
		$this6 = $__hx__this->begin;
		return Std::int($this6 - Math::ffloor($this6 / 60) * 60);
	}
}
function datetime_cores_DateTimeIntervalCore_9(&$__hx__this, &$minuteBegin, &$minuteEnd) {
	{
		$this3 = $__hx__this->end;
		return Std::int($this3 - Math::ffloor($this3 / 60) * 60);
	}
}
function datetime_cores_DateTimeIntervalCore_10(&$__hx__this, &$minuteBegin, &$minuteEnd) {
	{
		$this4 = $__hx__this->begin;
		return Std::int($this4 - Math::ffloor($this4 / 60) * 60);
	}
}
