<link rel="stylesheet" href="style/bootstrap.min.css">
<link rel="stylesheet" href="style/bootstrap-theme.min.css">
<script src="style/bootstrap.min.js"></script>

<?php
error_reporting(0);
?>

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
        <li><a href="index.php">Main<span class="sr-only">(current)</span></a></li>
        <li class="active"><a href="config.php">Configuration</a></li>
		<li><a href="advanced.php">Advanced</a></li>
		<li><a href="about.php">About</a></li>
      </ul>
    </div>
  </div>
</nav>

<?php
$filename =$_POST['filename'];
$newdata = $_POST['newdata'];

if ($newdata != "") { $newdata = ereg_replace(13,  "", $newdata);
 $fw = fopen($filename, 'w') or die('Could not open file!');
 $fb = fwrite($fw,stripslashes($newdata)) or die('Could not write to file');
 fclose($fw);
 echo "<br /><font color='red'>Updating " . $filename . "</font><b>";
} ?>

<center>
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

<div class="row">
<div id="Karma">
	<div class="col-sm-6">
		<div class="panel panel-danger">
			<div class="panel-heading">
				<h3 class="panel-title">Karma Configuration</h3>
			</div>
			<div class="panel-body">
				<b>Change Karma SSID</b><br>
				<form action='<?php echo $_SERVER[php_self]?>' method= 'post' >
					<input class="form-control" type="text" name="newSSID" size='25' value="New SSID" onFocus="if(this.value == 'New SSID') {this.value = '';}" onBlur="if (this.value == '') {this.value = 'New SSID';}" size="70" style='font-family:courier;  font-weight:bold; background-color:black; color:gray; border-style:dotted;' >
					<input type='submit' value='Change SSID' class="btn btn-primary">
				</form><br>
				<b>SSID Black and White listing</b><br>
						<?php
							$BWMode = exec("hostapd_cli -p /var/run/hostapd-phy0 karma_get_black_white");
							$changeLink = "<a href='changeBW.php'>change</a>";
						?>
				<font color='black' size='4'>Currently in <font color='red'><?php echo $BWMode ?></font> mode</font><font color="black" size='4'> | </font><font color='red' size='4'><?php echo $changeLink ?></font><br>
				<form action='<?php echo $_SERVER[php_self] ?>' method= 'post' >
					<input class="form-control" type="text" name="ssidBW" size='25' value="SSID" onFocus="if(this.value == 'SSID') {this.value = '';}" onBlur="if (this.value == '') {this.value = 'SSID';}" size="70" style='font-family:courier;  font-weight:bold; background-color:black; color:gray; border-style:dotted;'>
					<input type='submit' name='addSSID' value='Add to List' class="btn btn-success">   <input type='submit' name='removeSSID' value='Remove from List' class="btn btn-danger">
				</form> <br>
				<b>Client Black listing</b><br>
				<form action='<?php echo $_SERVER[php_self] ?>' method= 'post' >
					<input class="form-control" type="text" name="macBW" size='25' value="MAC" onFocus="if(this.value == 'MAC') {this.value = '';}" onBlur="if (this.value == '') {this.value = 'MAC';}" size="70" style='font-family:courier;  font-weight:bold; background-color:black; color:gray; border-style:dotted;'>
					<input type='submit' name='addMAC' value='Add to List' class="btn btn-success">   <input type='submit' name='removeMAC' value='Remove from List' class="btn btn-danger">
				</form>
			</div>
		</div>
	</div>
	</div>
	<div id="wireless">
		<div class="col-sm-6">
			<div class="panel panel-danger">
				<div class="panel-heading">
					<h3 class="panel-title">Spoof Land Page</h3>
				</div>
				<div class="panel-body">
					<?php
					$filename = "/www/index.php";
					echo "<b>/www/index.php</b><br>";
					$fh = fopen($filename, "r") or die("Could not open file!");
					$data = fread($fh, filesize($filename)) or die("Could not read file!");
					fclose($fh);
					echo "<a name='spoofhost'><b>Landing Page (phishing)</b>
					<form action='$_SERVER[php_self]' method= 'post' >
					<textarea class='form-control' name='newdata' cols='80' rows='20' style='background-color:black; color:white; border-style:dashed;'>$data</textarea>
					<input type='hidden' name='filename' value='/www/index.php'>
					<br><input type='submit' value='Update Landing Page' class='btn btn-primary'>
					</form>";
					?>
				</div>
			</div>
		</div>
	</div>
</div>
</center>