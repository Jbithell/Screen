<?php
header('Content-Type: application/json');
date_default_timezone_set('UTC');
/*
class Grid {
	public function get() {
		$xml = simplexml_load_string(file_get_contents("http://www.bmreports.com/bsp/additional/soapfunctions.php?element=generationbyfueltypetable"), "SimpleXMLElement", LIBXML_NOCDATA);
		$SERVERDATA = json_decode(json_encode($xml),TRUE); //Remove all the messy object stuff
		unset($xml);
		var_dump($SERVERDATA);
		if (!isset($SERVERDATA['INST'])) die("Unable to get data"); //Bit of error handling
		DIE("TEST");
		//Begin Parsing
		$DATA['TOTAL'] = $SERVERDATA['INST']["@attributes"]["TOTAL"];
		$DATA['UPDATED'] = $SERVERDATA['INST']["@attributes"]["AT"]; //This is a UTC timestamp
		$DATA['FUELS'] = array();
		foreach ($SERVERDATA['INST']['FUEL'] as $FUEL) {
			$DATA['FUELS'][] = $FUEL["@attributes"];
		}

		//Get Frequency
		$xml = simplexml_load_string(file_get_contents("http://www.bmreports.com/bsp/additional/soapfunctions.php?output=XML&element=rollingfrequency&submit=Invoke"), "SimpleXMLElement", LIBXML_NOCDATA);
		$SERVERFREQUENCYDATA = json_decode(json_encode($xml),TRUE); //Remove all the messy object stuff, again
		unset($xml);
		if (!isset($SERVERFREQUENCYDATA["ST"])) die("Unable to get data");
		$SERVERFREQUENCYDATA = end($SERVERFREQUENCYDATA['ST']);
		if (!isset($SERVERFREQUENCYDATA["@attributes"]['VAL'])) die("Unable to get data");
		$DATA['FREQUENCY'] = $SERVERFREQUENCYDATA["@attributes"]['VAL'];
		return $DATA;
	}
}

die(json_encode([]));
*/
class Grid {
	public function get($APIKEY) {
		$xml = simplexml_load_string(file_get_contents("https://api.bmreports.com/BMRS/FUELINSTHHCUR/v1?APIKey=" . $APIKEY . "&ServiceType=xml"), "SimpleXMLElement", LIBXML_NOCDATA);
		$SERVERDATA = json_decode(json_encode($xml),TRUE); //Remove all the messy object stuff
		if (isset($SERVERDATA["responseMetadata"]["httpCode"]) and $SERVERDATA["responseMetadata"]["httpCode"] == 200) {
			$DATA['TOTAL'] = $SERVERDATA["responseBody"]["total"]["currentTotalMW"];
			$DATA['UPDATED'] = strtotime($SERVERDATA["responseBody"]["dataLastUpdated"]);
			$DATA['FUELS'] = array();
			foreach ($SERVERDATA["responseBody"]["responseList"]["item"] as $FUEL) {
					if ($FUEL["activeFlag"] == "Y") {
						$DATA['FUELS'][] = ["VAL" => $FUEL["currentMW"], "PERCENTAGE" => $FUEL["currentPercentage"], "TYPE" => $FUEL["fuelType"]];
					}
			}

			//Get the frequency
			$xml = simplexml_load_string(file_get_contents("https://api.bmreports.com/BMRS/FREQ/v1?APIKey=" . $APIKEY . "&ServiceType=xml&FromDateTime=" . urlencode(date("Y-m-d H:i:s", (time()-120))) . "&ToDateTime=" . urlencode(date("Y-m-d H:i:s")) . ""), "SimpleXMLElement", LIBXML_NOCDATA); //Get the last 2 minutes of data
			$SERVERDATA = json_decode(json_encode($xml),TRUE); //Remove all the messy object stuff
			if (isset($SERVERDATA["responseMetadata"]["httpCode"]) and $SERVERDATA["responseMetadata"]["httpCode"] == 200) {
				$FREQUENCYVALUES = [];
				foreach ($SERVERDATA["responseBody"]["responseList"]["item"] as $FREQUENCYVALUE) {
					 $FREQUENCYVALUES[] = ["VALUE" => $FREQUENCYVALUE["frequency"], "TIME" => strtotime($FREQUENCYVALUE["reportSnapshotTime"] . " " . $FREQUENCYVALUE["spotTime"])];
				}
				usort($FREQUENCYVALUES, function($a, $b) {
				    return $a["TIME"] - $b["TIME"];
				});
				$DATA['FREQUENCY'] = end($FREQUENCYVALUES)["VALUE"];
			} else $DATA['FREQUENCY'] = 0; //Cannot get frequency
			return $DATA;
		} else {
			//Error getting data
			throw new Exception("Unable to get Grid Data");
			return false;
		}
	}
}
echo json_encode(Grid::get("sfspzytpf85pk2j"));
?>
