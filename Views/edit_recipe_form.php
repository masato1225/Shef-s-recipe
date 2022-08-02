<?php
session_start();
require_once(ROOT_PATH .'/Controllers/UserController.php');
if (empty($_SESSION["login_user"])) {
    header('Location: login_form.php');
}
$err = [];
if (isset($_SESSION["err"])) {
    $err = $_SESSION["err"];
    unset($_SESSION["err"]);
}

$recipe = new UserController();
if (!isset($_SESSION["edit_recipe"])) {
    $view = $recipe -> view();
    $recipe_id = $view["recipe"]["id"];
    $user_id = $view["recipe"]["user_id"];
}

if (!isset($_SESSION["edit_ingredment"])) {
    $view_process = $recipe -> method();
    $count = count($view_process["method"]);
} else {
    $count = count($_SESSION["edit_ingredment"]);
}
//変更前の調理工程の個数
if (isset($view_process["method"])) {
    $_SESSION["count"] = count($view_process["method"]);
}


if (isset($view_process)) {
    for ($i = 0; $i < $_SESSION["count"]; $i++) {
        $_SESSION["id"][$i] = $view_process["method"][$i]["id"];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/bootstrap.css" type="text/css"/>
    <link rel="stylesheet" href="/css/index.css" type="text/css"/>
    <link rel="stylesheet" href="/css/form.css" type="text/css"/>
    <title>レシピ編集</title>
</head>
<body style = "background-color :#FAEBD7;">
<?php include("header.php")?>
<div class = "box">
<h1 class = "text-center">レシピを編集する</h1>
    <form enctype="multipart/form-data" action="edit.php" method = "POST" id = "recipe">
        <input type = "hidden" name = "recipe_id" value = <?php echo isset($_SESSION["edit_recipe"]["id"]) ? $_SESSION["edit_recipe"]["id"] : $recipe_id?>>
        <input type = "hidden" name = "user_id" value = <?php echo isset($_SESSION["edit_recipe"]["user_id"]) ? $_SESSION["edit_recipe"]["user_id"] : $user_id?>>

        <div id = "recipe_box">
            <div id = "recipe_left" style = "width:55%;" class = "mx-auto" enctype="multipart/form-data">
                <div id = "image_form">
                    <label for="image">レシピ写真</label><br>
                    <input type = "hidden" name = "MAX_FILE_SIZE" value = "1048576">
                    <span style = "color:red;"><?php echo isset($err["edit_imgsize"]) ? $err["edit_imgsize"] : ''?></span>
                    <span style = "color:red;"><?php echo isset($err["edit_imgtype"]) ? $err["edit_imgtype"] : ''?></span>
                    <span style = "color:red;"><?php echo isset($err["edit_imgpath"]) ? $err["edit_imgpath"] : ''?></span>
                    <input type="file" name = "img" id="image" accept = "image/*" class = "my-1">
                </div>
            </div>

            <div id = "recipe_right" style = "width:55%;" class = "mx-auto">
                <div id = "recipe_form">
                    <label for="name">タイトル</label><br>
                    <span style = "color:red;"><?php echo isset($err["name"]) ? $err["name"] : ''?></span>
                    <input type="text" name = "name" style = "width:50vw; height:6vh; font-size:1.7rem;" value = <?php echo isset($_SESSION["edit_recipe"]["name"]) ? $_SESSION["edit_recipe"]["name"] : $view["recipe"]["name"]?>>
                </div>

                <div id = "recipe_form">
                    <label for="intro">ひとこと紹介</label><br>
                    <span style = "color:red;"><?php echo isset($err["intro"]) ? $err["intro"] : ''?></span>
                    <textarea name = "intro" cols="50" rows="3" style = "width:50vw; font-size:1.3rem;"><?php echo isset($_SESSION["edit_recipe"]["intro"]) ? $_SESSION["edit_recipe"]["intro"] :  $view["recipe"]["introduce"]?></textarea>
                </div>
                <div class = "d-flex" style = "width:100%;">
                        <div id = "recipe_form_figure">
                            <label for="time">調理時間</label><br>
                            <span style = "color:red; font-size:1rem;"><?php echo isset($err["time"]) ? $err["time"] : ''?></span>
                            <p><input type="text" name = "time" style = "width:5vw; height:5vh; font-size:1.4rem;" value = <?php echo isset($_SESSION["edit_recipe"]["time"]) ? $_SESSION["edit_recipe"]["time"] : $view["recipe"]["time"]?>>分</p>
                         </div>

                        <div id = "recipe_form_figure" class = "mx-auto">
                            <label for="cost">費用</label><br>
                            <span style = "color:red; font-size:1rem;"><?php echo isset($err["cost"]) ? $err["cost"] : ''?></span>
                            <p><input type="text" name = "cost" style = "width:5vw; height:5vh; font-size:1.4rem;" value = <?php echo isset($_SESSION["edit_recipe"]["cost"]) ? $_SESSION["edit_recipe"]["cost"] : $view["recipe"]["cost"]?>>円</p>
                        </div>
                        
                        <div id = "recipe_form_figure">
                            <label for="cost">目安</label><br>
                            <span style = "color:red; font-size:1rem;"><?php echo isset($err["serving"]) ? $err["serving"] : ''?></span>
                            <p><input type="text" name = "serving" style = "width:5vw; height:5vh; font-size:1.4rem;" value = <?php echo isset($_SESSION["edit_recipe"]["serving"]) ? $_SESSION["edit_recipe"]["serving"] :   $view["recipe"]["serving"]?>>人前</p>
                        </div>
                </div>
            </div>
        </div>
        <h3 class = "my-3">レシピの材料&手順</h3>

        <div id = "method">
            <div id = "method_form" style = "font-size:1.2rem;" class = "my-3">
                <span style = "color:red;"><?php echo isset($err["edit_ingredment"]) ? $err["edit_ingredment"] : ''?></span><br>
                <span style = "color:red;"><?php echo isset($err["edit_method"]) ? $err["edit_method"] : ''?></span>
            </div>
            <ol>
                <?php if (isset($_SESSION["edit_ingredment"]) || isset($_SESSION["edit_method"])) : ?>
                    <?php for ($i = 0; $i < $count; $i++) { ?>
                        <div id = "method_form" class = "px-5">
                                <li id = "conf_method">作り方</li>
                                <input type="hidden" name = "id[]" pattern=".*\S+.*" required value =<?php echo isset($_SESSION["edit_id"][$i]) ? $_SESSION["edit_id"][$i] : "" ?>>
                                <label for="ingredment">使う材料</label><br>
                                <input type="text" name = "ingredment[]" placeholder = "サラダ油大さじ2" value =<?php echo isset($_SESSION["edit_ingredment"][$i]) ? $_SESSION["edit_ingredment"][$i] : "" ?>><br>
                                <label for="method">調理手順</label><br>
                                <textarea name="method[]" pattern=".*\S+.*" required id="" cols="30" rows="5" placeholder = "サラダ油を鶏モモ肉に絡め、グリルで焼きます。両面焼き水なしグリル上・下強火8分で完成です。"><?php echo isset($_SESSION["edit_method"][$i]) ? $_SESSION["edit_method"][$i] : ""?></textarea>
                        </div>
                    <?php } ?>
                <?php else : ?>
                    <?php foreach ($view_process['method'] as $key => $vals) :  ?>
                        <div id = "method_form">
                            <input type="hidden" name = "id[]" value = <?php echo $vals["id"]?>>
                            <li id = "conf_method">作り方</li>
                            <label for="ingredment">使う材料</label><br>
                            <input type="text" name = "ingredment[]" pattern=".*\S+.*" required placeholder = "サラダ油大さじ2"value = <?php echo $vals["ingreadment"]?>><br>
                            <label for="method">調理手順</label><br>
                            <textarea name="method[]" id="" cols="30" rows="5" pattern=".*\S+.*" required placeholder = "サラダ油を鶏モモ肉に絡め、グリルで焼きます。両面焼き水なしグリル上・下強火8分で完成です。"><?php echo $vals["method"]?></textarea>
                        </div>
                    <?php endforeach ; ?>
                <?php endif; ?>
            </ol>
            <div id = "method_form" class = "d-flex justfy-content-around">
                        <button id="remove" type="button" style = "font-size:40px;">-</button>
                        <button id="add" type="button" style = "font-size:40px;">+</button>
            </div>
        </div>
        <div id = "send" class = "d-flex justify-content-center">
            <input type="button" onclick="history.back()" value="戻る">
            <input type="submit" name = "send" value = "投稿する">
        </div>
    </form>
</div>
<?php
include("footer.html");
?>

<script src="../js/jquery-3.6.0.min.js" type="text/javascript"></script>
<script src="../js/script.js" type="text/javascript"></script>
</body>
</html>