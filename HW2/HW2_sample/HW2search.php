<?php
$cusid = $_POST["cusid"];
$day = $_POST["day"];
$title = $_POST["title"];

$rdb=fopen("data/".$cusid."_".$day.".txt","r");
while(!feof($rdb)){
  $temp=chop(fgets($rdb));
  $des=explode("|",$temp);
  if($title===$des[1]){
    echo $des[2];
    return;
  }
}
fclose($rdb);
 ?>
