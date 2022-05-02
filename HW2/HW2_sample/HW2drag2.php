<?php
$cusid = $_POST["cusid"];
$oldid = $_POST["oldid"];
$oldday = $_POST["oldday"];
$newid = $_POST["newid"];
$newday = $_POST["newday"];
//drag한 일정 지움
$newtxt=array();
$movetxt=array();
$rdb=fopen("data/".$cusid."_".$oldday.".txt","r");
while(!feof($rdb)){
  $read = chop(fgets($rdb));
  if(strpos($read,$oldid)!==false){
    array_push($movetxt,$read);
  } else {
    array_push($newtxt,$read);
  }
}
fclose($rdb);

unlink("data/".$cusid."_".$oldday.".txt");

if($newtxt[0]!==""){
$wdb=fopen("data/".$cusid."_".$oldday.".txt","a");
for($i=0;$i<count($newtxt);$i++){
  if($newtxt[$i]!==""){
    fwrite($wdb,$newtxt[$i]."\n");
  }
}
fclose($wdb);
}
//drop한 일정앞에 붙임
$temptxt=array();

if(file_exists("data/".$cusid."_".$newday.".txt")){
  $rdb2=fopen("data/".$cusid."_".$newday.".txt","r");
  while(!feof($rdb2)){
    $read2 = chop(fgets($rdb2));
    array_push($temptxt,$read2);
  }
  fclose($rdb2);
}

array_push($temptxt,$movetxt[0]);

unlink("data/".$cusid."_".$newday.".txt");

if($temptxt[0]!==""){
$wdb2=fopen("data/".$cusid."_".$newday.".txt","a");
for($i=0;$i<count($temptxt);$i++){
  if($temptxt[$i]!==""){
    fwrite($wdb2,$temptxt[$i]."\n");
  }
}
fclose($wdb2);
}

 ?>
