<?php
$from = null;
$to = null;
$type = null;
$convertparam = null;
// read the requests in get method
if (isset ( $_GET ["from"] )) {
	$from = urlencode ( $_GET ["from"] );
}
if (isset ( $_GET ["to"] )) {
	$to = urlencode ( $_GET ["to"] );
}
if (isset ( $_GET ["type"] )) {
	$type = urlencode ( strtolower ( trim ( $_GET ["type"] ) ) );
}

if (isset ( $_GET ["convertparam"] )) {
	$convertparam = urlencode ( strtolower ( trim ( $_GET ["convertparam"] ) ) );
}

$uu = "http://" . $_SERVER ['HTTP_HOST'] . dirname ( $_SERVER ['SCRIPT_NAME'] );
// echo $uu;
?>

<!doctype html>
<html lang="en">
<head>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport"
	content="width=device-width, initial-scale=1, shrink-to-fit=no">

<!-- Bootstrap CSS -->
<link rel="stylesheet"
	href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
	integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
	crossorigin="anonymous">

<title>TestAPI tets</title>
</head>
<body>
	<div class="container">
		<h1>Simple test</h1>
		<form method="get" action="index.php">
			<input type="datetime-local" id="from" name="from"> <input
				type="datetime-local" id="to" name="to"> <select class="form-select"
				aria-label="Convert to" name="type" id="type">
				<option selected>none</option>
				<option value="seconds">Seconds</option>
				<option value="minutes">Minutes</option>
				<option value="hours">Hours</option>
				<option value="years">Years</option>
			</select> <select class="form-select" aria-label="Convert Result of"
				name="convertparam" id="convertparam">
				<option selected>none</option>
				<option value="days">Days Between</option>
				<option value="weekdays">Weekdays Between</option>
				<option value="completeweeks">Complete Weeks Between</option>
			</select>
			<button type="submit" class="btn btn-primary">check</button>
		</form>

		<div id="showresult" class='cart'>
    <?php
				if ($to != null and $from != null) {
					$url = $uu . "/testapi.php?from=" . $from . "&to=" . $to . "&convertparam=" . $convertparam . "&type=" . $type;

					echo "Check from:" . $url . "<hr/>";
					// Get cURL resource
					$curl = curl_init ();
					// Set some options - we are passing in a useragent too here
					curl_setopt_array ( $curl, array (
							CURLOPT_RETURNTRANSFER => 1,
							CURLOPT_URL => $url,
							CURLOPT_USERAGENT => 'Codular Sample cURL Request'
					) );
					// Send the request & save response to $resp
					$JSON = curl_exec ( $curl );
					// Close request to clear up some resources
					curl_close ( $curl );

					// var_dump($JSON);

					$json_decoded = json_decode ( $JSON );

					echo "<div> Strat Date: " . $json_decoded->from . "</div>";
					echo "<div> End Date: " . $json_decoded->to . "</div>";
					echo "<div> Days: " . $json_decoded->days . "</div>";
					echo "<div> Weekdays: " . $json_decoded->weekdays . "</div>";
					echo "<div> Complete Weeks: " . $json_decoded->completeweeks . "</div>";
					echo "<div> Converted Item: " . $json_decoded->convertparam . "</div>";
					echo "<div> Converted To: " . $json_decoded->type . "</div>";
				}
				?>
    </div>



		<!-- Optional JavaScript -->
		<!-- jQuery first, then Popper.js, then Bootstrap JS -->
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
			integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
			crossorigin="anonymous"></script>
		<script
			src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
			integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
			crossorigin="anonymous"></script>
		<script
			src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
			integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
			crossorigin="anonymous"></script>
	</div>
</body>
</html>