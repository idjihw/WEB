<?php
$id = $_POST["id"];
$pw = $_POST["pw"];

if(file_exists("data/person.txt")){
  $rdb = fopen("data/person.txt","r");
  while(!feof($rdb)){
    $searchT = chop(fgets($rdb));
    $search = explode("|", $searchT);
    if($search[0]===$id){
        echo "NO";
        return;
    }
  }
  fclose($rdb);
}

$wdb = fopen("data/person.txt","a");
fwrite($wdb,"$id|$pw\n");
fclose($wdb);
echo "OK";
?>
