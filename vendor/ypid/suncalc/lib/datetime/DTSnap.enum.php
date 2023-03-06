<?php

class datetime_DTSnap extends Enum {
	public static function Day($direction) { return new datetime_DTSnap("Day", 2, array($direction)); }
	public static function Hour($direction) { return new datetime_DTSnap("Hour", 3, array($direction)); }
	public static function Minute($direction) { return new datetime_DTSnap("Minute", 4, array($direction)); }
	public static function Month($direction) { return new datetime_DTSnap("Month", 1, array($direction)); }
	public static function Second($direction) { return new datetime_DTSnap("Second", 5, array($direction)); }
	public static function Week($direction, $day) { return new datetime_DTSnap("Week", 6, array($direction, $day)); }
	public static function Year($direction) { return new datetime_DTSnap("Year", 0, array($direction)); }
	public static $__constructors = array(2 => 'Day', 3 => 'Hour', 4 => 'Minute', 1 => 'Month', 5 => 'Second', 6 => 'Week', 0 => 'Year');
	}
