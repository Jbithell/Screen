<!DOCTYPE html>
<html>
<head>
	<!--Includes-->
	<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.1/jquery.min.js"></script>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/css/bootstrap.min.css" rel="stylesheet" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/js/bootstrap.min.js"></script>
	<script src="//cdn.jsdelivr.net/jquery.marquee/1.3.9/jquery.marquee.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/buzz/1.1.10/buzz.min.js"></script>-->
	<link href="libs/bootstrap.min.css" rel="stylesheet" />
	
	<script>if (typeof module === 'object') {window.module = module; module = undefined;}</script>
	
	
	
	<script language="JavaScript" type="text/javascript" src="libs/jquery.min.js"></script>
	
	<script language="JavaScript" type="text/javascript" src="libs/bootstrap.min.js"></script>
	<script language="JavaScript" type="text/javascript" src="libs/jquery.marquee.min.js"></script>
	<script language="JavaScript" type="text/javascript" src="libs/buzz.min.js"></script>
	
	
	<script>if (window.module) module = window.module;</script>
	
	
	
	<!--Style-->
	<style>
	/* Marquee Plugin */
	.marquee {
		overflow: hidden;
		border:1px solid #ccc;
	}

	body {
		background-color: black;
		color: white;
	}
	</style>

	<!--Titles and Settings-->
	<title>Clock</title>
</head>
<body>
	<div class='marquee' style="color: red; font-size: 250%; border: 0; " data-duration='7000' data-gap='02' data-duplicated='true' id="bbcnews-ticker"></div><!--background-color: #BB1919;-->
	<table border="0" style="width: 100%;">
		<tr style="width: 100%;" >
			<td>
				<table border="0" style="width: 100%;" id="tubetable">
				</table>
			</td>
			<td colspan="2" id="time" style="text-align: center; color: red; font-size: 1400%;"></td>
		</tr>
	</table>
	<div class='marquee' style="display: none; color: red; font-size: 200%; border: 0;" data-duration='7000' data-gap='02' data-duplicated='true' id="tube-ticker"></div><!-- background-color: #000099;-->

	<div id="sound_div" style="display: none;"><!--Mobile Browsers will only play sound on user interaction--></div>
</body>
<script>
	
	$( document ).ready(function() {
		var $mq = $('#bbcnews-ticker');
		var $tubemq =  $('#tube-ticker');
		function startTime() {
			var today = new Date();
			var h = today.getHours();
			var m = today.getMinutes();
			var s = today.getSeconds();
			m = checkTime(m);
			s = checkTime(s);
			$("#time").html(h + ":" + m + ":" + s);
			var t = setTimeout(startTime, 500);
		}
		function checkTime(i) {
			if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
			return i;
		}
		function parseRSS(url, callback) {
			$.ajax({
				url: document.location.protocol + '//ajax.googleapis.com/ajax/services/feed/load?v=1.0&num=10&callback=?&q=' + encodeURIComponent(url),
				dataType: 'json',
				success: function(data) {
					callback(data.responseData.feed);
				}
			});
			return true;
		}
		function tubestatus() {
			$.ajax({
				url: '../ajax/tubestatus.php',
				//url: 'https://api.tfl.gov.uk/Line/Mode/tube/Status',
				success: function(data) {
					console.log(data);
					$("#tubetable").html("");
					var statustext = "";
					$(data).each(function(index,value) {
						$("#tubetable").append('<tr><td style="width: 30px; height: 30px; padding: 2px; background-color: #' + value.hex + ';"></td><td style="width: 30px; background-color: #' + value.statushex + ';"></td></tr>');
						if (value.statusdetails) {
							statustext += (statustext.length > 1 ? " | " : "      TFL Status: ") + value.name + ": " + value.statusdetails
						}
					});
					$("#tube-ticker").hide();
					if (statustext.length > 1) {
						console.log(statustext);
						$("#tube-ticker").show();
						$tubemq
							.marquee('destroy')
							.html(statustext)
							.marquee();

					}
				}
			});
			return false;
		}
		function bbcnews() {
			parseRSS("http://feeds.bbci.co.uk/news/rss.xml", function (data) {
				var newsticker = "";
				$(data.entries).each(function( index, value) {
					newsticker += (newsticker.length > 1 ? " | " : "      BBC News: ") + value.title;
				});
				$mq
					.marquee('destroy')
					.html(newsticker)
					.marquee();
			});
			return false;
		}
		function refresh() {
			tubestatus();
			bbcnews();
			console.log(window.screen.availWidth + "x" + window.screen.availHeight);
		}
		refresh();
		startTime();
		setInterval(function() {
			refresh();
		}, 2 * 60 * 1000);
		$("#sound_div").click(function(){
			var sound = new buzz.sound( "sounds/jerusalem-organ1", {
				formats: ["mp3"]
			});
			sound.play().fadeIn();
		});
		/* setInterval(function() {
			window.location.reload();
		}, 60 * 60 * 1000); */ //Daily Reload - Disabled because of server snapshot system
	});
</script>
</html>
