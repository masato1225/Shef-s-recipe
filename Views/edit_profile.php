<?php
session_start();
require_once(ROOT_PATH .'/Controllers/UserController.php');
$err = [];

if (empty($_POST['name']) || mb_strlen($_POST['name']) > 10) {
    $err['err_name'] = "名前は10文字以下で入力してください";
}
if (empty($_POST["restaurant"]) || mb_strlen($_POST["restaurant"] > 30)) {
    $err['err_restaurant'] = "飲食店名は30文字以下で入力してください";
}
if (empty($_POST["comment"]) || mb_strlen($_POST['comment']) > 50) {
    $err['err_comment'] = "ひとことは50文字以下で入力してください";
}

if (count($err) > 0) {
    // エラーがあった場合は戻す
    $_SESSION["err"] = $err;
    header('Location:./edit_profile_form.php');
    return;
}

$_SESSION["login_user"] = $_POST;

$user = new UserController();
$edit = $user -> update($_SESSION["login_user"]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>プロフィール編集完了</title>
</head>
<body style = "background-color :#FAEBD7;">
<?php include("header.php")?>
<div class = "box  d-flex justify-content-center align-items-center my-5" style = "height:150px;">
    <h2>編集が完了しました。</h2>
</div>
<div class = "box  d-flex justify-content-center">
    <a href="top.php" style = "font-size:1.3rem;">トップへ戻る</a>
</div>
<div style = "height: 150px; background-color: #FFE4B5;" class = "fixed-bottom"></div>
</body>
</html>