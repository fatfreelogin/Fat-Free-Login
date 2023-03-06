<?php

class datetime_DTPeriod extends Enum {
	public static function Day($n) { return new datetime_DTPeriod("Day", 2, array($n)); }
	public static function Hour($n) { return new datetime_DTPeriod("Hour", 3, array($n)); }
	public static function Minute($n) { return new datetime_DTPeriod("Minute", 4, array($n)); }
	public static function Month($n) { return new datetime_DTPeriod("Month", 1, array($n)); }
	public static function Second($n) { return new datetime_DTPeriod("Second", 5, array($n)); }
	public static function Week($n) { return new datetime_DTPeriod("Week", 6, array($n)); }
	public static function Year($n) { return new datetime_DTPeriod("Year", 0, array($n)); }
	public static $__constructors = array(2 => 'Day', 3 => 'Hour', 4 => 'Minute', 1 => 'Month', 5 => 'Second', 6 => 'Week', 0 => 'Year');
	}
