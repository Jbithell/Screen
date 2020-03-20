<?php
header('Content-Type: application/json');
$result = json_decode(file_get_contents("http://api.sunrise-sunset.org/json?lat=51.5526203&lng=-0.23200299999996332"), true);
if ($result['status'] != "OK") die("ERROR");
date_default_timezone_set("Europe/London");

$output['sunrise'] = strtotime(date("Y-m-d") . $result['results']["sunrise"]);
$output['sunset'] = strtotime(date("Y-m-d") . $result['results']["sunset"]);
if (date('I')) { //correct for daylight saving
	$output['sunrise'] = $output['sunrise']+3600;
	$output['sunset'] = $output['sunset']+3600;
}
$output['text'] = date("h:i:s A", $output['sunrise']) . " - " . date("h:i:s A", $output['sunset']);
die(json_encode($output));
?>
