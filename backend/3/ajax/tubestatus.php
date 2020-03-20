<?php
//header('Content-Type: application/json');
$xml = simplexml_load_string(file_get_contents('http://cloud.tfl.gov.uk/TrackerNet/LineStatus'));
$json = json_encode($xml);
$array = json_decode($json,TRUE)["LineStatus"];
$return = [];
function statushex($status) {
	switch ($status) {
		case "GS": //Good Service
			return "008000";
		case "PC": //Part Closure
			return "FF0000";
		default:
			return "FF0000";
	}
}
$returnstring = "";
for($x = 0; $x < count($array); $x++) {
	$thisreturn = [];
	switch ($array[$x]["Line"]["@attributes"]["ID"]) {
		case 1: //Bakerloo
			$thisreturn["hex"] = "996633";
			break;
		case 2: //Central
			$thisreturn["hex"] = "cc3333";
			break;
		case 3: //Victoria
			$thisreturn["hex"] = "00A9E0";
			break;
		case 4: //Jubilee
			$thisreturn["hex"] = "669999";
			break;
		case 5: //Northern
			$thisreturn["hex"] = "000000";
			break;
		case 6: //Piccadilly
			$thisreturn["hex"] = "10069F";
			break;
		case 7: //Circle
			$thisreturn["hex"] = "ffcc00";
			break;
		case 8: //Hammersmith and City
			$thisreturn["hex"] = "ff9999";
			break;
		case 9: //District
			$thisreturn["hex"] = "006633";
			break;

		case 11: //Metropolitan
			$thisreturn["hex"] = "990066";
			break;
		case 12:
			$thisreturn["hex"] = "6ECEB2";
			break;
		case 81: //DLR
			$thisreturn["hex"] = '009999';
			break;
		case 82: //London Overground
			$thisreturn["hex"] = "ff6600";
			break;
		case 83: //TFL Rail/Crossrail
			$thisreturn["hex"] = '000099';
			break;
		default:
			$thisreturn["hex"] = "10069F";
	}
	$thisreturn['name'] = $array[$x]["Line"]["@attributes"]["Name"];
	$thisreturn['status'] = $array[$x]["Status"]["@attributes"]["Description"];
	$thisreturn["statuscode"] = $array[$x]["Status"]["@attributes"]["ID"];
	//if ($thisreturn["statuscode"] != 'GS') {
	//	$thisreturn['statusdetails'] = $array[$x]["@attributes"]["StatusDetails"];
	//} else $thisreturn['statusdetails'] = false;
	//$thisreturn['statushex'] = statushex($thisreturn["statuscode"]);
	if ($thisreturn["statuscode"] != 'GS') $returnstring .= (strlen($returnstring)>0 ? " | " : null) . $thisreturn['name'] . " " . $thisreturn['status'];
	$return[] = $thisreturn;
}
if (strlen($returnstring) <1) die("Good Service");
die($returnstring);
?>
