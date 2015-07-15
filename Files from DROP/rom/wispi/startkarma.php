<?php
exec ("echo '' > /tmp/karma.log");
exec ("/wispi/startkarma.sh");
?>
<html><head>
<meta http-equiv="refresh" content="2; url=../wait.php">
</head><body bgcolor="black" text="white"><pre>
<?php
echo "Spidey Activated";
?>
</pre></head></body>
