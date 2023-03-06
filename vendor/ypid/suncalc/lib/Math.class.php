<?php

class Math {
	public function __construct(){}
	static $PI;
	static $NaN;
	static $POSITIVE_INFINITY;
	static $NEGATIVE_INFINITY;
	static function abs($v) {
		return abs($v);
	}
	static function sin($v) {
		return sin($v);
	}
	static function cos($v) {
		return cos($v);
	}
	static function atan2($y, $x) {
		return atan2($y, $x);
	}
	static function tan($v) {
		return tan($v);
	}
	static function sqrt($v) {
		return sqrt($v);
	}
	static function round($v) {
		return (int) floor($v + 0.5);
	}
	static function ceil($v) {
		return (int) ceil($v);
	}
	static function asin($v) {
		return asin($v);
	}
	static function acos($v) {
		return acos($v);
	}
	static function fround($v) {
		return floor($v + 0.5);
	}
	static function ffloor($v) {
		return floor($v);
	}
	static function fceil($v) {
		return ceil($v);
	}
	function __toString() { return 'Math'; }
}
{
	Math::$PI = M_PI;
	Math::$NaN = acos(1.01);
	Math::$NEGATIVE_INFINITY = log(0);
	Math::$POSITIVE_INFINITY = -Math::$NEGATIVE_INFINITY;
}
