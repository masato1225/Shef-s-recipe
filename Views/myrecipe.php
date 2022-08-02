<?php
session_start();
require_once(ROOT_PATH .'/Controllers/UserController.php');
require_once(ROOT_PATH .'/Models/Good.php');

if (empty($_SESSION["login_user"])) {
    header('Location: login_form.php');
}
$recipe = new UserController();
$view = $recipe -> view();
$view_process = $recipe -> method();

$recipe_id = $view["recipe"]["id"]; //投稿ID
$check = $recipe -> checkfavolite($_SESSION["login_user"]["id"], $_GET["id"]);//お気に入り登録されているか確認
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/css/index.css" type="text/css"/>
    <link rel="stylesheet" href="/css/form.css" type="text/css"/>
    <href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
    <script src="https://use.fontawesome.com/releases/v5.15.4/js/all.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="../js/good.js" type="text/javascript"></script>
    <title>レシピ画面詳細</title>
</head>
<body style = "background-color :#FAEBD7;">
<?php include("header.php")?>
<div class = "box">
        <div id = "recipe_box" class = "my-5 d-flex align-items-center justify-content-center" >
            <div id = "recipe_left" style = "width:50%; height:100%;">
                <div id = "image_form">
                    <img src = "<?php echo "/". $view["recipe"]["file_path"]?>">
                </div>
                <?php if ($_SESSION["login_user"]["id"] !== $view["recipe"]["user_id"]) : ?>
                    <div id = "button_form">
                    <!---------------いいねボタン------------------->
                        <button type="button" name="favorite" class="favorite_btn" data-user_id = "<?php echo $_SESSION["login_user"]["id"]?>" data-recipe_id = "<?php echo $view["recipe"]["id"]?>">
                            <?php if ($check == true) : ?>
                                いいね解除
                            <?php elseif ($check == false) :?>
                                いいね
                            <?php endif; ?>
                        </button>
                    <!---------------いいねボタン------------------->
                    </div>
                <?php endif; ?>
            </div>

            <div id = "recipe_right" style = "width:50%;" class = "mx-2">
                <div id = "recipe_form">
                    <label for="name">タイトル</label><br>
                    <p><?php echo $view["recipe"]["name"];?></p>
                </div>

                <div id = "recipe_form">
                    <label for="intro">ひとこと紹介</label><br>
                    <p><?php echo $view["recipe"]["introduce"];?></p>
                </div>
                <div class = "d-flex" style = "width:100%;">
                        <div id = "recipe_form_figure">
                            <label for="time">調理時間</label><br>
                            <p><?php echo $view["recipe"]["time"];?>分</p>
                         </div>

                        <div id = "recipe_form_figure" class = "mx-5">
                            <label for="cost">費用</label><br>
                            <p><?php echo $view["recipe"]["cost"];?>円</p>
                        </div>
                        
                        <div id = "recipe_form_figure">
                            <label for="cost">目安</label><br>
                            <p><?php echo $view["recipe"]["serving"];?>人前</p>
                        </div>
                </div>
                <?php if ($_SESSION["login_user"]["id"] == $view["recipe"]["user_id"] || $_SESSION["login_user"]["roles"] == 1) : ?>
                    <div id = "edit_recipe" style = "height:50px;" class = "d-flex">
                            <a href = "edit_recipe_form.php?id=<?php echo $view["recipe"]["id"] ?>" id = "edit" style="text-decoration:none;">レシピを編集する</a>
                            <a href = "delete.php?id=<?php echo $view["recipe"]["id"] ?>" id = "delete" style="text-decoration:none;" class = "mx-5">レシピを削除する</a>
                    </div>
                <?php endif ; ?>
            </div>
        </div>
        <h3 class = "my-3">レシピの材料&手順</h3>

        <div id = "method" class = "mb-5">
            <ol>
                    <?php foreach ($view_process['method'] as $key => $vals) : ?>
                        <div id = "conf_form" class = "px-5">
                                    <li id = "conf_method">作り方</li>
                                    <label for="ingredment">使う材料</label><br>
                                    <p><?php echo $vals["ingreadment"];?></p>
                                    <label for="method">調理手順</label><br>
                                    <p><?php echo $vals["method"];?></p>
                        </div>
                    <?php endforeach; ?>
            </ol>
        </div>
</div>
<?php include("footer.html")?>
<?php
if (isset($_SESSION["edit_recipe"]) || isset($_SESSION["edit_ingredment"]) || isset($_SESSION["edit_method"])) {
    unset($_SESSION["edit_recipe"]);
    unset($_SESSION["edit_ingredment"]);
    unset($_SESSION["edit_method"]);
}
?>
</body>
</html>