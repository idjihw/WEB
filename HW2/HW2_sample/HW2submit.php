<?php
$tagid = $_POST["tagid"];
$tagday = $_POST["tagday"];
$cusid = $_POST["cusid"];
$day = $_POST["day"];
$title = $_POST["title"];
$description = $_POST["description"];


$newtxt=array();
$rdb=fopen("data/".$cusid."_".$tagday.".txt","r");
while(!feof($rdb)){
  $read = chop(fgets($rdb));
  if(strpos($read,$tagid)!==false){

  } else{
    array_push($newtxt,$read);
  }
}
fclose($rdb);

unlink("data/".$cusid."_".$tagday.".txt");

if($newtxt[0]!==""){
$wdb=fopen("data/".$cusid."_".$tagday.".txt","a");
for($i=0;$i<count($newtxt);$i++){
  if($newtxt[$i]!==""){
    fwrite($wdb,$newtxt[$i]."\n");
  }
}
fclose($wdb);
}

$wdb2 = fopen("data/".$cusid."_".$day.".txt", "a");
fwrite($wdb2,date("YnjHis",strtotime("+17 hours"))."|".$title."|".$description."\n");
fclose($wdb2);
echo "OK";
 ?>
