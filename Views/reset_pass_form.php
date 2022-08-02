<?php
session_start();

$err = $_SESSION;
session_destroy();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/css/bootstrap.css" type="text/css"/>
    <link rel="stylesheet" href="/css/index.css" type="text/css"/>
    <link rel="stylesheet" href="/css/form.css" type="text/css"/>
    <title>パスワードリセット</title>
</head>
<body style = "background-color :#FAEBD7;">
    <?php include("header.php")?>
    <div class = "box d-flex justify-content-center">
        <div class = "login_form">
            <h3 class = "d-flex justify-content-center">パスワードをリセット</h3>
            <p class = "d-flex justify-content-center">メールアドレスと新しいパスワードを入力してください</p>
            <form action="reset_pass.php" method = "POST">
                <div id = "reset_form">
                    <input type="text" name = "email" placeholder = "メールアドレス" class = "form-control input-lg">
                    <span style="color:red;"><?php
                    if (isset($err["err_email"])) {
                        echo $err["err_email"];
                    } else if (isset($_SESSION["email"])) {
                        echo $_SESSION["email"];
                    }
                    ?></span>
                </div>
                <div id = 'reset_form'>
                    <input type="password" name = "password" placeholder = "パスワード" class = "form-control input-lg">
                    <span style="color:red;"><?php
                    if (isset($err["err_password"])) {
                        echo $err["err_password"];
                    }
                    ?></span>
                </div>
                <div id = "reset_form">
                    <input type="password" name = "password_conf" placeholder = "パスワード確認" class = "form-control input-lg">
                    <span style="color:red;"><?php
                    if (isset($err["err_password_conf"])) {
                        echo $err["err_password_conf"];
                    }
                    ?></span>
                </div>
                <input type="submit" name = "send" value = "送信" class = "d-flex justify-content-center mx-auto my-5 btn btn-default-v3 btn-outline-warning" style = "width:20%; font-size:1.3rem; color:black;">
                <a href="login_form.php" class = "d-flex justify-content-center" style= "color:black;">ログイン画面に戻る</a>
            </form>
        </div>
    </div>
    <?php include("footer.html")?>
</body>
</html>