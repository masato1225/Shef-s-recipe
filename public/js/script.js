
$(function() {
    //ボタンを押すとフォーム追加
    $('#add').click(function(){
    var form = '' +
    '<div id = "method_form">' +
      '<li>作り方</li>' +
      '<label for="ingredment">調理材料</label>' +
      '<input type="text" name = "ingredment[]" placeholder = "この工程で使う材料を入力してください">' +
      '<label for="method">調理手順</label>' +
      '<textarea name="method[]" id="" cols="30" rows="5" placeholder = "この工程の調理手順を入力してください"></textarea>' +
      '<?php $i++ ?>'
    '</div>' ;
    $("ol").append(form);
    });

    //ボタンを押すとフォーム削除
    $('#remove').click(function(){
      var contents = $("ol > div").length;
      if (contents < 2) {
        alert("これ以上フォームは消せません");
      } else {
        document.querySelector('ol').lastElementChild.remove();
      }
    }); 
    
    //レシピデータ削除
    $("#delete").click(function(){
          if(confirm("本当に削除しますか？")) {
              location.href = "delete.php";
          } else {
              return false;
          }
    });
});