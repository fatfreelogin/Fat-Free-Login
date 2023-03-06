<?php

class datetime__DateTimeInterval_DateTimeInterval_Impl_ {
	public function __construct(){}
	static function create($begin, $end) {
		$dtic = new datetime_cores_DateTimeIntervalCore();
		if($end - 62135596800.0 < $begin - 62135596800.0) {
			$dtic->begin = $end;
		} else {
			$dtic->begin = $begin;
		}
		if($end - 62135596800.0 < $begin - 62135596800.0) {
			$dtic->end = $begin;
		} else {
			$dtic->end = $end;
		}
		$dtic->negative = $end - 62135596800.0 < $begin - 62135596800.0;
		return $dtic;
	}
	static function _new($dtic) {
		return $dtic;
	}
	static function invert($this1) {
		$this1->negative = !$this1->negative;
		return $this1;
	}
	static function addTo($this1, $dt) {
		return $dt - 62135596800.0 + ((($this1->negative) ? -1 : 1)) * ($this1->end - 62135596800.0 - ($this1->begin - 62135596800.0)) + 62135596800.0;
	}
	static function subFrom($this1, $dt) {
		return $dt - 62135596800.0 - ((($this1->negative) ? -1 : 1)) * ($this1->end - 62135596800.0 - ($this1->begin - 62135596800.0)) + 62135596800.0;
	}
	static function toString($this1) {
		$years = $this1->getYears();
		$months = $this1->getMonths();
		$days = $this1->getDays();
		$hours = $this1->getHours();
		$minutes = $this1->getMinutes();
		$seconds = $this1->getSeconds();
		$parts = (new _hx_array(array()));
		if($years !== 0) {
			$parts->push("" . _hx_string_rec($years, "") . "y");
		}
		if($months !== 0) {
			$parts->push("" . _hx_string_rec($months, "") . "m");
		}
		if($days !== 0) {
			$parts->push("" . _hx_string_rec($days, "") . "d");
		}
		if($hours !== 0) {
			$parts->push("" . _hx_string_rec($hours, "") . "hrs");
		}
		if($minutes !== 0) {
			$parts->push("" . _hx_string_rec($minutes, "") . "min");
		}
		if($seconds !== 0) {
			$parts->push("" . _hx_string_rec($seconds, "") . "sec");
		}
		return _hx_string_or_null(((($this1->negative) ? "-" : ""))) . "(" . _hx_string_or_null(((($parts->length === 0) ? "0sec" : $parts->join(", ")))) . ")";
	}
	static function sign($this1) {
		if($this1->negative) {
			return -1;
		} else {
			return 1;
		}
	}
	static function format($this1, $format) {
		return datetime_utils_DateTimeIntervalUtils::strftime($this1, $format);
	}
	static function formatPartial($this1, $format) {
		return datetime_utils_DateTimeIntervalUtils::formatPartial($this1, $format);
	}
	static function eq($this1, $dtic) {
		return $this1->getTotalSeconds() === $dtic->getTotalSeconds();
	}
	static function gt($this1, $dtic) {
		return $this1->getTotalSeconds() > $dtic->getTotalSeconds();
	}
	static function gte($this1, $dtic) {
		return $this1->getTotalSeconds() >= $dtic->getTotalSeconds();
	}
	static function lt($this1, $dtic) {
		return $this1->getTotalSeconds() < $dtic->getTotalSeconds();
	}
	static function lte($this1, $dtic) {
		return $this1->getTotalSeconds() <= $dtic->getTotalSeconds();
	}
	static function neq($this1, $dtic) {
		return $this1->getTotalSeconds() !== $dtic->getTotalSeconds();
	}
	function __toString() { return 'datetime._DateTimeInterval.DateTimeInterval_Impl_'; }
}
