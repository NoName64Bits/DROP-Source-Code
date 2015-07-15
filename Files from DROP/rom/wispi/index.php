<?php

require("menu.php");

?>

<script type="text/javascript" src="includes/ajax.js"> </script>
<script type="text/javascript" src="includes/logtail.js"> </script>

<pre>
<b><u>Status</u></b>
<table border="0" width="100%"><tr><td valign="top" align="left" width="50%">

<?php

$iswlanup = exec("ifconfig wlan0 | grep UP | awk '{print $1}'");
if ($iswlanup == "UP") {
echo "Wireless is currently  <font color=\"yellow\"><b>enabled</b></font>. | <a href=\"wlan.php?stop\"><b>Stop</b></a><br />";
} else { echo "Wireless is currently  <font color=\"red\"><b>disabled</b></font>. | <a href=\"wlan.php?start\"><b>Start</b></a> | <a href=\"config.php#wireless\"><b>Edit</b></a><br />"; }

if ( exec("hostapd_cli -p /var/run/hostapd-phy0 karma_get_state | tail -1") == "ENABLED" ){
$iskarmaup = true;
}
if ($iskarmaup != "") {
echo "W_S Karma is currently <font color=\"yellow\"><b>enabled</b></font>. | <a href=\"stopkarma.php\"><b>Stop</b></a><br />";
} else { echo "W_S Karma is currently <font color=\"red\"><b>disabled</b></font>. | <a href=\"startkarma.php\"><b>Start</b></a> | <a href=\"config.php#karma\"><b>Edit</b></a><br />"; }


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



</td><td valign="top" align="right" width="50%">
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
</td>
</tr>
</table>
</pre>

<b><u>Karma association log</u></b>
<table border="0" width="100%"><tr><td align="left" valign="top" width="700">

<script type="text/javascript">
	getLog('start');
</script>

<div class=content>
<center><?php echo $message; ?></center>

<?php
if(isset($_GET[report])){
?>

<?php
        echo "<small><font color='lime'>".$strings["status-reportWarning"]."</font></small><br /><br />";
        $cmd="/wispi/karmaclients.sh";
        exec("$cmd 2>&1", $output);
        foreach($output as $outputline) {
                 echo ("$outputline\n");
         }
?>
</pre>
</div><br /><br />
<?php
}
?>

<div class=contentContent>
<pre>
<div id='log'></div>
</pre>
</div>
</div>



</td><td valign="top" align="left" width="*">
<pre>

<font color="white">
         (
          )
         (</font><font color="orange">
   /\  .-"""-.  /\
  //\\/  <font color="red">,,,</font>  \//\\
  |/\| <font color="red">,;;;;;,</font> |/\|
  //\\\<font color="red">;-"""-;</font>///\\
 //  \/   <font color="red">.</font>   \/  \\
(| ,-_| <font color="red">\ | /</font> |_-, |)
  //`__\.-.-./__`\\
 // /.-(<font color="red">() ()</font>)-.\ \\
(\ |)   '---'   (| /)
 ` (|           |) `
   \)           (/</font><font color="white">wifi_spider</font>

</pre>
</td>
</tr>
</table>

</body>
</html>