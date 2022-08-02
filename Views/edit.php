<?php
session_start();
if (empty($_SESSION["login_user"])) {
    header('Location: login_form.php');
}

if (empty($_SESSION["edit_recipe"])) {
    header('Location: top.php');
}

require_once(ROOT_PATH .'/Controllers/UserController.php');
/**レシピ紹介部分バリデーション */
$post = filter_input_array(INPUT_POST, $_POST);
$_SESSION["edit_recipe"] = [];
$_SESSION["edit_recipe"]["id"] = htmlspecialchars($post["recipe_id"], ENT_QUOTES, "UTF-8");
$_SESSION["edit_recipe"]["user_id"] = htmlspecialchars($post["user_id"], ENT_QUOTES, "UTF-8");
$_SESSION["edit_recipe"]["name"] = htmlspecialchars($post["name"], ENT_QUOTES, "UTF-8");
$_SESSION["edit_recipe"]["intro"] = htmlspecialchars($post["intro"], ENT_QUOTES, "UTF-8");
$_SESSION["edit_recipe"]["time"] = htmlspecialchars($post["time"], ENT_QUOTES, "UTF-8");
$_SESSION["edit_recipe"]["cost"] = htmlspecialchars($post["cost"], ENT_QUOTES, "UTF-8");
$_SESSION["edit_recipe"]["serving"] = htmlspecialchars($post["serving"], ENT_QUOTES, "UTF-8");
$err = [];

if (empty($_SESSION["edit_recipe"]["name"])) {
    $err["name"] = "タイトルを入力してください";
}
if (empty($_SESSION["edit_recipe"]["intro"]) || mb_strlen($_SESSION["edit_recipe"]["intro"]) > 100 || mb_strlen($_SESSION["edit_recipe"]["intro"]) < 20) {
    $err["intro"] = "ひとこと紹介は20文字以上100文字未満です";
}
if (empty($_SESSION["edit_recipe"]["time"]) || !preg_match('/^[0-9]+$/', $_SESSION["edit_recipe"]["time"])) {
    $err["time"] = "半角数字で入力してください<br>";
}
if (empty($_SESSION["edit_recipe"]["cost"]) || !preg_match('/^[0-9]+$/', $_SESSION["edit_recipe"]["cost"])) {
    $err["cost"] = "半角数字で入力してください<br>";
}
if (empty($_SESSION["edit_recipe"]["serving"]) || !preg_match('/^[0-9]+$/', $_SESSION["edit_recipe"]["serving"])) {
    $err["serving"] = "半角数字で入力してください<br>";
}

/**調理方法部分バリデーション */
$count = count($_POST["ingredment"]);//変更後の調理工程の個数
for ($i = 0; $i < $count; $i++) {
    if (!empty($_POST["id"][$i])) {
        $_SESSION["edit_id"][$i] = htmlspecialchars($_POST["id"][$i], ENT_QUOTES, "UTF-8");
    }
    $_SESSION["edit_ingredment"][$i] =  htmlspecialchars($_POST["ingredment"][$i], ENT_QUOTES, "UTF-8");
    $_SESSION["edit_method"][$i] = htmlspecialchars($_POST["method"][$i], ENT_QUOTES, "UTF-8");
}

foreach ($_POST['ingredment'] as $ing) {
    if (empty($ing)) {
        $err["edit_ingredment"] = "※材料が全て入力されていません。";
    }
}
foreach ($_POST['method'] as $method) {
    if (empty($method)) {
        $err["edit_method"] = "※調理手順が全て入力されていません。";
    }
}

//レシピ画像バリデーション
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
    $err["edit_imgsize"]= "ファイルサイズは1MB未満にしてください<br>";
}
//拡張子は画像形式か
$allow_ext = array("jpg", "jpeg", "png");
$file_ext = pathinfo($filename, PATHINFO_EXTENSION);

if (!in_array(strtolower($file_ext), $allow_ext)) {
    $err["edit_imgtype"] = "画像ファイルを添付してください<br>";
}

//ファイルはあるかどうか

if (is_uploaded_file($tmp_path)) {
    $result = move_uploaded_file($tmp_path, $save_path);
} else {
    $err["edit_imgpath"] = "ファイルが選択されていません<br>";
}

$user_id = $_SESSION["edit_recipe"]["user_id"];
$recipe_id = $_SESSION["edit_recipe"]["id"];
$recipe = new UserController();
//エラーのある場合new_recipe_form.phpに戻す

if (!empty($err)) {
    $_SESSION["err"] = $err;
    header('Location: edit_recipe_form.php');
    exit();
}

//エラーが無い場合はデータベースに更新する

$recipe = new UserController();

//recipesテーブルの変更
$edit_recipe = $recipe -> recipeupdate($_SESSION["edit_recipe"]);
unset($_SESSION["recipe_id"]);

$user_id = $_SESSION["edit_recipe"]["user_id"];
$recipe_id = $_SESSION["edit_recipe"]["id"];
$data = [];
for ($i = 0; $i < $count; $i++) {
    if (!empty($_SESSION["edit_id"][$i])) {
        $data[$i]["edit_id"] = $_SESSION["edit_id"][$i];
    }
    $data[$i]["edit_ingredment"] = $_SESSION["edit_ingredment"][$i];
    $data[$i]["edit_method"] = $_SESSION["edit_method"][$i];
}

//methodテーブルの変更
if ($count == $_SESSION["count"]) {//編集前の調理工程の個数と編集後の調理工程の個数が同じ場合
    foreach ($data as $key => $value) {
        $edit_update = $recipe -> processupdate($value, $user_id, $recipe_id);
    }
} elseif ($count < $_SESSION["count"]) {//編集前の調理工程 > 編集後の調理工程
    foreach ($data as $key => $value) {
        $edit_update = $recipe -> processupdate($value, $user_id, $recipe_id);
    }

    for ($i = $_SESSION["count"]; $i > $count; $i--) {
        $reduce = $recipe -> reduce($_SESSION["id"][$i-1]);
    }
} elseif ($count > $_SESSION["count"]) {//編集前の調理工程 < 編集後の調理工程
    foreach ($data as $key => $value) {
        $edit_update = $recipe -> processupdate($value, $user_id, $recipe_id);
    }
    for ($i = $_SESSION["count"]; $i < $count; $i++) {
        $reduce = $recipe -> add($user_id, $recipe_id, $data[$i]);
    }
}

$data = array();

$data["user_id"] = $user_id;
$data["recipe_id"] = $recipe_id;
$data["file_name"] = $filename;
$data["file_path"] = $save_path;


//imageテーブルの変更
$edit_image = $recipe -> updateImage($data);
var_dump($_SESSION);
unset($_SESSION["edit_recipe"]);
unset($_SESSION["edit_id"]);
unset($_SESSION["edit_ingredment"]);
unset($_SESSION["edit_method"]);
unset($_SESSION["count"]);
unset($_SESSION["id"]);
header('Location: top.php');
