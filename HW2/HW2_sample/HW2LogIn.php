<?php
$id = $_POST["id"];
$pw = $_POST["pw"];
$rdb = fopen("data/person.txt", "r");
while(!feof($rdb)){
  $loginT = chop(fgets($rdb));
  $loginA = explode("|", $loginT);
  if($loginA[0]===$id){
    if($loginA[1]===$pw){
      if(file_exists("data/".$id."_Sun.txt") or
          file_exists("data/".$id."_Mon.txt") or
          file_exists("data/".$id."_Tue.txt") or
          file_exists("data/".$id."_Wed.txt") or
          file_exists("data/".$id."_Thu.txt") or
          file_exists("data/".$id."_Fri.txt") or
          file_exists("data/".$id."_Sat.txt")){
      echo "<tr>\n";
      echo "<th>Sun</th>\n";
      echo "<th>Mon</th>\n";
      echo "<th>Tue</th>\n";
      echo "<th>Wed</th>\n";
      echo "<th>Thu</th>\n";
      echo "<th>Fri</th>\n";
      echo "<th>Sat</th>\n";
      echo "</tr>\n";
      echo "<tr>\n";
      //로그인성공시 데이터 불러오기
      //일요일데이터
      echo "<td class='droptd' id='Sun'>\n";
      echo "<ul>\n";
      if(file_exists("data/".$id."_Sun.txt")){
        $data = fopen("data/".$id."_Sun.txt","r");
        while(!feof($data)){
          $temp1 = chop(fgets($data));
          $temp2 = explode("|",$temp1);
          if(!empty($temp1)){
            echo "<li id=".$temp2[0].">".$temp2[1]."</li>\n";
          }
        }
        fclose($data);
      }
      echo "</ul>\n";
      echo "</td>\n";
      //월요일데이터
      echo "<td class='droptd' id='Mon'>\n";
      echo "<ul>\n";
      if(file_exists("data/".$id."_Mon.txt")){
        $data = fopen("data/".$id."_Mon.txt","r");
        while(!feof($data)){
          $temp1 = chop(fgets($data));
          $temp2 = explode("|",$temp1);
          if(!empty($temp1)){
            echo "<li id=".$temp2[0].">".$temp2[1]."</li>\n";
          }
        }
        fclose($data);
      }
      echo "</ul>\n";
      echo "</td>\n";
      //화요일데이터
      echo "<td class='droptd' id='Tue'>\n";
      echo "<ul>\n";
      if(file_exists("data/".$id."_Tue.txt")){
        $data = fopen("data/".$id."_Tue.txt","r");
        while(!feof($data)){
          $temp1 = chop(fgets($data));
          $temp2 = explode("|",$temp1);
          if(!empty($temp1)){
            echo "<li id=".$temp2[0].">".$temp2[1]."</li>\n";
          }
        }
        fclose($data);
      }
      echo "</ul>\n";
      echo "</td>\n";
      //수요일데이터
      echo "<td class='droptd' id='Wed'>\n";
      echo "<ul>\n";
      if(file_exists("data/".$id."_Wed.txt")){
        $data = fopen("data/".$id."_Wed.txt","r");
        while(!feof($data)){
          $temp1 = chop(fgets($data));
          $temp2 = explode("|",$temp1);
          if(!empty($temp1)){
            echo "<li id=".$temp2[0].">".$temp2[1]."</li>\n";
          }
        }
        fclose($data);
      }
      echo "</ul>\n";
      echo "</td>\n";
      //목요일데이터
      echo "<td class='droptd' id='Thu'>\n";
      echo "<ul>\n";
      if(file_exists("data/".$id."_Thu.txt")){
        $data = fopen("data/".$id."_Thu.txt","r");
        while(!feof($data)){
          $temp1 = chop(fgets($data));
          $temp2 = explode("|",$temp1);
          if(!empty($temp1)){
            echo "<li id=".$temp2[0].">".$temp2[1]."</li>\n";
          }
        }
        fclose($data);
      }
      echo "</ul>\n";
      echo "</td>\n";
      //금요일데이터
      echo "<td class='droptd' id='Fri'>\n";
      echo "<ul>\n";
      if(file_exists("data/".$id."_Fri.txt")){
        $data = fopen("data/".$id."_Fri.txt","r");
        while(!feof($data)){
          $temp1 = chop(fgets($data));
          $temp2 = explode("|",$temp1);
          if(!empty($temp1)){
            echo "<li id=".$temp2[0].">".$temp2[1]."</li>\n";
          }
        }
        fclose($data);
      }
      echo "</ul>\n";
      echo "</td>\n";
      //토요일데이터
      echo "<td class='droptd' id='Sat'>\n";
      echo "<ul>\n";
      if(file_exists("data/".$id."_Sat.txt")){
        $data = fopen("data/".$id."_Sat.txt","r");
        while(!feof($data)){
          $temp1 = chop(fgets($data));
          $temp2 = explode("|",$temp1);
          if(!empty($temp1)){
            echo "<li id=".$temp2[0].">".$temp2[1]."</li>\n";
          }
        }
        fclose($data);
      }
      echo "</ul>\n";
      echo "</td>\n";
      echo "</tr>\n";
      return;
    } else {
      echo "nothing";
      return;
    }
    }
  }
}
echo "NO";
fclose($rdb);
?>
