<?php
use PhpParser\Node\Stmt\Switch_;

//header ( "Content-Type: application/json; charset=UTF-8" );

$from = null;
$to = null;
$type = null;
$convertparam = null;

// read the requests in get method
if (isset ( $_GET ["from"] )) {
	$from = $_GET ["from"];
}
if (isset ( $_GET ["to"] )) {
	$to = $_GET ["to"];
}
if (isset ( $_GET ["type"] )) {
	$type = strtolower ( trim ( $_GET ["type"] ) );
}

if (isset ( $_GET ["convertparam"] )) {
	$convertparam = strtolower ( trim ( $_GET ["convertparam"] ) );
}

// read the requests in post method

if (isset ( $_POST ["from"] )) {
	$from = $_POST ["from"];
}
if (isset ( $_POST ["to"] )) {
	$to = $_POST ["to"];
}
if (isset ( $_POST ["type"] )) {
	$type = strtolower ( trim ( $_POST ["type"] ) );
}
if (isset ( $_POST ["convertparam"] )) {
	$convertparam = strtolower ( trim ( $_POST ["convertparam"] ) );
}

$myJSON = json_encode ( finder ( $from, $to, $type, $convertparam ) );
echo $myJSON;

/*
 * The finder function get 4 parameters and calculate days , weekdays and complete between $from and $to
 * $type and $convertparam are optional
 * if both of them has a valid value the $convertparam parameter will be converted to $type
 */
function finder($from, $to, $type, $convertparam) {
	$no_weekdays = 0;
	$no_days = 0;
	$no_complete_weeks = 0;
	$typevalid = TRUE;

	// find the server time zone and use it for converting or calculating or switch to a specific time zone for example 'Australia/Adelaide'
	$date = new DateTime ();
	$functionTimezone = $date->getTimezone ();
	// $functionTimezone = new DateTimeZone ( 'Australia/Adelaide' );

	$acceptable_types = array ( // define acceptable types
			"seconds",
			"minutes",
			"hours",
			"years"
	);

	// validation the data
	if ((! in_array ( $type, $acceptable_types )) and $type !== null) {
		$type = "Please use 'seconds', 'minutes', 'hours' or 'years' ";
		$typevalid = FALSE;
	}

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

	If ($to_date != null and $from_date != null) { // if from and to dates are valid
		If ($from_date > $to_date) { // fix from and to order
			$end_date = $from_date;
			$start_date = $to_date;
		} else {
			$end_date = $to_date;
			$start_date = $from_date;
		}

		// $yearsdiff = floor ( ($end_date - $start_date) / 31536000 );

		$no_days = floor ( ($end_date - $start_date) / 86400 ) + 1;
		$no_days_real = $no_days; // store it in another name for other parts
		$no_days_remained = $no_days_real; // store it for other calculations
		                                   // $datediff=date_diff(date_format($to, 'Y-m-d ' ), date_format($from, 'Y-m-d'));
		$start_date_day_number = date ( "N", $start_date ); // Monday 1 , Sunday 7
		$first_day = date ( "w", $start_date );
		$end_date_day_number = date ( "N", $end_date );

		// calculate number of complete weeks
		if ($no_days_real > 7) {
			// If ($end_date_day_number != 7 and $end_date_day_number != 1) {
			If ($end_date_day_number != 7) {
				$no_days_remained = $no_days_remained - $end_date_day_number;
			}

			if ($start_date_day_number != 7 and $start_date_day_number != 1) {
				// if ($start_date_day_number != 1) {
				$no_days_remained = $no_days_remained - (7 - $start_date_day_number);
			}

			$no_complete_weeks = floor ( $no_days_remained / 7 ); // Complete weeks
		} else {
			$no_complete_weeks = 0;
		}

		// calculate weekdays
		$no_days_remained = 0;

		if (date ( "W", $start_date ) == date ( "W", $end_date ) and date ( "Y", $start_date ) == date ( "Y", $end_date )) {
			$no_weekdays = $end_date_day_number - $start_date_day_number + 1;
			if ($no_weekdays > 5) {
				$no_weekdays = 5;
			}
		} else {
			If ($end_date_day_number != 7) {
				$no_days_remained = $no_days_remained + $end_date_day_number; // if it is n
			}
			if ($start_date_day_number != 7 and $start_date_day_number != 1) {
				$no_days_remained = $no_days_remained + (6 - $start_date_day_number);
			}

			$no_weekdays = abs ( ($no_complete_weeks * 5) + $no_days_remained );
		}

		// check parameter 3 and 4 and convert them id it is needed

		if ($convertparam == "days" and $type != null and $typevalid != FALSE) {

			$no_days = convertto ( $no_days, $type );
		}

		if ($convertparam == "weekdays" and $type != null and $typevalid != FALSE) {
			$no_weekdays = convertto ( $no_weekdays, $type );
		}
		if ($convertparam == "completeweeks" and $type != null and $typevalid != FALSE) {

			$no_complete_weeks = convertto ( $no_complete_weeks * 7, $type );
		}
	}

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

// convert results to seconds, minutes, hours and years
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

?>