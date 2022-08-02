<?php
session_start();
if (empty($_SESSION["login_user"])) {
    header('Location: login_form.php');
}
require_once(ROOT_PATH .'/Controllers/UserController.php');
$err = [];

/***レシピ紹介部分バリデーション */
$post = filter_input_array(INPUT_POST, $_POST);

$post_repalce = preg_replace('/\A[\p{C}\p{Z}]++|[\p{C}\p{Z}]++\z/u', '', $post);

$_SESSION["recipe"] = [];
$_SESSION["recipe"]["name"] = htmlspecialchars($post_repalce["name"], ENT_QUOTES, "UTF-8");
$_SESSION["recipe"]["intro"] = nl2br(htmlspecialchars($post_repalce["intro"], ENT_QUOTES, "UTF-8"));
$_SESSION["recipe"]["time"] = htmlspecialchars($post_repalce["time"], ENT_QUOTES, "UTF-8");
$_SESSION["recipe"]["cost"] = htmlspecialchars($post_repalce["cost"], ENT_QUOTES, "UTF-8");
$_SESSION["recipe"]["serving"] = htmlspecialchars($post_repalce["serving"], ENT_QUOTES, "UTF-8");
$_SESSION["send"] = htmlspecialchars($_POST["send"], ENT_QUOTES, "UTF-8");


if (empty($_SESSION["recipe"]["name"])) {
    $err["name"] = "タイトルを入力してください";
}
if (empty($_SESSION["recipe"]["intro"]) || mb_strlen($_SESSION["recipe"]["intro"]) > 100 || mb_strlen($_SESSION["recipe"]["intro"]) < 20) {
    $err["intro"] = "ひとこと紹介は20文字以上100文字未満です";
}
if (empty($_SESSION["recipe"]["time"]) || !preg_match('/^[0-9]+$/', $_SESSION["recipe"]["time"])) {
    $err["time"] = "半角数字で入力してください<br>";
}
if (empty($_SESSION["recipe"]["cost"]) || !preg_match('/^[0-9]+$/', $_SESSION["recipe"]["cost"])) {
    $err["cost"] = "半角数字で入力してください<br>";
}
if (empty($_SESSION["recipe"]["serving"]) || !preg_match('/^[0-9]+$/', $_SESSION["recipe"]["serving"])) {
    $err["serving"] = "半角数字で入力してください<br>";
}

/***調理方法部分バリデーション */
$count = count($_POST["ingredment"]);
for ($i = 0; $i < $count; $i++) {
    $_SESSION["ingredment"][$i] = htmlspecialchars($_POST["ingredment"][$i], ENT_QUOTES, "UTF-8");
    $_SESSION["method"][$i] = htmlspecialchars($_POST["method"][$i], ENT_QUOTES, "UTF-8");
}

foreach ($_POST['ingredment'] as $ing) {
    if (empty($ing)) {
        $err["ingredment"] = "※材料が全て入力されていません。";
    }
}
foreach ($_POST['method'] as $method) {
    if (empty($method)) {
        $err["method"] = "※調理手順が全て入力されていません。";
    }
}

/***レシピ写真部分バリデーション */
//ファイル関連の取得
$file = $_FILES["img"];
$filename = basename($file["name"]);
$tmp_path = $file["tmp_name"];
$file_err = $file["error"];
$filesize = $file["size"];
$upload_dir = "image/";
$save_filename = date("YmdHis") . $filename;
$save_path = $upload_dir . $save_filename;
//ファイルのバリデーション

//ファイルサイズが1MB未満か
if ($filesize > 1048576 || $file_err == 2) {
    $err["imgsize"]= "ファイルサイズは1MB未満にしてください<br>";
}
//拡張子は画像形式か
$allow_ext = array("jpg", "jpeg", "png");
$file_ext = pathinfo($filename, PATHINFO_EXTENSION);

if (!in_array(strtolower($file_ext), $allow_ext)) {
    $err["imgtype"] = "画像ファイルを添付してください<br>";
}

//ファイルはあるかどうか

if (is_uploaded_file($tmp_path)) {
    $result = move_uploaded_file($tmp_path, $save_path);
} else {
    $err["imgpath"] = "ファイルが選択されていません<br>";
}

/***エラーのある場合new_recipe_form.phpに戻す**/

if (!empty($err)) {
        $_SESSION["err"] = $err;
        header('Location: new_recipe_form.php');
        exit();
}

/***エラーが無い場合はデータベースに保存**/

$recipe = new UserController();
//Recipeテーブルに登録
$new_recipe = $recipe -> recipe($_SESSION["login_user"]["id"], $_SESSION["recipe"]);
$last_id = $recipe -> lastid();

//Processesテーブルに登録
$count = count($_SESSION["ingredment"]);
for ($i = 0; $i < $count; $i++) {
    $process = $recipe -> process($_SESSION["login_user"]["id"], $last_id["id"], $_SESSION["ingredment"][$i], $_SESSION["method"][$i]);
}

//imagesテーブルに登録
$image = $recipe -> savefile($_SESSION["login_user"]["id"], $last_id["id"], $filename, $save_path);
unset($_SESSION["recipe"]);
unset($_SESSION["ingredment"]);
unset($_SESSION["method"]);
unset($_SESSION["send"]);
unset($_SESSION["img"]);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/css/bootstrap.css" type="text/css"/>
    <link rel="stylesheet" href="/css/index.css" type="text/css"/>
    <link rel="stylesheet" href="/css/form.css" type="text/css"/>
    <title>新規レシピ確認</title>
</head>
<body style = "background-color :#FAEBD7;">
<?php include("header.php")?>
<div class = "box">
    <div id = "usercomp" class = "d-flex justify-content-center">
        <p class = "text-center">レシピ投稿が完了しました。</p>
    </div>
    <div id = "loginguide" class = "d-flex justify-content-center">
        <a href="top.php">＞　　トップへ戻る</a>
    </div>
</div>
<?php include("footer.html")?>
<script src="../js/jquery-3.6.0.min.js" type="text/javascript"></script>
<script src="../js/script.js" type="text/javascript"></script>
</body>
<html>
