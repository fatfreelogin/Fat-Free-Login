<?php
/*
 * @name: suncalc
 * @description: Calculate sun position, sunlight phases, moon position and lunar phase.
 * @source: https://github.com/ypid/suncalc/blob/master/suncalc/SunCalc.hx
 * @license: BSD-2-Clause
 * @author: Vladimir Agafonkin
 * @author: Robin Schneider <ypid@riseup.net>
 */

class suncalc_SunCalc {
	public function __construct(){}
	static $version = "1.7.0";
	static $version_hash = "ba17748d7dc25f5f025af026a68c8b9305d7530c";
	static $version_haxe_compiler = "3.2.1";
	static $dayMs = 86400000;
	static $J1970 = 2440588;
	static $J2000 = 2451545;
	static $rad;
	static $e;
	static function toJulian($date) {
		return $date->getTime() / suncalc_SunCalc::$dayMs - 0.5 + suncalc_SunCalc::$J1970;
	}
	static function fromJulian($j) {
		return Date::fromTime(($j + 0.5 - suncalc_SunCalc::$J1970) * suncalc_SunCalc::$dayMs);
	}
	static function toDays($date) {
		return $date->getTime() / suncalc_SunCalc::$dayMs - 0.5 + suncalc_SunCalc::$J1970 - suncalc_SunCalc::$J2000;
	}
	static function rightAscension($l, $b) {
		return Math::atan2(Math::sin($l) * Math::cos(suncalc_SunCalc::$e) - Math::tan($b) * Math::sin(suncalc_SunCalc::$e), Math::cos($l));
	}
	static function declination($l, $b) {
		return Math::asin(Math::sin($b) * Math::cos(suncalc_SunCalc::$e) + Math::cos($b) * Math::sin(suncalc_SunCalc::$e) * Math::sin($l));
	}
	static function azimuth($H, $phi, $dec) {
		return Math::atan2(Math::sin($H), Math::cos($H) * Math::sin($phi) - Math::tan($dec) * Math::cos($phi));
	}
	static function altitude($H, $phi, $dec) {
		return Math::asin(Math::sin($phi) * Math::sin($dec) + Math::cos($phi) * Math::cos($dec) * Math::cos($H));
	}
	static function siderealTime($d, $lw) {
		return suncalc_SunCalc::$rad * (280.16 + 360.9856235 * $d) - $lw;
	}
	static function solarMeanAnomaly($d) {
		return suncalc_SunCalc::$rad * (357.5291 + 0.98560028 * $d);
	}
	static function eclipticLongitude($M) {
		$C = suncalc_SunCalc::$rad * (1.9148 * Math::sin($M) + 0.02 * Math::sin(2 * $M) + 0.0003 * Math::sin(3 * $M));
		$P = suncalc_SunCalc::$rad * 102.9372;
		return $M + $C + $P + Math::$PI;
	}
	static function sunCoords($d) {
		$M = suncalc_SunCalc::solarMeanAnomaly($d);
		$L = suncalc_SunCalc::eclipticLongitude($M);
		return _hx_anonymous(array("dec" => suncalc_SunCalc::declination($L, 0), "ra" => suncalc_SunCalc::rightAscension($L, 0)));
	}
	static function getPosition($date, $lat, $lng) {
		$lw = suncalc_SunCalc::$rad * -$lng;
		$phi = suncalc_SunCalc::$rad * $lat;
		$d = suncalc_SunCalc::toDays($date);
		$c = suncalc_SunCalc::sunCoords($d);
		$H = suncalc_SunCalc::siderealTime($d, $lw) - $c->ra;
		return _hx_anonymous(array("azimuth" => suncalc_SunCalc::azimuth($H, $phi, $c->dec), "altitude" => suncalc_SunCalc::altitude($H, $phi, $c->dec)));
	}
	static $times;
	static function addTime($angle, $riseName, $setName) {
		suncalc_SunCalc::$times->push((new _hx_array(array($angle, $riseName, $setName))));
	}
	static $J0 = 0.0009;
	static function julianCycle($d, $lw) {
		return Math::round($d - suncalc_SunCalc::$J0 - $lw / (2 * Math::$PI));
	}
	static function approxTransit($Ht, $lw, $n) {
		return suncalc_SunCalc::$J0 + ($Ht + $lw) / (2 * Math::$PI) + $n;
	}
	static function solarTransitJ($ds, $M, $L) {
		return suncalc_SunCalc::$J2000 + $ds + 0.0053 * Math::sin($M) - 0.0069 * Math::sin(2 * $L);
	}
	static function hourAngle($h, $phi, $d) {
		return Math::acos((Math::sin($h) - Math::sin($phi) * Math::sin($d)) / (Math::cos($phi) * Math::cos($d)));
	}
	static function getSetJ($h, $lw, $phi, $dec, $n, $M, $L) {
		$w = Math::acos((Math::sin($h) - Math::sin($phi) * Math::sin($dec)) / (Math::cos($phi) * Math::cos($dec)));
		$a = suncalc_SunCalc::approxTransit($w, $lw, $n);
		return suncalc_SunCalc::solarTransitJ($a, $M, $L);
	}
	static function getTimes($date, $lat, $lng) {
		$lw = suncalc_SunCalc::$rad * -$lng;
		$phi = suncalc_SunCalc::$rad * $lat;
		$d = suncalc_SunCalc::toDays($date);
		$n = Math::round($d - suncalc_SunCalc::$J0 - $lw / (2 * Math::$PI));
		$ds = suncalc_SunCalc::approxTransit(0, $lw, $n);
		$M = suncalc_SunCalc::solarMeanAnomaly($ds);
		$L = suncalc_SunCalc::eclipticLongitude($M);
		$dec = suncalc_SunCalc::declination($L, 0);
		$Jnoon = suncalc_SunCalc::solarTransitJ($ds, $M, $L);
		$i = null;
		$len = null;
		$time = null;
		$Jset = null;
		$Jrise = null;
		$result = new haxe_ds_StringMap();
		{
			$v = suncalc_SunCalc::fromJulian($Jnoon);
			$result->set("solarNoon", $v);
			$v;
		}
		{
			$v1 = suncalc_SunCalc::fromJulian($Jnoon - 0.5);
			$result->set("nadir", $v1);
			$v1;
		}
		{
			$_g = 0;
			$_g1 = suncalc_SunCalc::$times;
			while($_g < $_g1->length) {
				$time1 = $_g1[$_g];
				++$_g;
				$Jset = suncalc_SunCalc::getSetJ($time1->a[0] * suncalc_SunCalc::$rad, $lw, $phi, $dec, $n, $M, $L);
				$Jrise = $Jnoon - ($Jset - $Jnoon);
				{
					$k = $time1[1];
					$v2 = suncalc_SunCalc::fromJulian($Jrise);
					$result->set($k, $v2);
					$v2;
					unset($v2,$k);
				}
				{
					$k1 = $time1[2];
					$v3 = suncalc_SunCalc::fromJulian($Jset);
					$result->set($k1, $v3);
					$v3;
					unset($v3,$k1);
				}
				unset($time1);
			}
		}
		return $result;
	}
	static function moonCoords($d) {
		$L = suncalc_SunCalc::$rad * (218.316 + 13.176396 * $d);
		$M = suncalc_SunCalc::$rad * (134.963 + 13.064993 * $d);
		$F = suncalc_SunCalc::$rad * (93.272 + 13.229350 * $d);
		$longitude = $L + suncalc_SunCalc::$rad * 6.289 * Math::sin($M);
		$latitude = suncalc_SunCalc::$rad * 5.128 * Math::sin($F);
		$dt = 385001 - 20905 * Math::cos($M);
		return _hx_anonymous(array("ra" => suncalc_SunCalc::rightAscension($longitude, $latitude), "dec" => suncalc_SunCalc::declination($longitude, $latitude), "dist" => $dt));
	}
	static function getMoonPosition($date, $lat, $lng) {
		$lw = suncalc_SunCalc::$rad * -$lng;
		$phi = suncalc_SunCalc::$rad * $lat;
		$d = suncalc_SunCalc::toDays($date);
		$c = suncalc_SunCalc::moonCoords($d);
		$H = suncalc_SunCalc::siderealTime($d, $lw) - $c->ra;
		$h = suncalc_SunCalc::altitude($H, $phi, $c->dec);
		$h = $h + suncalc_SunCalc::$rad * 0.017 / Math::tan($h + suncalc_SunCalc::$rad * 10.26 / ($h + suncalc_SunCalc::$rad * 5.10));
		return _hx_anonymous(array("azimuth" => suncalc_SunCalc::azimuth($H, $phi, $c->dec), "altitude" => $h, "distance" => $c->dist));
	}
	static function getMoonIllumination($date) {
		$d = suncalc_SunCalc::toDays($date);
		$s = suncalc_SunCalc::sunCoords($d);
		$m = suncalc_SunCalc::moonCoords($d);
		$astronomical_unit = 149598000;
		$phi = Math::acos(Math::sin($s->dec) * Math::sin($m->dec) + Math::cos($s->dec) * Math::cos($m->dec) * Math::cos($s->ra - $m->ra));
		$inc = Math::atan2($astronomical_unit * Math::sin($phi), $m->dist - $astronomical_unit * Math::cos($phi));
		$angle = Math::atan2(Math::cos($s->dec) * Math::sin($s->ra - $m->ra), Math::sin($s->dec) * Math::cos($m->dec) - Math::cos($s->dec) * Math::sin($m->dec) * Math::cos($s->ra - $m->ra));
		return _hx_anonymous(array("fraction" => (1 + Math::cos($inc)) / 2, "phase" => 0.5 + 0.5 * $inc * ((($angle < 0) ? -1 : 1)) / Math::$PI, "angle" => $angle));
	}
	static function hoursLater($date, $h) {
		return Date::fromTime($date->getTime() + $h * suncalc_SunCalc::$dayMs / 24);
	}
	static function getMoonTimes($date, $lat, $lng, $inUTC = null) {
		if($inUTC === null) {
			$inUTC = false;
		}
		if($inUTC) {
			{
				$this1 = datetime__DateTime_DateTime_Impl_::utc(suncalc_SunCalc_0($date, $inUTC, $lat, $lng));
				$date = Date::fromTime(($this1 - 62135596800.0) * 1000);
			}
			$date = new Date($date->getFullYear(), $date->getMonth(), $date->getDate(), 0, 0, 0);
		} else {
			$date = new Date($date->getFullYear(), $date->getMonth(), $date->getDate(), 0, 0, 0);
		}
		$hc = 0.133 * suncalc_SunCalc::$rad;
		$h0 = suncalc_SunCalc::getMoonPosition($date, $lat, $lng)->altitude - $hc;
		$h1 = null;
		$h2 = null;
		$rise = 0.0;
		$set = 0.0;
		$a = null;
		$b = null;
		$xe = null;
		$ye = 0.0;
		$d = null;
		$roots = null;
		$x1 = 0.0;
		$x2 = 0.0;
		$dx = null;
		$i = 1;
		while($i <= 24) {
			$h1 = suncalc_SunCalc::getMoonPosition(suncalc_SunCalc::hoursLater($date, $i), $lat, $lng)->altitude - $hc;
			$h2 = suncalc_SunCalc::getMoonPosition(suncalc_SunCalc::hoursLater($date, $i + 1), $lat, $lng)->altitude - $hc;
			$a = ($h0 + $h2) / 2 - $h1;
			$b = ($h2 - $h0) / 2;
			$xe = -$b / (2 * $a);
			$ye = ($a * $xe + $b) * $xe + $h1;
			$d = $b * $b - 4 * $a * $h1;
			$roots = 0;
			if($d >= 0) {
				$dx = Math::sqrt($d) / (Math::abs($a) * 2);
				$x1 = $xe - $dx;
				$x2 = $xe + $dx;
				if(Math::abs($x1) <= 1) {
					$roots++;
				}
				if(Math::abs($x2) <= 1) {
					$roots++;
				}
				if($x1 < -1) {
					$x1 = $x2;
				}
			}
			if($roots === 1) {
				if($h0 < 0) {
					$rise = $i + $x1;
				} else {
					$set = $i + $x1;
				}
			} else {
				if($roots === 2) {
					$rise = $i + ((($ye < 0) ? $x2 : $x1));
					$set = $i + ((($ye < 0) ? $x1 : $x2));
				}
			}
			if(!_hx_equal($rise, 0) && !_hx_equal($set, 0)) {
				break;
			}
			$h0 = $h2;
			$i += 2;
		}
		$result = new haxe_ds_StringMap();
		if(!_hx_equal($rise, 0)) {
			$v = suncalc_SunCalc::hoursLater($date, $rise);
			$result->set("rise", $v);
			$v;
		}
		if(!_hx_equal($set, 0)) {
			$v1 = suncalc_SunCalc::hoursLater($date, $set);
			$result->set("set", $v1);
			$v1;
		}
		if(_hx_equal($rise, 0) && _hx_equal($set, 0)) {
			{
				$result->set((($ye > 0) ? "alwaysUp" : "alwaysDown"), true);
				true;
			}
		}
		return $result;
	}
	static function main() {}
	function __toString() { return 'suncalc.SunCalc'; }
}
suncalc_SunCalc::$rad = Math::$PI / 180;
suncalc_SunCalc::$e = Math::$PI / 180 * 23.4397;
suncalc_SunCalc::$times = (new _hx_array(array((new _hx_array(array(-0.833, "sunrise", "sunset"))), (new _hx_array(array(-0.3, "sunriseEnd", "sunsetStart"))), (new _hx_array(array(-6, "dawn", "dusk"))), (new _hx_array(array(-12, "nauticalDawn", "nauticalDusk"))), (new _hx_array(array(-18, "nightEnd", "night"))), (new _hx_array(array(6, "goldenHourEnd", "goldenHour"))))));
function suncalc_SunCalc_0(&$date, &$inUTC, &$lat, &$lng) {
	{
		$time = Math::ffloor($date->getTime() / 1000);
		return $time + 62135596800.0;
	}
}
