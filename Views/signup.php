<?php
session_start();
require_once(ROOT_PATH .'/Controllers/UserController.php');

$result = new UserController();
$login_now = $result -> checkLogin();
if (isset($_SESSION["login_user"])) {
    header('Location: index.php');
    return;
}

$err = $_SESSION;
$login = isset($_SESSION["login_err"]) ? $_SESSION["login_err"] : null;
unset($_SESSION["login_err"]);
$_SESSION = array();

session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/css/bootstrap.css" type="text/css"/>
    <link rel="stylesheet" href="/css/index.css" type="text/css"/>
    <link rel="stylesheet" href="/css/form.css" type="text/css"/>
    <title>ユーザー登録</title>
</head>
<body style = "background-color :#FAEBD7;">
<?php include("header.php")?>
<div class = "box d-flex justify-content-center">
    <div class = "login_form">
        <h2  class = "d-flex justify-content-center">ユーザー登録</h2>
        <form action="confirm.php" method = "POST">
            <p>
                <label for="name">名前</label>
                <span style="color:red;"><?php
                if (isset($err["err_name"])) {
                    echo $err["err_name"];
                }
                ?></span>
                <br>
                <input type="text" name = "name" class = "form-control input-lg">
            </p>
            <p>
                <label for="email">メールアドレス<br></label>
                <span style="color:red;"><?php
                if (isset($err["err_email"])) {
                    echo $err["err_email"];
                }
                ?></span>
                <br>
                <input type="text" name = "email" class = "form-control input-lg">
            </p>
            <p>
                <label for="restaurant">働いている飲食店<br></label>
                <span style="color:red;"><?php
                if (isset($err["err_restaurant"])) {
                    echo $err["err_restaurant"];
                }
                ?></span>
                <br>
                <input type="text" name = "restaurant" class = "form-control input-lg">
            </p>
            <p>
                <label for="comment">ひとこと<br></label>
                <span style="color:red;"><?php
                if (isset($err["err_comment"])) {
                    echo $err["err_comment"];
                }
                ?></span>
                <br>
                <input type="text" name = "comment" class = "form-control input-lg">
            </p>
            <p>
                <label for="password">パスワード<br></label>
                <span style="color:red;"><?php
                if (isset($err["err_password"])) {
                    echo $err["err_password"];
                }
                ?></span>
                <br>
                <input type="password" name = "password" class = "form-control input-lg">
            </p>
            <p>
                <label for="password">パスワード確認<br></label>
                <span style="color:red;"><?php
                if (isset($err["err_password_conf"])) {
                    echo $err["err_password_conf"];
                }
                ?></span>
                <br>
                <input type="password" name = "password_conf" class = "form-control input-lg">
            </p>
            <p class = "d-flex justify-content-center">
                <input type="submit" name = "send" value = "登録" class = "btn btn-default-v3 btn-outline-warning" style = "width:15%; font-size:1.5rem; color:black;">
            </p>
        </form>
    </div>
</div>
<?php include("footer.html")?>
</body>
</html>