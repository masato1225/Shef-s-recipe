<?php

session_start();
if (empty($_SESSION["login_user"])) {
    header('Location: login_form.php');
}
require_once(ROOT_PATH .'/Controllers/UserController.php');
$recipe = new UserController();

//$image = $recipe -> image($_SESSION["img"]);
$file = $_SESSION["img"];
var_dump($file);
$filename = $file['name'];
 
//（4）$_FILESから保存先を取得して、images_after（ローカルフォルダ）に移す
//move_uploaded_file（第1引数：ファイル名,第2引数：格納後のディレクトリ/ファイル名）
$uploaded_path = '/Applications/MAMP/Images/' . $filename;
//echo $uploaded_path.'<br>';
 
$result = move_uploaded_file($file['tmp_name'], $uploaded_path);
 
if ($result) {
    $MSG = 'アップロード成功！ファイル名：'.$filename;
    $img_path = $uploaded_path;
    echo $MSG;
} else {
    $MSG = 'アップロード失敗！エラーコード：'.$file['error'];
    echo $MSG;
}
