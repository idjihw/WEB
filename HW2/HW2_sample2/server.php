<?php
  function test_data($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
  function getSignData(){
    $f = fopen("./data/person.txt","r") or die('유저 정보를 불러오지 못했습니다!');
    $items = array();
    while(!feof($f) && ($line = fgets($f)) != false){
      if(strlen($line) <= 1)
        continue;
      $item = explode("|",$line);
      $items[$item[0]] = str_replace("\n","",$item[1]);
    }
    fclose($f);
    return $items;
  }
  function getSpecificWeekData($weekday,$id){
    if(!file_exists("./data/{$id}_{$weekday}.txt")) {return null;}
    $f = fopen("./data/{$id}_{$weekday}.txt","r");
    $weekSpecificData;
    $index = 0;
    while(!feof($f) && ($line = fgets($f)) != false){
      if(strlen($line) <= 1)
        continue;
      $item = explode("|",$line);
      $item[2] = str_replace(array("\r\n","\r","\n"),"",$item[2]); // remove \r \n
      $weekSpecificData[$index]["id"] = $item[0];
      $weekSpecificData[$index]["title"] = $item[1];
      $weekSpecificData[$index]["desc"] = $item[2];
      $index++;
    }
    fclose($f);
    return $weekSpecificData;
  }
  function getWeekData($id){
    static $WEEK = ["sun","mon","tue","wed","thu","fri","sat"];
    $weekData;
    for($i = 0; $i < 7; $i++){
      $weekday = $WEEK[$i];
      $tmp = getSpecificWeekData($weekday,$id);
      if($tmp != null){
        $weekData[$weekday] = $tmp;
      }
    }
    return json_encode($weekData); // array to json
  }

  function setWeekData($day,$data){
    $id = $_SESSION["id"];
    if(file_exists("./data/{$id}_{$day}.txt")){
      unlink("./data/{$id}_{$day}.txt");
    }
    $f = fopen("./data/{$id}_{$day}.txt","w");

    for($index = 0; $index < count($data); $index++){
      $plan = $data[$index];
      fwrite($f,$plan["id"]."|".$plan["title"]."|".$plan["desc"]."\n");
    }
    fclose($f);
  }

  function addAccount($id,$password){
    $f = fopen("./data/person.txt","a");
    fwrite($f,"{$id}|{$password}\n");
    fclose($f);
  }

  function addPlan($weekday,$putIndex,$data){
    $weekSpecificData = getSpecificWeekData($weekday,$_SESSION['id']);
    $newData = array();
    for($index = 0; $index < $putIndex; $index++){
      $newData[] = $weekSpecificData[$index];
    }
    $newData[] = $data;
    for($index = $putIndex; $index < count($weekSpecificData); $index++){
      $newData[] = $weekSpecificData[$index];
    }

    setWeekData($weekday,$newData);
  }
  function removePlan($weekday,$data){
    $weekSpecificData = getSpecificWeekData($weekday,$_SESSION['id']);
    $newData;
    for($index = 0; $index < count($weekSpecificData); $index++){
      if($weekSpecificData[$index]["id"] != $data["id"])
        $newData[] = $weekSpecificData[$index];
    }
    setWeekData($weekday,$newData);
  }

  // start session
  ini_set('session.save_path', './tmp');
  session_start();

  if($_SERVER["REQUEST_METHOD"] == "POST"){ // if post
    $type = $_POST["type"];
    if(strcmp($type,"update") == 0){ // if update week data
      error_log("UPDATE REQUEST : ".$_SESSION['id']);
      $data = $_POST["data"];
      /*
      setWeekData($_POST["weekday"],$_POST["data"]);*/
      $case = $_POST["case"];
      if(strcmp($case,"drag") == 0) {
        $_SESSION['dragdata'] = $_POST;
      }
      else if(strcmp($case,"drop") == 0) {
        removePlan($_SESSION['dragdata']["weekday"],$_SESSION['dragdata']["data"]);
        addPlan($_POST["weekday"],$_POST["inputIndex"],$_POST["data"]);
        $draggedData = null;
      }
      else if(strcmp($case,"add") == 0) {
        addPlan($_POST["weekday"],$_POST["inputIndex"],$_POST["data"]);
      }
      else if(strcmp($case,"remove") == 0) {
        removePlan($_POST["weekday"],$_POST["data"]);
      }
    }
    else if(strcmp($type,"session") == 0){ // if login by session
      if($_SESSION["id"] != "")
      {
        error_log("SESSION BYPASS : ".$_SESSION["id"]);
      }
      $sID = $_SESSION["id"];
      $sData = getWeekData($_SESSION["id"]);

      echo "[\"{$sID}\",{$sData}]";
    }
    else if(strcmp($type,"logout") == 0){ // if logout : clear session
      if($_SESSION["id"] != ""){
              error_log("LOGOUT SUCCESS : ".$_SESSION["id"]);
      }
      $_SESSION = [];
      setcookie(session_name(), '', time() - 42000);
      session_destroy();
    }
    else{ // else : login or register by id and pw from client
      $id = $_POST["id"];
      $password = $_POST["password"];
      $signData = getSignData();
      if(strcmp($type,"login") == 0){
        if($signData[$id] != null){
            if(strcmp($signData[$id],$password) == 0){
              $_SESSION['id'] = $id;
              error_log("LOGIN SUCCESS : ".$_SESSION['id']);
              echo getWeekData($id);
            }
            else{
              echo -1;
            }
        }
        else{
          echo -1;
        }
      }
      else if(strcmp($type,"register") == 0){
        if($signData[$id] == null)
        {
          addAccount($id,$password);
          echo "회원가입이 완료되었습니다.";
        }
        else{
          echo "아이디가 중복됩니다. 다시 가입해주세요";
        }
      }
    }
  }
?>
