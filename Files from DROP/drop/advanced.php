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
      </button>
      <a class="navbar-brand" href="about.php">D.R.O.P.</a>
    </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li><a href="index.php">Main<span class="sr-only">(current)</span></a></li>
        <li><a href="config.php">Configuration</a></li>
		<li class="active"><a href="advanced.php">Advanced</a></li>
		<li><a href="about.php">About</a></li>
      </ul>
    </div>
  </div>
</nav>

<center>
<?php

if(isset($_POST['clearcache']) && $_POST['clearcache'] == "1") {
exec("echo '' > /tmp/karma.log");
exec("echo '' > /tmp/stadump");
echo "<font color='black' size='4'><b>Karma log has been cleaned</b></font><br />";
}

if(isset($_POST['reboot']) && $_POST['reboot'] == "1") {
exec("reboot");
}
if(isset($_POST['clr']) && $_POST['clr'] == "1") {
exec("echo 3 > /proc/sys/vm/drop_caches");
}

?>
<div class='row'>
<div class="col-sm-8">
<div class="panel panel-success">
	<div class="panel-heading">
		<h3 class="panel-title">Tools</h3>
	</div>
	<div class="panel-body">
  <pre>
<?php

if(isset($_POST['route']) && $_POST['route'] != "") {
exec($_POST['route'], $routeoutput); 
echo "<br /><font color='black' size=''4>Executing " . $_POST['route'] . "</font><br /><br /><font color='red' size='4'><b>";
foreach($routeoutput as $routeoutputline) { echo ("$routeoutputline\n"); }
echo "</b></font><br />"; }

if(isset($_POST['zcommand']) && $_POST['zcommand'] != "") {
$zcommand = $_POST['zcommand'];

$keyarr=explode("\n",$zcommand);
foreach($keyarr as $key=>$value)
{
  $value=trim($value);
  if (!empty($value)) {
      echo "\n<font color='red' size='4'>Executing: $value</font>\n";
      $zoutput = "";
      $zoutputline = "";
      exec ($value, $zoutput);
      foreach($zoutput as $zoutputline) {
      echo ("$zoutputline\n");}
  }
}
echo "<br /><br />";
}

?>
<font size='5'><b>Kernel IP Routing Table</b></font>
<?php $cmd = "route | grep -v 'Kernel IP routing table'";
exec("$cmd 2>&1", $output);
foreach($output as $outputline) {echo ("$outputline\n");}?>

<form action='<?php echo $_SERVER[php_self] ?>' method= 'post' >
<input class="form-control" type="text" name="route" value="route " size="70" style='font-family:courier; font-weight:bold; background-color:black; color:gray; border-style:dotted;'> 
<input class="btn btn-primary" type='submit' value='Update Routing Table'> <small><font color="gray">Example: <i>route add default gw 192.168.1.42 br-lan</i> <br /></font></small></form>
<font size='5'><b>Command</b></font>
<form action='<?php echo $_SERVER[php_self] ?>' method= 'post' ><textarea class="form-control" cols="80" rows="1" name="zcommand" style='font-family:courier; font-weight:bold; background-color:black; color:gray; border-style:dotted;'></textarea>
<input class="btn btn-primary" type='submit' value='Execute Commands'> <small><font color="gray">Will execute one command per line</font></small></form>

</pre>
</div>
</div>
</div>
<div class="col-sm-4">
<pre>

<form method="post" action="<?php echo $_SERVER[php_self]?>">
<input type="hidden" name="clr" value="1">
<input class="btn btn-primary" type="submit" value="Clear RAM" onClick="return confirm('Wipe RAM?')">
</form>
<form method="post" action="<?php echo $_SERVER[php_self]?>">
<input type="hidden" name="clearcache" value="1">
<input class="btn btn-primary" type="submit" value="Clean Karma log" onClick="return confirm('Clean karma log?')">
</form>
<form method="post" action="<?php echo $_SERVER[php_self]?>">
<input type="hidden" name="reboot" value="1">
<input class="btn btn-primary" type="submit" value="Reboot" onClick="return confirm('Reboot?')">
</form>

</pre>
</div>
</td></tr>
</div>
</center>