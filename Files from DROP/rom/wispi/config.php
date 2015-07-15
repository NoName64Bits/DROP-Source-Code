<?php

require("menu.php");

?>
<pre>
<?php
$filename =$_POST['filename'];
$newdata = $_POST['newdata'];

if ($newdata != "") { $newdata = ereg_replace(13,  "", $newdata);
 $fw = fopen($filename, 'w') or die('Could not open file!');
 $fb = fwrite($fw,stripslashes($newdata)) or die('Could not write to file');
 fclose($fw);
 echo "<br /><font color='red'>Updating " . $filename . "</font><b>";
} ?>

<?php
if(isset($_POST[newSSID])){
exec("hostapd_cli -p /var/run/hostapd-phy0 karma_change_ssid ".$_POST[newSSID]);
echo "Karma SSID changed to \"".$_POST[newSSID]."\" successfully <br /><br />";
}

if(isset($_POST[ssidBW])){
	if(isset($_POST[addSSID])){
		exec("hostapd_cli -p /var/run/hostapd-phy0 karma_add_ssid ".$_POST[ssidBW]);
		echo "Added \"".$_POST[ssidBW]."\" to the list. <br /><br />";
	}
        if(isset($_POST[removeSSID])){
                exec("hostapd_cli -p /var/run/hostapd-phy0 karma_del_ssid ".$_POST[ssidBW]);
                echo "Deleted \"".$_POST[ssidBW]."\" from the list. <br /><br />";
        }

}

if(isset($_POST[macBW])){
	if(isset($_POST[addMAC])){
		exec("hostapd_cli -p /var/run/hostapd-phy0 karma_add_black_mac  ".$_POST[macBW]);
		echo "Added \"".$_POST[macBW]."\" to the list. <br /><br />";
	}
        if(isset($_POST[removeMAC])){
                exec("hostapd_cli -p /var/run/hostapd-phy0 karma_add_white_mac ".$_POST[macBW]);
                echo "Deleted \"".$_POST[macBW]."\" from the list. <br /><br />";
        }

}
?>
<table border="0" width="100%">
<tr><td width="700">

<div id="karma">
<td valign="top" align="left">
Karma configuration.
</tr></td>
<tr><td>
<b>Change Karma SSID</b><br />
<form action='<?php echo $_SERVER[php_self] ?>' method= 'post' >
<input type="text" name="newSSID" size='25' value="New SSID" onFocus="if(this.value == 'New SSID') {this.value = '';}" onBlur="if (this.value == '') {this.value = 'New SSID';}" size="70" style='font-family:courier;  font-weight:bold; background-color:black; color:gray; border-style:dotted;' >
<br><input type='submit' value='Change SSID'>
</form>
</tr></td>
<tr><td>

<b>SSID Black and White listing</b><br>
<?php
$BWMode = exec("hostapd_cli -p /var/run/hostapd-phy0 karma_get_black_white");
$changeLink = "<a href='changeBW.php'>change</a>";
?>
<font color='yellow' size='2'> Currently in <font color='white'><?php echo $BWMode ?></font> mode | <font color='red'><?php echo $changeLink ?></font></font><br>
<form action='<?php echo $_SERVER[php_self] ?>' method= 'post' >
<input type="text" name="ssidBW" size='25' value="SSID" onFocus="if(this.value == 'SSID') {this.value = '';}" onBlur="if (this.value == '') {this.value = 'SSID';}" size="70" style='font-family:courier;  font-weight:bold; background-color:black; color:gray; border-style:dotted;'>
<br><input type='submit' name='addSSID' value='Add to List'><input type='submit' name='removeSSID' value='Remove from List'>
</form>
</tr></td>
<tr><td>

<b>Client Black listing</b><br>
<form action='<?php echo $_SERVER[php_self] ?>' method= 'post' >
<input type="text" name="macBW" size='25' value="MAC" onFocus="if(this.value == 'MAC') {this.value = '';}" onBlur="if (this.value == '') {this.value = 'MAC';}" size="70" style='font-family:courier;  font-weight:bold; background-color:black; color:gray; border-style:dotted;'>
<br><input type='submit' name='addMAC' value='Add to List'><input type='submit' name='removeMAC' value='Remove from List'>
</form>
</td></tr>
<tr><td>
</div>

<div id="wireless">
<?php
$filename = "/etc/config/wireless";
  $fh = fopen($filename, "r") or die("Could not open file!");
  $data = fread($fh, filesize($filename)) or die("Could not read file!");
  fclose($fh);
 echo "<b>Wireless</b>
<form action='$_SERVER[php_self]' method= 'post' >
<textarea name='newdata' cols='80' rows='20' style='background-color:black; color:white; border-style:dashed;'>$data</textarea>
<input type='hidden' name='filename' value='/etc/config/wireless'>
<br><input type='submit' value='Update Wireless'>
</form>";
?>
</td><td valign="top" align="left">
Wireless configuration for non-karma mode. 
</td></tr>
<tr><td>
</div>

<?php
$filename = "/etc/config/network";
  $fh = fopen($filename, "r") or die("Could not open file!");
  $data = fread($fh, filesize($filename)) or die("Could not read file!");
  fclose($fh);
 echo "<b>Network</b>
<form action='$_SERVER[php_self]' method= 'post' >
<textarea name='newdata' cols='80' rows='20' style='background-color:black; color:white; border-style:dashed;'>$data</textarea>
<input type='hidden' name='filename' value='/etc/config/network'>
<br><input type='submit' value='Update Network'>
</form>";
?>
</td><td valign="top" align="left">
LAN Configurations. ipaddr specifies the device IP Address while the gateway specifies the IP address from which Internet access can be obtained. DNS specifies a DNS server necessary for name resolution.
</td></tr>
<tr><td>

<?php
$filename = "/etc/config/dhcp";
  $fh = fopen($filename, "r") or die("Could not open file!");
  $data = fread($fh, filesize($filename)) or die("Could not read file!");
  fclose($fh);
 echo "<b>DHCP</b>
<form action='$_SERVER[php_self]' method= 'post' >
<textarea name='newdata' cols='80' rows='20' style='background-color:black; color:white; border-style:dashed;'>$data</textarea>
<input type='hidden' name='filename' value='/etc/config/dhcp'>
<br><input type='submit' value='Update DHCP'>
</form>";
?>

</td><td valign="top" align="left">
Dynamic Host Configuration Protocol. Gives out IP and DNS information to connecting clients. dhcp_option #3 specifies the IP address of the gateway from which Internet access can be obtained. #6 specifies the DNS servers from which names may be resolved. 
</td></tr>
<tr><td>

<div id="landingpages">
<?php
$filename = "/www/index.php";
  $fh = fopen($filename, "r") or die("Could not open file!");
  $data = fread($fh, filesize($filename)) or die("Could not read file!");
  fclose($fh);
 echo "<a name='spoofhost'><b>Landing Page (phishing)</b>
<form action='$_SERVER[php_self]' method= 'post' >
<textarea name='newdata' cols='80' rows='20' style='background-color:black; color:white; border-style:dashed;'>$data</textarea>
<input type='hidden' name='filename' value='/www/index.php'>
<br><input type='submit' value='Update Landing Page'>
</form>";
?>
</div>

<div id="jobs">
<?php
$filename = "/etc/crontabs/root";
  $fh = fopen($filename, "r") or die("Could not open file!");
  $data = fread($fh, filesize($filename)) or die("Could not read file!");
  fclose($fh);
 echo "<a name='spoofhost'><b>Cronjobs</b>
<form action='$_SERVER[php_self]' method= 'post' >
<textarea name='newdata' cols='80' rows='20' style='background-color:black; color:white; border-style:dashed;'>$data</textarea>
<input type='hidden' name='filename' value='/etc/crontabs/root'>
<br><input type='submit' value='Update Cronjobs'>
</form>";
?>
</div>

</pre>
</body>
</html>