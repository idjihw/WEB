
function onlyEnglish(){
  let test = document.getElementById('buyer1');
  test.value = test.value.replace(/[^A-Za-z]/g,"");
}
//영어 외의 다른게 입력되면 빈칸으로 교체됩니다.

function checkbook(){

   var book_arr = document.getElementsByClassName("checkboxes");
   var total = 0;
   var flag = 0;
   var flagnum = 0;

   for(var i = 0; i < book_arr.length; i++){
     if(book_arr[i].checked == true){
       flagnum++;
     }
     else{
       flag = 1;
     }
   }

   if(flag == 0){
     var allchecked = document.getElementById("allcheck");
     allchecked.checked = true;
   }
   else{
     var allchecked = document.getElementById("allcheck");
     allchecked.checked = false;
   }

   checkboxcheck();
}

function allbox(){
  var allchecked = document.getElementById('allcheck');
  var book_arr = document.getElementsByClassName("checkboxes");
  var book_cost = document.getElementsByClassName("btvalue");
  var total = 0;

  if(allchecked.checked == true){
    for(var i =0; i<book_cost.length; i++){
      total += parseInt(book_cost[i].textContent);
      var node = document.createElement('span');
      var textnode = document.createTextNode(total);
      node.appendChild(textnode);
      var final = document.getElementById('cost_data');
      final.removeChild(final.childNodes[0]);
      final.appendChild(node);
      book_arr[i].checked = true;


    }
  }
  else{
    for(var i =0; i<book_cost.length; i++){
      book_arr[i].checked = false;
      var node = document.createElement('span');
      var textnode = document.createTextNode('0');
      node.appendChild(textnode);
      var final = document.getElementById('cost_data');
      final.removeChild(final.childNodes[0]);
      final.appendChild(node);

    }
  }
  checkboxcheck();
}

function change(num){
  var eleamount = document.getElementsByName('amount[]')[num];

  if(eleamount.value == eleamount.getAttribute('class')){
    alert('수량이 변경되지 않았지롱');
    return;
  }

  var book_arr = document.getElementsByClassName('checkboxes');
  var item_value = document.createElement('span');
  var tt = document.getElementsByName('price')[num].textContent * document.getElementsByName('amount[]')[num].value;

  item_value.setAttribute('class', 'btvalue');
  item_value.setAttribute('name', 'btvalue');
  item_value.appendChild(document.createTextNode(tt));

  document.getElementsByClassName('booktotal')[num].replaceChild(item_value, document.getElementsByName('btvalue')[num]);
  eleamount.setAttribute('class', eleamount.value);

  book_arr[num].checked = true;
  checkboxcheck();
}

function checkboxcheck(){
  var book_arr = document.getElementsByClassName("checkboxes");
  var book_cost = document.getElementsByClassName("btvalue");

  var flagnum = 0;
  var total = 0;

  for(var i = 0; i < book_arr.length; i++){
    if(book_arr[i].checked == true){
      flagnum++;
      total += parseInt(book_cost[i].textContent);

      var node = document.createElement('span');
      var textnode = document.createTextNode(total);
      node.appendChild(textnode);
      var final = document.getElementById('cost_data');
      final.removeChild(final.childNodes[0]);
      final.appendChild(node);
    }
  }
  if(flagnum == 0){
    var node = document.createElement('span');
    var textnode = document.createTextNode(total);
    node.appendChild(textnode);
    var final = document.getElementById('cost_data');
    final.removeChild(final.childNodes[0]);
    final.appendChild(node);
  }

  if(flagnum == book_arr.length){
    var allchecked = document.getElementById('allcheck');
    allchecked.checked = true;
  }

  var node1 = document.createElement('span');
  var textnode1 = document.createTextNode(flagnum);
  node1.appendChild(textnode1);
  var pn = document.getElementById('pnumber').childNodes[1];
  var parent = pn.parentNode;
  parent.replaceChild(node1, pn);
}

function deletebutton(){
  var book_arr = document.getElementsByClassName('checkboxes');
  var tline = document.getElementsByClassName('line');
  var i = 0;

    while(true){
      if(i > tline.length-1) break;

      if(book_arr[i].checked == true){
        var parent = tline[i].parentNode;
        parent.removeChild(parent.childNodes[i+1]);

        var book_arr = document.getElementsByClassName('checkboxes');
        var tline = document.getElementsByClassName('line');
        i = -1;
      }
      i++;
    }
  checkboxcheck();

}

function orderbutton(){
  var getId = document.getElementById('buyer1').value;
  var book_arr = document.getElementsByClassName('checkboxes');
  var flag = 0;

  for(var i =0; i < book_arr.length; i++){
    if(book_arr[i].checked == true) flag = 1;
  }
  var book_arr = document.getElementsByClassName('checkboxes');
  if(!getId){
    if(flag == 0){
      alert("아이디는 영문자로 입력해주고, 체크박스도 선택해줘");
      return false;
    }
    alert("아이디를 영문자로 입력해줭");
    return false;
  }
  else{
    if(flag == 0){
      alert("체크박스를 선택해주길바라");
      return false;
    }
  }
}
