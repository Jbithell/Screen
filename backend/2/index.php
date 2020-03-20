<!DOCTYPE html>
<html>
<head>
	<!--CSS-->
	<link href="libs/bootstrap.min.css" rel="stylesheet" />
	<!--<meta name="viewport" content="width=device-width, initial-scale=1">-->
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
	.bootbox {
		color: black;
	}
	</style>


	<!--Scripts - Requires module system to work with Electron-->
	<script>if (typeof module === 'object') {window.module = module; module = undefined;}</script>

	<script language="JavaScript" type="text/javascript" src="libs/jquery.min.js"></script>
	<script language="JavaScript" type="text/javascript" src="libs/bootstrap.min.js"></script>
	<script language="JavaScript" type="text/javascript" src="libs/jquery.marquee.min.js"></script>
	<script language="JavaScript" type="text/javascript" src="libs/buzz.min.js"></script>
	<script language="JavaScript" type="text/javascript" src="libs/bootbox.min.js"></script>
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

	<script>if (window.module) module = window.module;</script>


	<!--Titles and Settings-->
	<title>Clock</title>

</head>
<body>
	<table border="0" style="width: 100%; height:100%; overflow:hidden;">
		<tr style="width: 100%; vertical-align: top;">
			<td colspan="3" style="width: 100%;"><div class="container"><div class="row" id="timekeeperlive"></div></div></td>
			<td id="time" style="width: 200px; text-align: right; color: red; font-size: 200%;"></td>
		</tr>
		<tr style="width: 100%; vertical-align: top;">
			<td style="min-width: 220px;">
				<table border="0" style="width: 100%;" id="tubetable">
				</table>
				<div id="sunrisesunset" style="width: 100%; color: red;"></div>

				<div id="bbcnews" style="width: 100%; color: red;">

				</div>
			</td>
			<td style="width: 40%" tabindex="-1">
				<div style="width: 500px; padding: 2px; " id="exchangerate"></div>
				<hr/>
				<div style="width: 500px; padding: 2px; " id="rss"></div>
				<!--<script type="text/javascript">document.write('\x3Cscript type="text/javascript" src="' + ('https:' == document.location.protocol ? 'https://' : 'http://') + 'feed.mikle.com/js/rssmikle.js">\x3C/script>');</script><script type="text/javascript">(function() {var params = {rssmikle_url: "https://status.digitalocean.com/rss|https://status.twilio.com/history.rss|http://rss.uptimerobot.com/u244535-4f2dc61d1879d814c3c4961c67ba6ca0",rssmikle_frame_width: "500",rssmikle_frame_height: "940", frame_height_by_article: "0",rssmikle_target: "_top",rssmikle_font: "Arial, Helvetica, sans-serif",rssmikle_font_size: "11",rssmikle_border: "off",responsive: "off",rssmikle_css_url: "",text_align: "left",text_align2: "center",corner: "off",scrollbar: "off",autoscroll: "off",scrolldirection: "down",scrollstep: "3",mcspeed: "20",sort: "New",rssmikle_title: "off",rssmikle_title_sentence: "",rssmikle_title_link: "",rssmikle_title_bgcolor: "#0066FF",rssmikle_title_color: "#FFFFFF",rssmikle_title_bgimage: "",rssmikle_item_bgcolor: "#000000",rssmikle_item_bgimage: "",rssmikle_item_title_length: "200",rssmikle_item_title_color: "#FF0000",rssmikle_item_border_bottom: "off",rssmikle_item_description: "on",item_link: "off",rssmikle_item_description_length: "500",rssmikle_item_description_color: "#FFFFFF",rssmikle_item_date: "on",rssmikle_timezone: "Europe/London",datetime_format: "%e.%m.%Y %l:%M %p",item_description_style: "text",item_thumbnail: "full",item_thumbnail_selection: "auto",article_num: "200",rssmikle_item_podcast: "off",keyword_inc: "",keyword_exc: ""};feedwind_show_widget_iframe(params);})();</script><div style="font-size:10px; text-align:center; width:500px;"><a href="http://feed.mikle.com/" target="_blank" style="color:#CCCCCC;">RSS Feed Widget</a></div>-->
				<!-- start feedwind code -->
				<!--<iframe  id="rss" height="940"  width="500" src="http://feed.mikle.com/widget/?rssmikle_url=https%3A%2F%2Fstatus.digitalocean.com%2Frss%7Chttps%3A%2F%2Fstatus.twilio.com%2Fhistory.rss%7Chttp%3A%2F%2Frss.uptimerobot.com%2Fu244535-4f2dc61d1879d814c3c4961c67ba6ca0&rssmikle_frame_width=500&rssmikle_frame_height=940&frame_height_by_article=0&rssmikle_target=_top&rssmikle_font=Arial%2C%20Helvetica%2C%20sans-serif&rssmikle_font_size=11&rssmikle_border=off&responsive=off&text_align=left&text_align2=center&corner=off&scrollbar=off&autoscroll=off&scrolldirection=down&scrollstep=3&mcspeed=20&sort=New&rssmikle_title=off&rssmikle_title_bgcolor=%230066FF&rssmikle_title_color=%23FFFFFF&rssmikle_item_bgcolor=%23000000&rssmikle_item_title_length=200&rssmikle_item_title_color=%23FF0000&rssmikle_item_border_bottom=off&rssmikle_item_description=on&item_link=off&rssmikle_item_description_length=500&rssmikle_item_description_color=%23FFFFFF&rssmikle_item_date=on&rssmikle_timezone=Europe%2FLondon&datetime_format=%25e.%25m.%25Y%20%25l%3A%25M%20%25p&item_description_style=text&item_thumbnail=full&item_thumbnail_selection=auto&article_num=200&rssmikle_item_podcast=off&" scrolling="no" name="rssmikle_frame" marginwidth="0" marginheight="0" vspace="0" hspace="0" frameborder="0"></iframe>-->
			</td>
			<td style="width: 60%;" colspan="2">
				<!--<iframe id="calendar" src="https://calendar.google.com/calendar/embed?showTitle=0&amp;showNav=0&amp;showDate=0&amp;showPrint=0&amp;showTabs=0&amp;showCalendars=0&amp;mode=AGENDA&amp;height=940&amp;wkst=1&amp;hl=en_GB&amp;bgcolor=%23000000&amp;src=bitautocal%40gmail.com&amp;color=%23A32929&amp;ctz=Europe%2FLondon" style="border-width:0" width="500" height="940" frameborder="0" scrolling="no"></iframe>-->
				<table style="width: 500px;">
					<tr>
						<td><div id="demand" style="width: 248px; display:inline-block;"></div></td>
						<td><div id="frequency" style="width: 248px; display:inline-block;"></div></td>
					</tr>
				</table>
				<div id="gridcharts" style="width: 100%;"><div id="humiditychart" style="display:inline-block;"></div><div id="tempchart" style="display:inline-block;"></div><div id="windchart" style="display:inline-block;"></div></div>


			</td>
		</tr>
	</table>

	<div id="sound_div" style="display: none;"><!--Mobile Browsers will only play sound on user interaction--></div>
</body>
<script>
	var timekeeperliveoutput = "";
	function hoursminutessecs(time) {
		output = '';
		if ((time/60)/60 > 1) {
			hours = Math.floor((time/60)/60);
			output += hours + ' hour' + (hours != 1 ? 's' : '') + ', ';
			time -= hours*60*60;
		}
		if ((time/60) > 1) {
			minutes = Math.floor(time/60);
			output += minutes + ' minute' + (minutes != 1 ? 's' : '') + ' &amp; ';
			time -= minutes*60;
		}
		seconds = Math.round(time);
		output += seconds + ' sec' + (seconds != 1 ? 's' : '');
		return output;
	}
	$( document ).ready(function() {
		//Time function
		function startTime() {
			var today = new Date();
			var h = today.getHours();
			var m = today.getMinutes();
			var s = today.getSeconds();
			m = checkTime(m);
			s = checkTime(s);

			var dd = today.getDate();
			var mm = today.getMonth()+1; //January is 0!
			var yyyy = today.getFullYear();

			if(dd<10) {
			    dd='0'+dd
			}

			if(mm<10) {
			    mm='0'+mm
			}

			$("#time").html(h + ":" + m + ":" + s + "<br/>" + dd + '/' + mm + '/' + yyyy);
			var t = setTimeout(startTime, 500);
		}
		//Countup Function
		setInterval(function() {
			$('.countup').each(
				function(){
					$( this ).html(hoursminutessecs((Date.now()/1000) - $(this).data("countupfrom")));
				}
			); //Change the timers
		}, 1000);
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
				url: 'ajax/tubestatus.php',
				//url: 'https://api.tfl.gov.uk/Line/Mode/tube/Status',
				success: function(data) {
					console.log(data);
					$("#tubetable").html("");
					var statustext = "";
					$(data).each(function(index,value) {
						$("#tubetable").append('<tr><td style="width: 100%; height: 30px; padding: 2px; background-color: #' + value.hex + ';">' + value.name + '</td><td style="min-width: 30px; background-color: #' + value.statushex + ';"></td></tr>');
						if (value.statusdetails) {
							statustext += (statustext.length > 1 ? " | " : "      TFL Status: ") + value.name + ": " + value.statusdetails
						}
					});
				}
			});
			return false;
		}
		function currency() {
		$.ajax({
				url: 'ajax/exchangerate.php',
				success: function(data) {
					console.log(data);
					var output = "";
					$(data).each(function(index,value) {
						output += "<tr><td style='padding: 4px;'><b>" + value.ID + ":  </b></td><td style='padding: 4px;'>" + value.VAL + "</td><td style='padding: 4px;'>" + (1/value.VAL).toFixed(4) + "</td></tr>";
					});
					$("#exchangerate").html('<table border="0">' + output + '</table>');
				}
			});
			return false;
		}
		function timekeeperlive() {
			$.ajax({
				url: 'http://jbithell.com/projects/timekeeper/api/screen/currentrfidsessions.php',
				success: function(data) {
					console.log(data);
					var output = "";
					$(data).each(function(index,value) {
						output += '<div class="col-lg-3"><div class="panel panel-default"><div class="panel-heading">' + value.timekeeper_projects_name + '</div><div class="panel-body countup" data-countupfrom="' + value.timestampstart + '"></div></div></div>';
					});
					if (output != timekeeperliveoutput) {
						$("#timekeeperlive").html(output);
						timekeeperliveoutput = output;
					}
					return true;
				}
			});
			return false;
		}
		function bbcnews() {
			parseRSS("http://feeds.bbci.co.uk/news/rss.xml", function (data) {
				var newstext = "";
				$(data.entries).each(function( index, value) {
					newstext += "" + value.title + "<br/>";
				});
				newstext += "";
				$("#bbcnews").html(newstext);
			});
			return false;
		}
		function rssfeeds() {
			$.ajax({
				url: 'ajax/rssfeeds.php',
				success: function(data) {
					$("#rss").html(data);
					return true;
				}
			});
			return false;
		}
		function refresh() {
			tubestatus();
			currency();
			bbcnews();
			rssfeeds();
			//$('#rss').attr( 'src', function ( i, val ) { return val; }); //Reload the iframe
			//$('#calendar').attr( 'src', function ( i, val ) { return val; }); //Reload the iframe
			$('.refreshimg').each(function(i, obj) {
				$(this).attr('src', $(this).attr('src')+'?'+Math.random());
			});
		}

		//Gridwatch
		var griddata = {};
		var weatherdata = {};
		$.ajax({
			url: 'ajax/gridwatch.php',
			type: 'json',
			success: function(data) {
				var gridinitial = data;
				google.charts.load('current', {'packages':['gauge']});
				google.charts.setOnLoadCallback(function() {
					var demand = google.visualization.arrayToDataTable([
						['Label', 'Value'],
						['Demand', 0],
					]);
					var demandoptions = {
						width: 248, height: 248,
						redFrom: 60, redTo: 70,
						yellowFrom:50, yellowTo: 60,
						minorTicks: 5, max:70
					};
					var demandchart = new google.visualization.Gauge(document.getElementById('demand'));
		  		  	demandchart.draw(demand, demandoptions);

					var frequency = google.visualization.arrayToDataTable([
						['Label', 'Value'],
						['Frequency', 50],
					]);
					var frequencyoptions = {
						width: 248, height: 248,
						redFrom: 50.1, redTo: 50.5,
						yellowFrom:49.5, yellowTo: 49.9,
						minorTicks: 5, max:50.5, min:49.5
					};
					var frequencychart = new google.visualization.Gauge(document.getElementById('frequency'));
		  		  	frequencychart.draw(frequency, frequencyoptions);


					var handledfueltypes = {};
					$.each(gridinitial.FUELS, function( index, value ) {
						$("#gridcharts").append('<div id="' + value.TYPE + 'chart" style="display:inline-block;"></div>')
						fueltype = value.TYPE;
						value.data = google.visualization.arrayToDataTable([
							['Label', 'Value'],
							[fueltype, 0]
						]);
						value.options = {
							width: 124, height: 124,
							redFrom: 80, redTo: 100,
							yellowFrom:50, yellowTo: 80,
							minorTicks: 5, max:100
						};
						value.chart = new google.visualization.Gauge(document.getElementById(value.TYPE + 'chart'));
						value.chart.draw(value.data, value.options);
						handledfueltypes[index] = value;
					});

					setInterval(function() {
						if (typeof(griddata.TOTAL) != "undefined") {
							console.log("Refreshing Grid");
							var gridstuff = griddata;
							demand.setValue(0, 1, griddata.TOTAL/1000);
							demandchart.draw(demand, demandoptions);
							frequency.setValue(0, 1, griddata.FREQUENCY);
							frequencychart.draw(frequency, frequencyoptions);

							$.each(handledfueltypes, function(index,value) {
								value.data.setValue(0, 1, (griddata["FUELS"][index]["VAL"]/griddata["TOTAL"])*100);
								value.chart.draw(value.data, value.options);
							});
						}
					}, 1000);


					//Weather stuff
					var tempdata = google.visualization.arrayToDataTable([
						['Label', 'Value'],
						['Temperature', 0],
					]);
					var tempoptions = {
						width: 124, height: 124,
						redFrom: 25, redTo: 35,
						yellowFrom:-10, yellowTo: 5,
						minorTicks: 5, max:35, min:-10
					};
					var tempchart = new google.visualization.Gauge(document.getElementById('tempchart'));
		  		  	tempchart.draw(tempdata, tempoptions);

					var humiditydata = google.visualization.arrayToDataTable([
						['Label', 'Value'],
						['Humidity', 0],
					]);
					var humidityoptions = {
						width: 124, height: 124,
						redFrom: 85, redTo: 100,
						yellowFrom:65, yellowTo: 85,
						minorTicks: 5, max:100, min:0
					};
					var humiditychart = new google.visualization.Gauge(document.getElementById('humiditychart'));
		  		  	humiditychart.draw(humiditydata, humidityoptions);

					var winddata = google.visualization.arrayToDataTable([
						['Label', 'Value'],
						['Wind', 0],
					]);
					var windoptions = {
						width: 124, height: 124,
						redFrom: 60, redTo: 150,
						yellowFrom:40, yellowTo: 60,
						minorTicks: 5, max:150, min: 0
					};
					var windchart = new google.visualization.Gauge(document.getElementById('windchart'));
		  		  	windchart.draw(winddata, windoptions);


					setInterval(function() {
						if (typeof(weatherdata.temp) != "undefined") {
							console.log("Refreshing Weather");

							tempdata.setValue(0, 1, weatherdata.temp);
							tempchart.draw(tempdata, tempoptions);

							humiditydata.setValue(0, 1, weatherdata.humidity);
							humiditychart.draw(humiditydata, humidityoptions);

							winddata.setValue(0, 1, weatherdata.wind);
							windchart.draw(winddata, windoptions);
						}
					}, 1000);

				});
			}
		});





		$.ajax({
			url: 'ajax/gridwatch.php',
			type: 'json',
			success: function(data) {
				console.log(data);
				griddata = data;
				return true;
			}
		});
		setInterval(function() {
			$.ajax({
				url: 'ajax/gridwatch.php',
				type: 'json',
				success: function(data) {
					console.log(data);
					griddata = data;
					return true;
				}
			});
		}, 1000 * 60 * 2);

		$.ajax({
			url: 'ajax/weather.php',
			type: 'json',
			success: function(data) {
				console.log(data);
				console.log("get weather");
				weatherdata = data;
				return true;
			}
		});
		setInterval(function() {
			$.ajax({
				url: 'ajax/weather.php',
				type: 'json',
				success: function(data) {
					console.log(data);
					weatherdata = data;
					return true;
				}
			});
		}, 5 * 60 * 1000); //Every 5 Minutes - roughly when the api is refreshed

		$.ajax({
			url: 'ajax/sunrisesunset.php',
			type: 'json',
			success: function(data) {
				$("#sunrisesunset").html(data.text);
				console.log(data);
				return true;
			}
		});
		setInterval(function() {
			$.ajax({
				url: 'ajax/sunrisesunset.php',
				type: 'json',
				success: function(data) {
					console.log(data);
					$("#sunrisesunset").html(data.text);
					return true;
				}
			});
		}, 60 * 60 * 1000); //Every hour



		refresh();
		startTime();
		setInterval(function() {
			refresh();
			//location.reload();
		}, 2 * 60 * 1000);
		setInterval(function() {
			timekeeperlive();
		}, 1000);


		/* setInterval(function() {
			window.location.reload();
		}, 60 * 60 * 1000); */ //Daily Reload - Disabled because of server snapshot system


		$(document).keypress(function(e) {
			console.log(e.key);
			if (e.key == "+") {
				bootbox.prompt("Enter User ID Key", function(result) {
					if (result !== null) {
						key = result;
						bootbox.prompt("Enter User ID Pass", function(result) {
							if (result !== null) {
								pass = result;
								$.ajax({
									url: 'http://jbithell.com/projects/timekeeper/api/pi2/navigation.php?keycode=' + key + '&keypass=' + pass,
									success: function(data) {
										console.log(data);
										if (!data.result) {
											bootbox.alert("Sorry - No projects found");
										} else {
											var alert = '<center>';
											$(data.projects.PROJECTS).each(function(index,value) {
												alert += '<button type="button" tabindex="' + index + '" class="btn btn-default starttimekeeper" data-projectid="' + value.DATA.timekeeper_projects_projectid + '" data-userid="' + data.userid + '" style="margin: 5px;">' + value.DATA.timekeeper_projects_name + '</button>';
											});
											bootbox.dialog({
												message: alert + "</center>",
												title: "Projects"
											});
										}
									}
								});
							}
						});
					}
				});
			} else if (e.key == "*") {
				location.reload();
			}
		});



		$(".starttimekeeper").on("click", function(e) {
			console.log("Click");
			bootbox.hideAll();
			$.ajax({
				url: 'http://jbithell.com/projects/timekeeper/api/pi2/startsession.php?projectid=' + $(this).data("projectid") + '&userid=' + $(this).data("userid"),
				success: function(data) {
					console.log(data);
				}
			});
		});
		//playsound();
	});

	function playsound() {
		try {
			var sound = new buzz.sound( "/1/sounds/jerusalem-organ1", {
				formats: ["mp3"]
			});
			sound.play().fadeIn();
		}
		catch(err) {
			alert(err);
		}
	}
</script>
</html>
