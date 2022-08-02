<?php
session_start();
require_once(ROOT_PATH .'/Controllers/UserController.php');

//入力内容を持たないアクセスやURLからのアクセスは入力画面へ遷移
if (!isset($_POST)) {
    header('Location:signup.php');
    exit();
}

$data = $_POST;

$user = new UserController();
$user->register($data);

session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/css/bootstrap.css" type="text/css"/>
    <link rel="stylesheet" href="/css/index.css" type="text/css"/>
    <title>登録完了</title>
</head>
<body style = "background-color :#FAEBD7;">
<?php include("header.php")?>
<div class = "box">
    <div id = "usercomp" class = "d-flex justify-content-center">
        <p class = "text-center">ユーザー登録が完了しました。</p>
    </div>
    <div id = "loginguide" class = "d-flex justify-content-center">
        <a href="login_form.php">＞　　ログイン画面へ</a>
    </div>
</div>
<?php include("footer.html")?>
</body>
</html>