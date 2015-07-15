<?php

require("menu.php");

?>
<table border="0" width="100%"><tr><td align="left" valign="top" width="700">
<?php

if(isset($_POST['clearcache']) && $_POST['clearcache'] == "1") {
exec("echo '' > /tmp/karma.log");
exec("echo '' > /tmp/stadump");
echo "<font color='yellow'><b>Karma log has been cleaned</b></font><br />";
}

if(isset($_POST['reboot']) && $_POST['reboot'] == "1") {
exec("reboot");
}

?>
  <pre>
<?php

if(isset($_POST['route']) && $_POST['route'] != "") {
exec($_POST['route'], $routeoutput); 
echo "<br /><font color='yellow'>Executing " . $_POST['route'] . "</font><br /><br /><font color='red'><b>";
foreach($routeoutput as $routeoutputline) { echo ("$routeoutputline\n"); }
echo "</b></font><br />"; }

if(isset($_POST['zcommand']) && $_POST['zcommand'] != "") {
$zcommand = $_POST['zcommand'];

$keyarr=explode("\n",$zcommand);
foreach($keyarr as $key=>$value)
{
  $value=trim($value);
  if (!empty($value)) {
      echo "\n<font color='red'>Executing: $value</font>\n";
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
<b><u>Kernel IP Routing Table</u></b>
<?php $cmd = "route | grep -v 'Kernel IP routing table'";
exec("$cmd 2>&1", $output);
foreach($output as $outputline) {echo ("$outputline\n");}?>

<form action='<?php echo $_SERVER[php_self] ?>' method= 'post' >
<input type="text" name="route" value="route " size="70" style='font-family:courier; font-weight:bold; background-color:black; color:gray; border-style:dotted;'> 
<input type='submit' value='Update Routing Table'> <small><font color="gray">Example: <i>route add default gw 192.168.1.42 br-lan</i> <br /></font></small></form><b><u>Command</u></b>
<form action='<?php echo $_SERVER[php_self] ?>' method= 'post' ><textarea cols="80" rows="1" name="zcommand" style='font-family:courier; font-weight:bold; background-color:black; color:gray; border-style:dotted;'></textarea>
<input type='submit' value='Execute Commands'> <small><font color="gray">Will execute one command per line</font></small></form>

</pre>
</td><td valign="top" align="left" width="*">
<pre>

<form method="post" action="<?php echo $_SERVER[php_self]?>"><input type="hidden" name="clearcache" value="1"><input type="submit" value="Clean Karma log" onClick="return confirm('clean karma log. r u sure')"></form><form method="post" action="<?php echo $_SERVER[php_self]?>"><input type="hidden" name="reboot" value="1"><input type="submit" value="Reboot" onClick="return confirm('Are you sure you want to reboot?')"></form>

</pre>
</td></tr>
</body>
</html>