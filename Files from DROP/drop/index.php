<link rel="stylesheet" href="style/bootstrap.min.css">
<link rel="stylesheet" href="style/bootstrap-theme.min.css">
<script src="style/bootstrap.min.js"></script>

<title>D.R.O.P. Control Panel</title>
<div class="container">
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="about.php">D.R.O.P.</a>
    </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="active"><a href="index.php">Main<span class="sr-only">(current)</span></a></li>
        <li><a href="config.php">Configuration</a></li>
		<li><a href="advanced.php">Advanced</a></li>
		<li><a href="about.php">About</a></li>
      </ul>
    </div>
  </div>
</nav>
<center>
<div class="row">
<br>
<br>
	<div class="col-sm-6">
	<div class="panel panel-primary">
		<div class="panel-heading">
		<h3 class="panel-title">Status</h3>
			</div>
		<div class="panel-body">
			<?php

$iswlanup = exec("ifconfig wlan0 | grep UP | awk '{print $1}'");
if ($iswlanup == "UP") {
echo "Wireless is currently  <font color=\"yellow\"><b>enabled</b></font>. | <a href=\"wlan.php?stop\"><b>Stop</b></a><br />";
} else { echo "Wireless is currently  <font color=\"red\"><b>disabled</b></font>. | <a href=\"wlan.php?start\"><b>Start</b></a> | <a href=\"config.php#wireless\"><b>Edit</b></a><br />"; }

$iskarmaup = "";
if ( exec("hostapd_cli -p /var/run/hostapd-phy0 karma_get_state | tail -1") == "ENABLED" ){
$iskarmaup = true;
}
if ($iskarmaup != "") {
echo "Karma is currently <font color=\"yellow\"><b>enabled</b></font>. | <a href=\"stopkarma.php\"><b>Stop</b></a><br />";
} else { echo "Karma is currently <font color=\"red\"><b>disabled</b></font>. | <a href=\"startkarma.php\"><b>Start</b></a> | <a href=\"config.php#karma\"><b>Edit</b></a><br />"; }


$autoKarma = ( exec("if grep -q 'hostapd_cli -p /var/run/hostapd-phy0 karma_enable' /etc/rc.local; then echo 'true'; fi") );
if ($autoKarma != ""){
echo "Autostart is currently <font color=\"yellow\"><b>enabled</b></font>. | <a href=\"autoKarmaStop.php\"><b>Stop</b></a><br />";
} else { echo "Autostart is currently <font color=\"red\"><b>disabled</b></font>. | <a href=\"autoKarmaStart.php\"><b>Start</b></a><br />"; }

$cronjobs = ( exec("ps | grep [c]ron"));
if ($cronjobs != ""){
echo "Cron Jobs is currently <font color=\"yellow\"><b>enabled</b></font>. | <a href=\"stopcron.php\"><b>stop</b></a><br />";
} else { echo "Cron Jobs is currently  <font color=\"red\"><b>disabled</b></font>. | <a href=\"startcron.php\"><b>start</b></a> | <a href=\"config.php#jobs\"><b>Edit</b></a><br />"; }

$spoofhost = ( exec("cat /etc/config/firewall | grep '!192.168.1.1'"));
if ($spoofhost != ""){
echo "Spoofhost is currently <font color=\"yellow\"><b>enabled</b></font>. | <a href=\"stopspoof.php\"><b>stop</b></a><br />";
} else { echo "Spoofhost is currently  <font color=\"red\"><b>disabled</b></font>. | <a href=\"startspoof.php\"><b>start</b></a> | <a href=\"config.php#landingpages\"><b>Edit</b></a><br />"; }

$jammer = ( exec("ps | grep [m]dk3"));
if ($jammer != ""){
echo "Jammer is currently <font color=\"yellow\"><b>enabled</b></font>. | <a href=\"jammer.php\"><b>stop</b></a><br />";
} else { echo "Jammer is currently  <font color=\"red\"><b>disabled</b></font>. | <a href=\"jammer.php\"><b>start</b></a><br />"; }

?>

		</div>
	</div></div>
	<div class="col-sm-6">
	<pre>
	
D.R.O.P <--> The Wi-Fi Box

based on OpenWRT 12.09
(Atitude Adjustment - r36088)

			
by Ciobanu Laurentiu aka: #NoName
	</pre>
	</div>
</div>
<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-success">
  <div class="panel-heading">
    <h3 class="panel-title">Karma Assosiation Log</h3>
  </div>
  <div class="panel-body">
    <?php
$ifaces = exec("ifconfig -a | cut -c 1-8 | sort | uniq -u |grep -v 'lo\|wlan0\|eth0'|sed ':a;N;$!ba;s/\\n/|/g'");
$ifaces = str_replace(" ","",$ifaces);
$ifaces = explode("|", $ifaces);

	for ($i = 0; $i < count($ifaces); $i++) {
        if (strpos($ifaces[$i], "mon") === false) {
            echo $ifaces[$i] . ": ";
            $ip = exec("ifconfig $ifaces[$i] | grep 'inet addr:' | cut -d: -f2 |awk '{print $1}'");
            echo $ip . "<br>";
        }
	}
?>
  </div>
</div>
	</div>
</div>
<div class="row">
	<div class="col-sm-12">
	<div class="panel panel-warning">
		<div class="panel-heading">
			<h3 class="panel-title">IfConfig</h3>
		</div>
		<div class="panel-body">
		 <?php
		 echo '<pre>';
		 system('ifconfig');
		 echo '</pre>';
         ?>
		 </div>
	</div>
	</div>
</div>
</center>
</div>