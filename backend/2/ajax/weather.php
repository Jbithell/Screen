<?php
header('Content-Type: application/json');
$weather = json_decode(file_get_contents("http://api.openweathermap.org/data/2.5/weather?q=London,uk&appid=a322902e35ebc807e080a5eab90d2b42"), true);

$newweather['temp'] = $weather["main"]['temp']-273.15;
$newweather['humidity'] = $weather["main"]["humidity"];
$newweather['wind'] = $weather['wind']['speed']*2.23694;

die(json_encode($newweather));
?>
