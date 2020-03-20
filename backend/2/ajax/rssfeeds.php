<?php
date_default_timezone_set('Europe/London');
require_once 'libs/Feed.php';
$FEEDS = [  "DO" =>
                            [
                              "URL" => "https://status.digitalocean.com/rss",
                              "TAG" => "DigitalOcean",
                              "COLOR" => "#0080ff",
                            ],
            "UptimeRobot" =>
                           [
                             "URL" => "http://rss.uptimerobot.com/u244535-4f2dc61d1879d814c3c4961c67ba6ca0",
                             "TAG" => "UptimeRobot",
                             "COLOR" => "#4CA74C"
                           ],
             "Twilio" =>
                            [
                              "URL" => "https://status.twilio.com/history.rss",
                              "TAG" => "Twilio",
                              "COLOR" => "#F12545"
                            ],
              /*"BBCWeather" =>
                             [
                               "URL" => "http://open.live.bbc.co.uk/weather/feeds/en/2633906/3dayforecast.rss",
                               "TAG" => "Weather",
                               "COLOR" => "#F12545"
                             ],
                             */
               ];
$ITEMS = [];
foreach ($FEEDS as $FEED) {
  $rss = Feed::loadRss($FEED["URL"]);
  foreach ($rss->item as $item) {
    if ((int) $item->timestamp > (time()-(86400*2))) {
      $ITEMS[] = ["FEED" => $FEED, "TIMESTAMP" =>  (int) $item->timestamp, "TITLE" => htmlSpecialChars($item->title), "DESCRIPTION" => ($item->description)];
    }
  }
}
usort($ITEMS, function($a, $b) {
    return $b["TIMESTAMP"] <=> $a["TIMESTAMP"];
});

?>
<table border="0"  bgcolor="black">
<?php foreach ($ITEMS as $ITEM) { ?>

  <tr>
    <td colspan="2" style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: <?=$ITEM["FEED"]["COLOR"]?>;"><?=$ITEM["TITLE"]?></td>
  </tr>
  <tr>
    <td colspan="2" style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; color: white;"><?=$ITEM["DESCRIPTION"]?></td>
  </tr>
  <tr>
    <td style="font-family: Arial, Helvetica, sans-serif; font-size: 14px; font-weight: bold; color: <?=$ITEM["FEED"]["COLOR"]?>;">[<?=$ITEM["FEED"]["TAG"]?>]</td>
    <td style="font-family: Arial, Helvetica, sans-serif; font-size: 14px; color: white; text-align: right;"><?=date("j.n.Y H:i", $ITEM["TIMESTAMP"])?></td>
  </tr>
  <tr><td colspan="2" style="height: 2px; background-color: #B0B0B0;"></td></tr>
<?php } ?>
</table>
