<?php

class datetime_utils_DateTimeIntervalUtils {
	public function __construct() {}
	static function strftime($dti, $format) { if(!php_Boot::$skip_constructor) {
		$prevPos = 0;
		$pos = _hx_index_of($format, "%", null);
		$str = "";
		while($pos >= 0) {
			$str .= _hx_string_or_null(_hx_substring($format, $prevPos, $pos));
			$pos++;
			{
				$_g = ord(substr($format,$pos,1));
				switch($_g) {
				case 89:{
					$s = _hx_string_rec($dti->getYears(), "") . "";
					if(strlen("0") === 0 || strlen($s) >= 2) {
						$str .= _hx_string_or_null($s);
					} else {
						$str .= _hx_string_or_null(str_pad($s, Math::ceil((2 - strlen($s)) / strlen("0")) * strlen("0") + strlen($s), "0", STR_PAD_LEFT));
					}
				}break;
				case 121:{
					$str .= _hx_string_rec($dti->getYears(), "") . "";
				}break;
				case 77:{
					$s1 = _hx_string_rec($dti->getMonths(), "") . "";
					if(strlen("0") === 0 || strlen($s1) >= 2) {
						$str .= _hx_string_or_null($s1);
					} else {
						$str .= _hx_string_or_null(str_pad($s1, Math::ceil((2 - strlen($s1)) / strlen("0")) * strlen("0") + strlen($s1), "0", STR_PAD_LEFT));
					}
				}break;
				case 109:{
					$str .= _hx_string_rec($dti->getMonths(), "") . "";
				}break;
				case 98:{
					$str .= _hx_string_rec($dti->getTotalMonths(), "") . "";
				}break;
				case 68:{
					$s2 = _hx_string_rec($dti->getDays(), "") . "";
					if(strlen("0") === 0 || strlen($s2) >= 2) {
						$str .= _hx_string_or_null($s2);
					} else {
						$str .= _hx_string_or_null(str_pad($s2, Math::ceil((2 - strlen($s2)) / strlen("0")) * strlen("0") + strlen($s2), "0", STR_PAD_LEFT));
					}
				}break;
				case 100:{
					$str .= _hx_string_rec($dti->getDays(), "") . "";
				}break;
				case 97:{
					$str .= _hx_string_rec($dti->getTotalDays(), "") . "";
				}break;
				case 72:{
					$s3 = _hx_string_rec($dti->getHours(), "") . "";
					if(strlen("0") === 0 || strlen($s3) >= 2) {
						$str .= _hx_string_or_null($s3);
					} else {
						$str .= _hx_string_or_null(str_pad($s3, Math::ceil((2 - strlen($s3)) / strlen("0")) * strlen("0") + strlen($s3), "0", STR_PAD_LEFT));
					}
				}break;
				case 104:{
					$str .= _hx_string_rec($dti->getHours(), "") . "";
				}break;
				case 99:{
					$str .= _hx_string_rec($dti->getTotalHours(), "") . "";
				}break;
				case 73:{
					$s4 = _hx_string_rec($dti->getMinutes(), "") . "";
					if(strlen("0") === 0 || strlen($s4) >= 2) {
						$str .= _hx_string_or_null($s4);
					} else {
						$str .= _hx_string_or_null(str_pad($s4, Math::ceil((2 - strlen($s4)) / strlen("0")) * strlen("0") + strlen($s4), "0", STR_PAD_LEFT));
					}
				}break;
				case 105:{
					$str .= _hx_string_rec($dti->getMinutes(), "") . "";
				}break;
				case 101:{
					$str .= _hx_string_rec($dti->getTotalMinutes(), "") . "";
				}break;
				case 83:{
					$s5 = _hx_string_rec($dti->getSeconds(), "") . "";
					if(strlen("0") === 0 || strlen($s5) >= 2) {
						$str .= _hx_string_or_null($s5);
					} else {
						$str .= _hx_string_or_null(str_pad($s5, Math::ceil((2 - strlen($s5)) / strlen("0")) * strlen("0") + strlen($s5), "0", STR_PAD_LEFT));
					}
				}break;
				case 115:{
					$str .= _hx_string_rec($dti->getSeconds(), "") . "";
				}break;
				case 102:{
					$str .= _hx_string_rec($dti->getTotalSeconds(), "") . "";
				}break;
				case 82:{
					if($dti->negative) {
						$str .= "-";
					} else {
						$str .= "+";
					}
				}break;
				case 114:{
					if($dti->negative) {
						$str .= "-";
					} else {
						$str .= "";
					}
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
	}}
	static function formatPartial($dti, $format) {
		$result = (new _hx_array(array()));
		$pos = 0;
		$str = "";
		{
			$_g1 = 0;
			$_g = $format->length;
			while($_g1 < $_g) {
				$f = $_g1++;
				$pos = _hx_index_of($format[$f], "%", null);
				if($pos >= 0) {
					{
						$_g2 = ord(substr($format[$f],$pos + 1,1));
						switch($_g2) {
						case 89:{
							if($dti->getYears() === 0) {
								continue 2;
							}
							$str = _hx_string_or_null(_hx_substring($format[$f], 0, $pos)) . _hx_string_or_null(datetime_utils_DateTimeIntervalUtils_0($_g, $_g1, $_g2, $dti, $f, $format, $pos, $result, $str)) . _hx_string_or_null(_hx_substring($format[$f], $pos + 2, null));
						}break;
						case 121:{
							if($dti->getYears() === 0) {
								continue 2;
							}
							$str = _hx_string_or_null(_hx_substring($format[$f], 0, $pos)) . _hx_string_rec($dti->getYears(), "") . _hx_string_or_null(_hx_substring($format[$f], $pos + 2, null));
						}break;
						case 77:{
							if($dti->getMonths() === 0) {
								continue 2;
							}
							$str = _hx_string_or_null(_hx_substring($format[$f], 0, $pos)) . _hx_string_or_null(datetime_utils_DateTimeIntervalUtils_1($_g, $_g1, $_g2, $dti, $f, $format, $pos, $result, $str)) . _hx_string_or_null(_hx_substring($format[$f], $pos + 2, null));
						}break;
						case 109:{
							if($dti->getMonths() === 0) {
								continue 2;
							}
							$str = _hx_string_or_null(_hx_substring($format[$f], 0, $pos)) . _hx_string_rec($dti->getMonths(), "") . _hx_string_or_null(_hx_substring($format[$f], $pos + 2, null));
						}break;
						case 98:{
							if($dti->getTotalMonths() === 0) {
								continue 2;
							}
							$str = _hx_string_or_null(_hx_substring($format[$f], 0, $pos)) . _hx_string_rec($dti->getTotalMonths(), "") . _hx_string_or_null(_hx_substring($format[$f], $pos + 2, null));
						}break;
						case 68:{
							if($dti->getDays() === 0) {
								continue 2;
							}
							$str = _hx_string_or_null(_hx_substring($format[$f], 0, $pos)) . _hx_string_or_null(datetime_utils_DateTimeIntervalUtils_2($_g, $_g1, $_g2, $dti, $f, $format, $pos, $result, $str)) . _hx_string_or_null(_hx_substring($format[$f], $pos + 2, null));
						}break;
						case 100:{
							if($dti->getDays() === 0) {
								continue 2;
							}
							$str = _hx_string_or_null(_hx_substring($format[$f], 0, $pos)) . _hx_string_rec($dti->getDays(), "") . _hx_string_or_null(_hx_substring($format[$f], $pos + 2, null));
						}break;
						case 97:{
							if($dti->getTotalDays() === 0) {
								continue 2;
							}
							$str = _hx_string_or_null(_hx_substring($format[$f], 0, $pos)) . _hx_string_rec($dti->getTotalDays(), "") . _hx_string_or_null(_hx_substring($format[$f], $pos + 2, null));
						}break;
						case 72:{
							if($dti->getHours() === 0) {
								continue 2;
							}
							$str = _hx_string_or_null(_hx_substring($format[$f], 0, $pos)) . _hx_string_or_null(datetime_utils_DateTimeIntervalUtils_3($_g, $_g1, $_g2, $dti, $f, $format, $pos, $result, $str)) . _hx_string_or_null(_hx_substring($format[$f], $pos + 2, null));
						}break;
						case 104:{
							if($dti->getHours() === 0) {
								continue 2;
							}
							$str = _hx_string_or_null(_hx_substring($format[$f], 0, $pos)) . _hx_string_rec($dti->getHours(), "") . _hx_string_or_null(_hx_substring($format[$f], $pos + 2, null));
						}break;
						case 99:{
							if($dti->getTotalHours() === 0) {
								continue 2;
							}
							$str = _hx_string_or_null(_hx_substring($format[$f], 0, $pos)) . _hx_string_rec($dti->getTotalHours(), "") . _hx_string_or_null(_hx_substring($format[$f], $pos + 2, null));
						}break;
						case 73:{
							if($dti->getMinutes() === 0) {
								continue 2;
							}
							$str = _hx_string_or_null(_hx_substring($format[$f], 0, $pos)) . _hx_string_or_null(datetime_utils_DateTimeIntervalUtils_4($_g, $_g1, $_g2, $dti, $f, $format, $pos, $result, $str)) . _hx_string_or_null(_hx_substring($format[$f], $pos + 2, null));
						}break;
						case 105:{
							if($dti->getMinutes() === 0) {
								continue 2;
							}
							$str = _hx_string_or_null(_hx_substring($format[$f], 0, $pos)) . _hx_string_rec($dti->getMinutes(), "") . _hx_string_or_null(_hx_substring($format[$f], $pos + 2, null));
						}break;
						case 101:{
							if($dti->getTotalMinutes() === 0) {
								continue 2;
							}
							$str = _hx_string_or_null(_hx_substring($format[$f], 0, $pos)) . _hx_string_rec($dti->getTotalMinutes(), "") . _hx_string_or_null(_hx_substring($format[$f], $pos + 2, null));
						}break;
						case 83:{
							if($dti->getSeconds() === 0) {
								continue 2;
							}
							$str = _hx_string_or_null(_hx_substring($format[$f], 0, $pos)) . _hx_string_or_null(datetime_utils_DateTimeIntervalUtils_5($_g, $_g1, $_g2, $dti, $f, $format, $pos, $result, $str)) . _hx_string_or_null(_hx_substring($format[$f], $pos + 2, null));
						}break;
						case 115:{
							if($dti->getSeconds() === 0) {
								continue 2;
							}
							$str = _hx_string_or_null(_hx_substring($format[$f], 0, $pos)) . _hx_string_rec($dti->getSeconds(), "") . _hx_string_or_null(_hx_substring($format[$f], $pos + 2, null));
						}break;
						case 102:{
							if(_hx_equal($dti->getTotalSeconds(), 0)) {
								continue 2;
							}
							$str = _hx_string_or_null(_hx_substring($format[$f], 0, $pos)) . _hx_string_rec($dti->getTotalSeconds(), "") . _hx_string_or_null(_hx_substring($format[$f], $pos + 2, null));
						}break;
						default:{
							continue 2;
						}break;
						}
						unset($_g2);
					}
					$result->push($str);
				}
				unset($f);
			}
		}
		return $result;
	}
	function __toString() { return 'datetime.utils.DateTimeIntervalUtils'; }
}
function datetime_utils_DateTimeIntervalUtils_0(&$_g, &$_g1, &$_g2, &$dti, &$f, &$format, &$pos, &$result, &$str) {
	{
		$s = _hx_string_rec($dti->getYears(), "") . "";
		if(strlen("0") === 0 || strlen($s) >= 2) {
			return $s;
		} else {
			return str_pad($s, Math::ceil((2 - strlen($s)) / strlen("0")) * strlen("0") + strlen($s), "0", STR_PAD_LEFT);
		}
		unset($s);
	}
}
function datetime_utils_DateTimeIntervalUtils_1(&$_g, &$_g1, &$_g2, &$dti, &$f, &$format, &$pos, &$result, &$str) {
	{
		$s1 = _hx_string_rec($dti->getMonths(), "") . "";
		if(strlen("0") === 0 || strlen($s1) >= 2) {
			return $s1;
		} else {
			return str_pad($s1, Math::ceil((2 - strlen($s1)) / strlen("0")) * strlen("0") + strlen($s1), "0", STR_PAD_LEFT);
		}
		unset($s1);
	}
}
function datetime_utils_DateTimeIntervalUtils_2(&$_g, &$_g1, &$_g2, &$dti, &$f, &$format, &$pos, &$result, &$str) {
	{
		$s2 = _hx_string_rec($dti->getDays(), "") . "";
		if(strlen("0") === 0 || strlen($s2) >= 2) {
			return $s2;
		} else {
			return str_pad($s2, Math::ceil((2 - strlen($s2)) / strlen("0")) * strlen("0") + strlen($s2), "0", STR_PAD_LEFT);
		}
		unset($s2);
	}
}
function datetime_utils_DateTimeIntervalUtils_3(&$_g, &$_g1, &$_g2, &$dti, &$f, &$format, &$pos, &$result, &$str) {
	{
		$s3 = _hx_string_rec($dti->getHours(), "") . "";
		if(strlen("0") === 0 || strlen($s3) >= 2) {
			return $s3;
		} else {
			return str_pad($s3, Math::ceil((2 - strlen($s3)) / strlen("0")) * strlen("0") + strlen($s3), "0", STR_PAD_LEFT);
		}
		unset($s3);
	}
}
function datetime_utils_DateTimeIntervalUtils_4(&$_g, &$_g1, &$_g2, &$dti, &$f, &$format, &$pos, &$result, &$str) {
	{
		$s4 = _hx_string_rec($dti->getMinutes(), "") . "";
		if(strlen("0") === 0 || strlen($s4) >= 2) {
			return $s4;
		} else {
			return str_pad($s4, Math::ceil((2 - strlen($s4)) / strlen("0")) * strlen("0") + strlen($s4), "0", STR_PAD_LEFT);
		}
		unset($s4);
	}
}
function datetime_utils_DateTimeIntervalUtils_5(&$_g, &$_g1, &$_g2, &$dti, &$f, &$format, &$pos, &$result, &$str) {
	{
		$s5 = _hx_string_rec($dti->getSeconds(), "") . "";
		if(strlen("0") === 0 || strlen($s5) >= 2) {
			return $s5;
		} else {
			return str_pad($s5, Math::ceil((2 - strlen($s5)) / strlen("0")) * strlen("0") + strlen($s5), "0", STR_PAD_LEFT);
		}
		unset($s5);
	}
}
