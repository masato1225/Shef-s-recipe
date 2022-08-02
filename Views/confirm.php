<?php

session_start();
$post = filter_input_array(INPUT_POST, $_POST);
$_SESSION["name"] = htmlspecialchars($post["name"], ENT_QUOTES, "UTF-8");
$_SESSION["email"] = htmlspecialchars($post["email"], ENT_QUOTES, "UTF-8");
$_SESSION["restaurant"] = htmlspecialchars($post["restaurant"], ENT_QUOTES, "UTF-8");
$_SESSION["comment"] = htmlspecialchars($post["comment"], ENT_QUOTES, "UTF-8");
$_SESSION["password"] = htmlspecialchars($post["password"], ENT_QUOTES, "UTF-8");
$_SESSION["password_conf"] = htmlspecialchars($post["password_conf"], ENT_QUOTES, "UTF-8");

$error = [];

if (empty($_SESSION['name']) || mb_strlen($_SESSION['name']) > 10) {
    $error['err_name'] = "名前は10文字以下で入力してください";
}
if (empty($_SESSION["email"]) || !filter_var($_SESSION["email"], FILTER_VALIDATE_EMAIL)) {
    $error['err_email'] = "メールアドレスは正しく入力してください";
}
if (empty($_SESSION["restaurant"]) || mb_strlen($_SESSION["restaurant"]) > 30) {
    $error['err_restaurant'] = "飲食店名は30文字以下で入力してください";
}
if (empty($_SESSION["comment"]) || mb_strlen($_SESSION['comment']) > 50) {
    $error['err_comment'] = "ひとことは50文字以下で入力してください";
}
if (empty($_SESSION["password"]) || mb_strlen($_SESSION['password']) > 10 || !preg_match('/\A(?=.*?[a-z])(?=.*?\d)[a-z\d]{8,10}+\z/i', $_SESSION["password"])) {
    $error['err_password'] = "パスワードは英数字含む8文字以上10文字以下で入力してください";
}
if (empty($_SESSION["password_conf"]) || $_SESSION["password"] !== $_SESSION["password_conf"]) {
    $error['err_password_conf'] = "パスワードが致しておりません。";
}

if (!empty($error)) {
    $_SESSION = $error;
    header('Location: signup.php');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/css/bootstrap.css" type="text/css"/>
    <link rel="stylesheet" href="/css/index.css" type="text/css"/>
    <link rel="stylesheet" href="/css/form.css" type="text/css"/>
    <title>ユーザー登録確認</title>
</head>
<body style = "background-color :#FAEBD7;">
<?php include("header.php")?>
<div class = "box">
    <div class="exp2 d-flex justify-content-center my-3" style = "font-size:1.4rem;">
                <p class = "text-center">下記の内容をご確認の上送信ボタンを押してください。<br>
                内容を訂正する場合は戻るを押してください。</p>
    </div>
    <form action="complete.php" method="POST">
            <div id = "signup">
                <p id="ques"><span>名前</span>：<?php echo $_SESSION["name"];?></p>
                <input type="hidden" name="name" value="<?php echo $_SESSION["name"]; ?>">
            </div>

            <div id = "signup">
                <p id="ques"><span>メールアドレス</span>：<?php echo $_SESSION["email"];?></p>
                <input type="hidden" name="email" value="<?php echo $_SESSION["email"]; ?>">
            </div>

            <div id = "signup">
                <p id="ques"><span>働いている飲食店</span>：<?php echo $_SESSION["restaurant"];?></p>
                <input type="hidden" name="restaurant" value="<?php echo $_SESSION["restaurant"]; ?>">
            </div>

            <div id = "signup">
                <p id="ques"><span>ひとこと</span>：<?php echo $_SESSION["comment"];?></p>
                <input type="hidden" name="comment" value="<?php echo $_SESSION["comment"]; ?>">
            </div>

            <input type="hidden" name = "password"  value="<?php echo $_SESSION["password"];?>">
            <input type="hidden" name = "role"  value= 0 >

            <div class="btn d-flex justify-content-around">
                <input type="submit" value="送信">
                <input type="button" onclick="history.back()" value="戻る">
            </div>
    </form>
</div>
<?php include("footer.html")?>
</body>
</html>