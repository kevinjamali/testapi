<?php

/*
 * The finder function get 4 parameters and calculate days , weekdays and complete weeks between $from and $to
 * $type and $convertparam are optional
 * if both of optional parameters have a valid value the $convertparam parameter will be converted to $type
 */
function finder($from, $to, $type, $convertparam) {
	$no_weekdays = 0;
	$no_days = 0;
	$no_complete_weeks = 0;
	$typevalid = TRUE;

	// finding the server Time zone and use it for converting, calculating or switch to a specific Time zone for example 'Australia/Adelaide'
	$date = new DateTime ();
	$functionTimezone = $date->getTimezone ();
	// $functionTimezone = new DateTimeZone ( 'Australia/Adelaide' );

	$acceptable_types = array ( // store acceptable typesin a array
			"seconds",
			"minutes",
			"hours",
			"years"
	);

	// validation the '$type' value
	if ((! in_array ( $type, $acceptable_types )) and $type !== null) {
		$type = "Please use 'seconds', 'minutes', 'hours' or 'years' ";
		$typevalid = FALSE;
	}
	// converting '$from' and '$to' to DateTime
	if (strtotime ( $from ) !== FALSE and $from !== null) {
		$from_date = strtotime ( $from );
		$from = new DateTime ( $from );
		$from->setTimezone ( $functionTimezone );
		$from = $from->format ( 'Y-m-d H:i:s' );
	} else {
		$from = "Invalid date";
		$from_date = null;
	}

	if (strtotime ( $to ) !== FALSE and $to !== null) {
		$to_date = strtotime ( $to );
		$to = new DateTime ( $to );
		$to->setTimezone ( $functionTimezone );
		$to = $to->format ( 'Y-m-d H:i:s' );
	} else {
		$to = "Invalid date";
		$to_date = null;
	}
	// fix $from and $to order
	If ($to_date != null and $from_date != null) { // if from and to dates are valid
		If ($from_date > $to_date) {
			$end_date = $from_date;
			$start_date = $to_date;
		} else {
			$end_date = $to_date;
			$start_date = $from_date;
		}

		$no_days = floor ( ($end_date - $start_date) / 86400 ) + 1; // +1 for covering last day
		$no_days_real = $no_days; // store it in another name for other parts
		$no_days_remained = $no_days_real; // store it for other calculations
		$start_date_day_number = date ( "N", $start_date ); // Monday 1 , Sunday 7
		$end_date_day_number = date ( "N", $end_date ); // Monday 1 , Sunday 7

		// calculate number of complete weeks
		if ($no_days_real >= 7) {// 1 possible week or more 

			If ($end_date_day_number != 7) {
				$no_days_remained = $no_days_remained - $end_date_day_number;
			}

			if ($start_date_day_number != 7 and $start_date_day_number != 1) {
				$no_days_remained = $no_days_remained - (7 - $start_date_day_number);
			}

			$no_complete_weeks = floor ( $no_days_remained / 7 );
		} else {
			$no_complete_weeks = 0;
		}

		// calculate weekdays
		$no_days_remained = 0; // reset $no_days_remained
		                       // if both $from and $to are in a week
		if (date ( "W", $start_date ) == date ( "W", $end_date ) and date ( "Y", $start_date ) == date ( "Y", $end_date )) {
			$no_weekdays = $end_date_day_number - $start_date_day_number + 1;
			If ( $end_date_day_number ==7){ // if Sunday
				$no_weekdays--;
			}
			If ( $end_date_day_number ==6){ //If Saturday
				$no_weekdays--;
			}
			if ($no_weekdays > 5) {
				$no_weekdays = 5;
			}
		} else {
			If ($end_date_day_number != 7) { // If it is not Sunday , if it is a complete week and has been calculated before as a complete week
				$no_days_remained = $no_days_remained + $end_date_day_number; // if it is n
			}
			if ($start_date_day_number != 7 and $start_date_day_number != 1) { // If it is not Sunday or Monday , if it is a complete week and has been calculated before as a complete week
				$no_days_remained = $no_days_remained + (6 - $start_date_day_number);
			}

			$no_weekdays = abs ( ($no_complete_weeks * 5) + $no_days_remained );
		}

		// check parameter 3 and 4 and convert them if it is needed

		if ($convertparam == "days" and $type != null and $typevalid != FALSE) {
			$no_days = convertto ( $no_days, $type );
		}

		if ($convertparam == "weekdays" and $type != null and $typevalid != FALSE) {
			$no_weekdays = convertto ( $no_weekdays, $type );
		}
		if ($convertparam == "completeweeks" and $type != null and $typevalid != FALSE) {

			$no_complete_weeks = convertto ( $no_complete_weeks * 7, $type ); // convert it to days
		}
	}
	// better values in array
	if ($type == null) {
		$type = "none";
	}
	if ($convertparam == null) {
		$convertparam = "none";
	}
	// return function result as an array
	return array (
			"from" => $from,
			"to" => $to,
			"type" => $type,
			"convertparam" => $convertparam,
			"days" => $no_days,
			"weekdays" => $no_weekdays,
			"completeweeks" => $no_complete_weeks
	);
}

// this functionn convert results to seconds, minutes, hours and years
function convertto($thedays, $thetype) {
	if ($thetype != null) {
		switch ($thetype) {
			case "seconds" :
				$thedays = $thedays * 24 * 60 * 60; // days * 24 hours * 60 min * 60 sec
				break;
			case "minutes" :
				$thedays = $thedays * 24 * 60; // days * 24 hours * 60 min
				break;
			case "hours" :
				$thedays = $thedays * 24; // days * 24 hours
				break;
			case "years" :
				$thedays = $thedays / 365; // days / a year days
				break;
		}
		return $thedays;
	} else
		return 0;
}
// this function has been used in PHPUnit test
function arrays_are_similar($a, $b) {
	if ($a == $b) {
		return true;
	} else {
		return false;
	}
}
?>