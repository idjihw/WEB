var idcheck = RegExp(/^([A-Za-z0-9]){6,15}$/);
var pwcheck = RegExp(/^.*(?=^.{8,15}$)(?=.*\d)(?=.*[a-zA-Z])(?=.*[!@#$%^&+=]).*$/);
$(document).ready(function(){
  //drag,drop 함수
  $.fn.dragF=function(){
    var dragid="";
    var dragid2="";
    $("li").draggable({cursor:"move",revert:true,
      start:function(event,ui){
        dragid=$(this).attr("id");
        dragid2=$(this).attr("id");
      }
    });
    $("li").droppable({
      drop:function(event,ui){
        //event.stopPropagation();
        var dropid=$(this).attr("id");
        var cusid=$("#loginID").text();
        var oldday=$("#"+dragid).closest("td").attr("id");
        var newday=$("#"+dropid).closest("td").attr("id");
        $.post("HW2drag.php",{
          cusid:cusid,
          oldid:dragid,
          oldday:oldday,
          newid:dropid,
          newday:newday
        },
        function(data,status){
          $("#table1").empty();
          $.post("HW2replace.php",{id:cusid},function(data,status){
            $("#table1").append(data);
            $.fn.dragF();
          });
        });
      },
      over:function(event,ui){
        $(".droptd").droppable("disable");
      },
      out:function(event,ui){
        $(".droptd").droppable("enable");
      }
    });
    $(".droptd").droppable({
      drop:function(event,ui){
          var dropid2=$(this).attr("id");
          var cusid2=$("#loginID").text();
          var oldday2=$("#"+dragid2).closest("td").attr("id");
          var newday2=$(this).attr("id");
          $.post("HW2drag2.php",{
            cusid:cusid2,
            oldid:dragid2,
            oldday:oldday2,
            newid:dropid2,
            newday:newday2
          },
          function(data,status){
            $("#table1").empty();
            $.post("HW2replace.php",{id:cusid2},function(data,status){
              $("#table1").append(data);
              $.fn.dragF();
            });
          });
        }
    });
  };
  //join버튼 누를시
$("#Join").click(function(){
  $("#LoginBox").css("display","block");
});
//회원가입
$("#SignIn").click(function(){
  if($("#id").val() == "" || (!idcheck.test($("#id").val()))){
    alert("아이디 또는 패스워드의 입력양식을 체크해주세요.");
    $("#LoginBox").css("display","none");
  } else if($("#pw").val() == "" || (!pwcheck.test($("#pw").val()))){
    alert("아이디 또는 패스워드의 입력양식을 체크해주세요.");
    $("#LoginBox").css("display","none");
  } else {
  var userid=$("#id").val();
  var userpw=$("#pw").val();
  $.post("HW2SignIn.php",{
    id:userid,
    pw:userpw
  },
  function(data,status){
    if(data == "OK"){
      alert("회원가입이 완료되었습니다.");
      $("#LoginBox").css("display","none");
    } else if(data == "NO"){
      alert("아이디가 중복됩니다. 다시 회원 가입해주세요.");
      $("#LoginBox").css("display","none");
    }
  });
  }
});
//로그인
$("#logIn").click(function(){
  if($("#id").val() == "" || (!idcheck.test($("#id").val()))){
    alert("아이디 또는 패스워드의 입력양식을 체크해주세요.");
    $("#LoginBox").css("display","none");
  } else if($("#pw").val() == "" || (!pwcheck.test($("#pw").val()))){
    alert("아이디 또는 패스워드의 입력양식을 체크해주세요.");
    $("#LoginBox").css("display","none");
  } else {
  var userid=$("#id").val();
  var userpw=$("#pw").val();
  $.post("HW2LogIn.php",{
    id:userid,
    pw:userpw
  },
  function(data,status){
    if(data == "NO"){
      alert("로그인실패");
      $("#LoginBox").css("display","none");
    } else if(data == "nothing"){
        alert("저장된 정보가 없습니다.");
        $("#LoginBox").css("display","none");
        $("#loginID").text(userid);
        $("#table1").empty();
        $.post("HW2replace.php",{id:userid},function(data,status){
          $("#table1").append(data);
        });
    } else {
      alert("로그인성공");
      $("#LoginBox").css("display","none");
      $("#loginID").text(userid);
      $("#table1").empty();
      $("#table1").append(data);
      //드래그기능추가예정
      $.fn.dragF();
    }
  });
  }
});
//할일추가
$("#Add").click(function(){
  if($("#loginID").text()==""){
    alert("추가하기 위해 로그인 해주세요.");
  } else {
    $("#AddBox").css("display","block");
  }
});
$("#Save").click(function(){
  var cusid=$("#loginID").text();
  var day=$("#day").val();
  var title=$("#title").val();
  var description=$("#description").val();
  $.post("HW2Save.php",{
    cusid:cusid,
    day:day,
    title:title,
    description:description
  },
  function(data,status){
    if(data == "OK"){
      alert("저장되었습니다.");
      $("#AddBox").css("display","none");
      $("#table1").empty();
      $.post("HW2replace.php",{id:cusid},function(data,status){
        $("#table1").append(data);
        //드래그기능추가예정
        $.fn.dragF();
      });
    } else if(data == "NO"){
      alert("저장실패");
      $("#AddBox").css("display","none");
    }
  });
});
//cancel버튼 누를시 할일추가창 사라짐
$("#Cancel").click(function(){
  $("#AddBox").css("display","none");
});
//cancel버튼 누를시 상세보기창 사라짐
$("#TCancel").click(function(){
  $("#titleBox").css("display","none");
});
//할일 클릭시 상세보기창 나타남
$(document).on("click","li",function(){
  $("#titleBox").css("display","block");
  $("#hiddenid").text($(this).attr("id"));
  $("#hiddenid").hide();
  $("#hiddenday").text($(this).closest("td").attr("id"));
  $("#hiddenday").hide();
  var cusid=$("#loginID").text();
  var day=$(this).closest("td").attr("id");
  var title=$(this).text();
  $.post("HW2search.php",{
    cusid:cusid,
    day:day,
    title:title
  },
  function(data,status){
    if(status == "success"){
    $("#Tday").val(day);
    $("#Tday").attr("disabled",true);
    $("#Ttitle").val(title);
    $("#Ttitle").attr("disabled",true);
    $("#Tdescription").val(data);
    $("#Tdescription").attr("disabled",true);
    $("#Edit").removeAttr("disabled");
    $("#Delete").removeAttr("disabled");
    $("#Submit").attr("disabled",true);
    }
  });
});
//Edit버튼 클릭시
$("#Edit").click(function(){
  $("#Tday").removeAttr("disabled");
  $("#Ttitle").removeAttr("disabled");
  $("#Tdescription").removeAttr("disabled");
  $("#Submit").removeAttr("disabled");
  $("#Edit").attr("disabled",true);
  $("#Delete").attr("disabled",true);
});
//Submit버튼 클릭시
$("#Submit").click(function(){
  var tagid=$("#hiddenid").text();
  var tagday=$("#hiddenday").text();
  var cusid=$("#loginID").text();
  var day=$("#Tday").val();
  var title=$("#Ttitle").val();
  var description=$("#Tdescription").val();
  $.post("HW2submit.php",{
    tagid:tagid,
    tagday:tagday,
    cusid:cusid,
    day:day,
    title:title,
    description:description
  },
  function(data,status){
    alert("수정되었습니다.");
    $("#titleBox").css("display","none");
    $("#table1").empty();
    $.post("HW2replace.php",{id:cusid},function(data,status){
      $("#table1").append(data);
      //드래그기능추가예정
      $.fn.dragF();
    });
  });
});
//delete버튼 클릭시
$("#Delete").click(function(){
  var tagid=$("#hiddenid").text();
  var tagday=$("#hiddenday").text();
  var cusid=$("#loginID").text();
  $.post("HW2delete.php",{
    tagid:tagid,
    tagday:tagday,
    cusid:cusid
  },
  function(data,status){
    alert("삭제되었습니다.");
    $("#titleBox").css("display","none");
    $("#table1").empty();
    $.post("HW2replace.php",{id:cusid},function(data,status){
      $("#table1").append(data);
      //드래그기능추가예정
      $.fn.dragF();
    });
  });
});
//Logout버튼 클릭시
$("#Logout").click(function(){
  if($("#loginID").text()==""){
    alert("로그인하지 않은 상태입니다.");
  } else{
  alert("로그아웃이 되었습니다.");
  $("#loginID").text("");
  $("#table1").empty();
  $.post("HW2replace.php",{id:""},function(data,status){
    $("#table1").append(data);
  });
  }
});

});
