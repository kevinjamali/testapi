<?php
header ( "Content-Type: application/json; charset=UTF-8" );
$from = "";
$to = "";
$type = "NULL";
$no_full_weeks = 0;
$weekdays = 0;
$yearsdiff=0;
$days = 0;
$no_full_weeks = 0;
$acceptedtypes = array (
		"seconds",
		"minutes",
		"hours",
		"years"
);
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
// validation the data
if ((! in_array ( $type, $acceptedtypes )) and $type !== "NULL") {
	$type = "Not Supported, Please use 'seconds', 'minutes', 'hours' or 'years' ";
}


if (strtotime ( $from ) !== FALSE and $from !== "") {
	$fromdate = strtotime ( $from );
} else {
	$from = "Invalid date";
	$fromdate = "";
}

if (strtotime ( $to ) !== FALSE and $to !== "") {
	$todate = strtotime ( $to );
} else {
	$to = "Invalid date";
	$todate = "";
}

If ($todate <> "" and $fromdate<> ""){
If ($fromdate > $todate) {

	$endDate = $fromdate;
	$startDate = $todate;
} else {
	$endDate = $todate;
	$startDate = $fromdate;
}

$yearsdiff = floor ( ($endDate - $startDate) / 31536000 );

$days = floor(($endDate - $startDate) / 86400);

// Monday 1 , Sunday 7
$startdate_day = date ( "N", $startDate );
$enddate_day = date ( "N", $endDate );


$daysremained = $days;

If ($enddate_day != 7 and $enddate_day != 1) {
	$daysremained = $daysremained - $enddate_day;
}

if ($startdate_day != 7 and $startdate_day != 1) {
	$daysremained = $daysremained - (6 - $startdate_day);
}
$no_full_weeks = floor ( $daysremained / 7 );

//full weekdays 
$weeks_difference = floor($days / 7); // Complete weeks

$first_day        = date("w", $startDate);
$days_remainder   = floor($days % 7);
$odd_days         = $first_day + $days_remainder;

// Do we have a Saturday or Sunday in the remainder?

if ($odd_days > 7) { // Sunday
	$days_remainder--;
}

if ($odd_days > 6) { // Saturday
	$days_remainder--;
}

$weekdays = ($weeks_difference * 5) + $days_remainder;

}









$myArr = array (
		"from" => $from,
		"to" => $to,
		"type" => $type,
		"days" => $days,
		"weekdays" => $weekdays,
		"full weeks" => $no_full_weeks
		
);

$myJSON = json_encode ( $myArr );

echo $myJSON;
?>