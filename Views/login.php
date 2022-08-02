<?php
session_start();
require_once(ROOT_PATH .'/Controllers/UserController.php');

if (empty($_SESSION["login_user"])) {
    header('Location: login_form.php');
}

$err = [];
if (!$email = filter_input(INPUT_POST, 'email')) {
    $err['email'] = 'メールアドレスは正しくご入力ください。';
}

if (!$password = filter_input(INPUT_POST, 'password')) {
    $err['password'] = 'パスワードは正しくご入力ください。';
}

if (count($err) > 0) {
    // エラーがあった場合は戻す
    $_SESSION = $err;
    header('Location:./login_form.php');
    return;
}

$login = new UserController();
$result = $login -> login($email, $password);
$check = $login -> checkLogin();

if (!$check) {
    $_SESSION["login_err"] = "ユーザーを登録してログインしてください";
    header('Location:./login_form.php');
    return;
}
if (isset($result)) {
    header('Location:./top.php');
}
