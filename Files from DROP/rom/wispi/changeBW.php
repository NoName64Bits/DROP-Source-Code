<?php

if(exec ("hostapd_cli -p /var/run/hostapd-phy0 karma_get_black_white") == "BLACK"){
exec ("hostapd_cli -p /var/run/hostapd-phy0 karma_white");
}else{ exec ("hostapd_cli -p /var/run/hostapd-phy0 karma_black"); }
?>
<html><head>
<meta http-equiv="refresh" content="1; url=config.php">
</head><body bgcolor="black" text="white"><pre>
<?php
echo "Spidey go";
?>
</pre></head></body>
