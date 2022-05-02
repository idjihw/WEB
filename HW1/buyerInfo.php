<?php

$data_dir = "data/";
$buyer1 = $_POST['buyer1'];
$buyer_file = fopen($data_dir . "{$buyer1}.txt", "a+") or die("파일 열기 실패했쪄");
$need_update = fopen($data_dir . "booklist.txt", "r") or die("파일 읽기 실패했쪄");


if(count($_POST['check']) == 0)
  echo "저장에 실패했습니다";

for($i = 0; $i < count($_POST['check']); $i++){
  $check_arr[] = $_POST['check'][$i];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  for($i = 0; $i < count($_POST["pname"]); $i++){
  $pname[] = test_input($_POST["pname"][$i]);
  $amount[] = test_input($_POST["amount"][$i]);
  }
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

for($i = 0; $i <count($_POST['check']); $i++){
  fwrite($buyer_file, $pname[$check_arr[$i]] . "|" . $amount[$check_arr[$i]] . "\r\n");
}

while(!feof($need_update)){
  $buffer .= fread($need_update, 1000);
}

$arr = explode("\n", $buffer);
$save = array();

fclose($need_update);
$updating = fopen($data_dir . "booklist.txt", "w") or die("파일 열기 실패했쪄");

$flag = 0;

for($i = 0; $i < count($arr)-1; $i++){
  $tosave = explode("|", $arr[$i]);

  for($j=0; $j < count($check_arr); $j++){

  if($tosave[0] === $pname[$check_arr[$j]]){
    $tosave[2] -= $amount[$check_arr[$j]];
    $save[] = $tosave[0] . "|" . $tosave[1] . "|" . $tosave[2] . "|" . $tosave[3];
    $flag = 0;
    break;
  }
  else if($flag == count($check_arr)-1){
    $save[] = $tosave[0] . "|" . $tosave[1] . "|" . $tosave[2] . "|" . $tosave[3];
    $flag = 0;
    break;
  }
  ++$flag;

}
  fwrite($updating, $save[$i] . "\n");
}

echo "저장되었습니다!";
fclose($updating);




 ?>
