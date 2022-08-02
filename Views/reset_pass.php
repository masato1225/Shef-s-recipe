<?php
session_start();
require_once(ROOT_PATH .'/Controllers/UserController.php');

$err = [];
$email = htmlspecialchars($_POST["email"], ENT_QUOTES, "UTF-8");
$password = htmlspecialchars($_POST["password"], ENT_QUOTES, "UTF-8");
$pass_conf = htmlspecialchars($_POST["password_conf"], ENT_QUOTES, "UTF-8");

if (empty($email) || !filter_input(INPUT_POST, 'email')) {
    $err['err_email'] = "メールアドレスは正しく入力してください";
}
if (empty($password) || mb_strlen($password) > 10 || !preg_match('/\A(?=.*?[a-z])(?=.*?\d)[a-z\d]{8,10}+\z/i', $password)) {
    $err['err_password'] = "パスワードは英数字含む8文字以上10文字以下で入力してください";
}
if (empty($pass_conf) || $password !== $pass_conf) {
    $err['err_password_conf'] = "パスワードが一致しておりません";
}

if (count($err) > 0) {
    // エラーがあった場合は戻す
    $_SESSION = $err;
    header('Location:./reset_pass_form.php');
    return;
}

$reset = new UserController();
$result = $reset -> reset($email, $password);
if (isset($_SESSION["email"])) {
    header('Location:./reset_pass_form.php');
    return;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/css/bootstrap.css" type="text/css"/>
    <link rel="stylesheet" href="/css/index.css" type="text/css"/>
    <link rel="stylesheet" href="/css/form.css" type="text/css"/>
    <title>パスワードリセット完了</title>
</head>
<body style = "background-color :#FAEBD7;">
<?php include("header.php")?> 
<div class = "box d-flex justify-content-center align-items-center my-5" style = "height:150px;">
    <h3>リセットが完了しました</h3>
</div>
<div class = "box  d-flex justify-content-center">  
    <a href = "login_form.php" style = "font-size:1.3rem;">ログインページへ</a>
</div>
<div style = "height: 150px; background-color: #FFE4B5;" class = "fixed-bottom"></div>
</body>
</html>