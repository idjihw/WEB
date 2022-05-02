<!DOCTYPE html>
<html lang='ko'>
<head>
  <title>상품 주문하기</title>
  <meta charset="utf-8">
  <link rel="stylesheet" href="buyer.css" type="text/css">
</head>

<body>
  <h1>도서 주문 페이지</h1>

  <form action="buyerInfo.php" method="POST" enctype="multipart/form-data" onsubmit="return orderbutton()">

  <p>구매자 아이디 <input id="buyer1" name ="buyer1" type="text" pattern="[a-zA-Z]*" onkeyup="onlyEnglish()"></p>

  <input type="checkbox" id="allcheck" onclick="allbox()">모두 선택
  <table>
    <thead>
        <tr>
            <td>선택</td>
            <td>상품명</td>
            <td>미리보기</td>
            <td>정가</td>
            <td>수량</td>
            <td>합계</td>
        </tr>
        </thead>
      <tbody>
        <?php

          $data_dir = "data/";
          $fp = fopen($data_dir . "booklist.txt", "r") or die("파일 읽기 실패");

          while(!feof($fp)){
            $buffer .= fread($fp, 1000);
          }

          $arr = explode("\n", $buffer);
          makeTable($arr);
          fclose($fp);

          function makeTable($bookList){

            $size = count($bookList)-1;
            for($i = 0; $i < $size; $i++){
            $book_Attribute = explode("|", $bookList[$i]);

            $pname = htmlspecialchars($book_Attribute[0]);
            $price = htmlspecialchars($book_Attribute[1]);
            $amount = htmlspecialchars($book_Attribute[2]);
            $preview = htmlspecialchars($book_Attribute[3]);
            $book_value = htmlspecialchars($book_Attribute[1]) * $amount;

            echo "<tr class='line'>";
            echo "<td><input type='checkbox' name='check[]' class='checkboxes' onclick='checkbook()' value='$i'></td>";
            echo "<td><input type='hidden' name='pname[]' value='" . $pname . "'>" . $pname . "</td>";
            echo "<td><button><a target='_blank' href='" . $preview . "'>미리보기</a></button></td>";
            echo "<td><span class='price' name='price' value='{$price}'>" . $price . "</span></td>";
            echo "<td><input type='number' name='amount[]' class='$amount' value='$amount' max='$amount' min='0'>
                  <input type='button' value='변경' onclick='change(" . $i . ")'></td>";
            echo "<td class='booktotal'><span name='btvalue' class='btvalue'>" . $book_value . "</span></td>";
            echo "</tr>";
            }
          }
          ?>

        </tbody>
        <tfoot>
          <tr>
            <td colspan="5" ><strong>선택한 총 상품 금액</strong></td>
                <td id="total_price"><span id='cost_data'><?php echo htmlspecialchars(0); ?></span></td>
            </tr>
          </tfoot>
        </table>
        <p id='pnumber'>총 <span>0</span>개의 상품 선택</p>

        <input type = 'button' name ='delete' class = 'delete' value ='삭제하기' onclick ='deletebutton()'>
        <input type = 'submit' name ='order' class = 'order' value ='주문하기'>
    <script src="buyer.js"></script>
  </form>
  </body>

</html>
