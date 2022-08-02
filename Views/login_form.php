<?php
session_start();
if (isset($_SESSION["login_user"])) {
    header('Location: index.php');
}

$err = $_SESSION;
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/css/bootstrap.css" type="text/css"/>
    <link rel="stylesheet" href="/css/index.css" type="text/css"/>
    <link rel="stylesheet" href="/css/form.css" type="text/css"/>
    <title>ログインページ</title>
</head>
<body style = "background-color :#FAEBD7;">
    <?php include("header.php")?>
    <div class = "box d-flex justify-content-center">
        <div class = "login_form">
            <h2 class = "d-flex justify-content-center">ログイン</h2>
            <form action="login.php" method = "POST">
                <div class = "login_form">
                    <span style="color:red;"><?php
                    if (isset($err["email"])) {
                        echo $err["email"];
                    }
                    ?></span>
                    <input type="text" name = "email" class = "form-control input-lg" placeholder = "メールアドレス">
                </div>
                <div class = "login_form">
                    <span style="color:red;"><?php
                    if (isset($err["password"])) {
                        echo $err["password"];
                    }
                    ?></span>
                    <input type="password" name = "password" class = "form-control input-lg" placeholder = "パスワード">
                </div>
                <div class = "d-flex justify-content-center">
                    <input type="submit" name = "send" value = "ログイン" class = "align-middle btn btn-default-v3 btn-outline-warning" style = "font-size:1.5rem; color:black;">
                </div>
            </form>
            <a href="signup.php" class = "d-flex justify-content-center mx-auto my-5" style = "width:20%; font-size:1.3rem;" >新規登録</a>
            <p class = "d-flex justify-content-center" style = "font-size:1.3rem;">パスワードを忘れた場合は<a href="reset_pass_form.php">こちら</a></p>
        </div>
    </div>
    <?php include("footer.html")?>
</body>
</html>