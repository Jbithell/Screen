<?php
$netdataserverone = $_GET['server1'];
?>
<script>
// this section has to appear before loading dashboard.js
// Select a theme.
// uncomment on of the two themes:
// var netdataTheme = 'default'; // this is white
var netdataTheme = 'slate'; // this is dark
// Set the default netdata server.
// on charts without a 'data-host', this one will be used.
// the default is the server that dashboard.js is downloaded from.
var netdataServer = '<?=$netdataserverone?>';
</script>

<!--
	Load dashboard.js
	to host this HTML file on your web server,
	you have to load dashboard.js from the netdata server.
	So, pick one the two below
	If you pick the first, set the server name/IP.
	The second assumes you host this file on /usr/share/netdata/web
	and that you have chown it to be owned by netdata:netdata
-->
<script type="text/javascript" src="<?=$netdataserverone?>/dashboard.js"></script>

<script>
// Set options for TV operation
// This has to be done, after dashboard.js is loaded
// destroy charts not shown (lowers memory on the browser)
NETDATA.options.current.destroy_on_hide = true;

// set this to false, to always show all dimensions
NETDATA.options.current.eliminate_zero_dimensions = true;

// lower the pressure on this browser
NETDATA.options.current.concurrent_refreshes = false;
// if the tv browser is too slow (a pi?)
// set this to false
NETDATA.options.current.parallel_refresher = false;
// always update the charts, even if focus is lost
// NETDATA.options.current.stop_updates_when_focus_is_lost = false;
// Since you may render charts from many servers and any of them may
// become offline for some time, the charts will break.
// This will reload the page every RELOAD_EVERY minutes
var RELOAD_EVERY = 0.5;
setTimeout(function(){
	location.reload();
}, RELOAD_EVERY * 60 * 1000);
</script>

<div style="width: 100%; height: 200px; text-align: center; display: inline-block;">
	<br/>
	<div data-netdata="system.cpu"
			data-title="CPU"
			data-chart-library="dygraph"
			data-width="49%"
			data-height="100%"
			data-after="-300"
			></div>
</div>
<div style="width: 100%; height: 200px; text-align: center; display: inline-block;">
	<div data-netdata="apache.requests"
			data-title="Apache Requests"
			data-chart-library="dygraph"
			data-width="49%"
			data-height="100%"
			data-after="-300"
			></div>
</div>
<div style="width: 100%; height: 200px; text-align: center; display: inline-block;">
	<div data-netdata="system.ipv4"
			data-title="IPv4"
			data-chart-library="dygraph"
			data-width="49%"
			data-height="100%"
			data-after="-300"
			></div>
</div>
<div style="width: 100%; height: 200px; text-align: center; display: inline-block;">
	<div data-netdata="system.ram"
			data-title="Ram"
			data-chart-library="dygraph"
			data-width="49%"
			data-height="100%"
			data-after="-300"
			></div>
</div>
<!--<div style="width: 100%; height: 90px; text-align: center; display: inline-block;">
	<div style="width: 49%; height:100%; align: center; display: inline-block;">
		your netdata server
		<br/>
		<div data-netdata="netdata.requests"
				data-title="Chart Refreshes/s"
				data-chart-library="gauge"
				data-width="20%"
				data-height="100%"
				data-after="-300"
				data-points="300"
				></div>
		<div data-netdata="netdata.clients"
				data-title="Sockets"
				data-chart-library="gauge"
				data-width="20%"
				data-height="100%"
				data-after="-300"
				data-points="300"
				data-colors="#AA5500"
				></div>
		<div data-netdata="netdata.net"
				data-dimensions="in"
				data-title="Requests Traffic"
				data-chart-library="easypiechart"
				data-width="15%"
				data-height="100%"
				data-after="-300"
				data-points="300"
				></div>
		<div data-netdata="netdata.net"
				data-dimensions="out"
				data-title="Chart Data Traffic"
				data-chart-library="easypiechart"
				data-width="15%"
				data-height="100%"
				data-after="-300"
				data-points="300"
				></div>
	</div>
</div>-->
