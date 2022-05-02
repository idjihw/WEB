<?php
$cusid = $_POST["cusid"];
$day = $_POST["day"];
$title = $_POST["title"];
$description = $_POST["description"];

$wdb = fopen("data/".$cusid."_".$day.".txt", "a");
fwrite($wdb,date("YnjHis",strtotime("+17 hours"))."|".$title."|".$description."\n");
fclose($wdb);
echo "OK";
?>
