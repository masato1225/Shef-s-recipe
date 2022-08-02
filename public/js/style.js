(() => {
  //モーダルウィンドウ
  const click = document.getElementById('signin_click');
  const overlay = document.getElementById('overlay');

  click.addEventListener('click', function() {
    overlay.style.display = 'flex';
  })

  window.addEventListener('click', function(e) {
    if (e.target == overlay) {
      overlay.style.display = 'none';
    }
  });


  //ナビスクロール上部に固定
  function FixedAnime() {
  	const headerH = $('#nav').outerHeight(true);
  	const scroll = $(window).scrollTop();
  	if (scroll >= headerH){//headerの高さ以上になったら
  			$('#nav').addClass('motion');//motionというクラス名を付与
  		}else{//それ以外は
  			$('#nav').removeClass('motion');//motionというクラス名を除去
  		}
  }
  // 画面をスクロールをしたら動かしたい場合の記述
  $(window).scroll(function () {
  	FixedAnime();/* スクロール途中からヘッダーを出現させる関数を呼ぶ*/
  });

  // ページが読み込まれたらすぐに動かしたい場合の記述
  $(window).on('load', function () {
  	FixedAnime();/* スクロール途中からヘッダーを出現させる関数を呼ぶ*/
  });

  //スムーススクロール
  $(function(){
    $('a[href^="#"]').click(function(){
      const speed = 500;
      const href= $(this).attr("href");
      const target = $(href == "#" || href == "" ? 'html' : href);
      const position = target.offset().top;
      $("html, body").animate({scrollTop:position}, speed, "swing");
      return false;
    });
  });

// JS
  $(function(){
    $('#submit_btn').on('click', function(){
      if($('#name').val() === '' || $('#name').val().length > 10 ){
        alert('氏名は必須入力です。10文字以内でご入力ください。');
        $('#name').focus();
        return false;
      }
      if($('#kana').val() === '' || $('#kana').val().length > 10 ){
        alert('フリガナは必須入力です。10文字以内でご入力ください。');
        $('#kana').focus();
        return false;
      }
      if(!$('#tel').val().match(/^\d+$/)){
        alert('電話番号は0-9の数字のみご入力ください。');
        $('#tel').focus();
        return false;
      }
      if($('#email').val() === '' || !$('#email').val().match(/^([a-zA-Z0-9])+([a-zA-Z0-9._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9._-]+)+$/)){
        alert('メールアドレスは正しくご入力ください。');
        $('#email').focus();
        return false;
      }
      if($('#body').val() === ''){
        alert('お問い合わせ内容は必須入力です。');
        $('#body').focus();
        return false;
      }
    });
  });


})();
