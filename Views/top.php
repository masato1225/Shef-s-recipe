<?php
session_start();
require_once(ROOT_PATH .'/Controllers/UserController.php');
if (empty($_SESSION["login_user"])) {
    header('Location: login_form.php');
}
$recipe = new UserController();
$count = $recipe -> countMyrecipe($_SESSION["login_user"]["id"]);//投稿したレシピの数
if ($count > 0) {
    $list = $recipe -> list($_SESSION["login_user"]["id"]);//最新投稿レシピ
    $image = $recipe -> getImage($_SESSION["login_user"]["id"]);//最新投稿レシピの画像
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/css/bootstrap.css" type="text/css"/>
    <link rel="stylesheet" href="/css/index.css" type="text/css"/>
    <title>トップページ</title>
</head>
<body style = "background-color :#FAEBD7;">
    <?php include("header.php")?>
    <div class = "box">
        <div class = "profile">
            <p class = "title d-flex justify-content-center" style = "font-weight:bold; color:#CD853F; text-stroke: 1px #333333;">マイプロフィール</p>
            <div class = "pro_list d-flex justify-content-center mt-4">
                <div style = "width:40%;" class = "mx-5">
                    <p>ユーザー名はテストです：<?php echo $_SESSION["login_user"]["name"]?></p>
                    <p>働いているお店：<?php echo  $_SESSION["login_user"]["restaurant"]?></p>
                    <p>投稿したレシピ数：<?php echo $count?></p>
                </div>
                <p style ="width:40%;">ひとこと<br>
                    <?php echo $_SESSION["login_user"]["comment"]?>
                </p>
            </div>
            <div id = "edit_profile">
                <a href="edit_profile_form.php">プロフィールを編集する</a>
            </div>
        </div>

        <div class = "recipe my-4" style ="height:350px; background-color:#FFE4B5;">
            <p class = "title d-flex justify-content-center" style = "font-weight:bold; color:#CD853F;">投稿したレシピ</p>
            <div class = "d-flex justify-content-around mt-4">
                <?php if (isset($list[0])) :?>
                    <div class = "recipe_list" style = "width:30%; height:230px;text-align: center;">
                        <div class = "recipe_image h-75 w-75 mx-auto mt-3">
                            <a href = "myrecipe.php?id=<?php echo $list[0]["id"] ?>"><img src="<?php echo "/". $list[0]['file_path']; ?>" style = "width:100%; height:100%;"></a>
                        </div>
                        <div class = "my-3">
                            <a href = "myrecipe.php?id=<?php echo $list[0]["id"] ?>" style = "font-size:1.4rem; color:black; text-decoration:none;"><?php echo $list[0]["name"]?></a>
                        </div>
                    </div>
                <?php endif;?>
                <?php if (isset($list[1])) :?>
                    <div class = "recipe_list" style = "width:30%; height:230px; text-align: center;">
                        <div class = "recipe_image h-75 w-75 mx-auto mt-3">
                            <a href = "myrecipe.php?id=<?php echo $list[1]["id"] ?>"><img src="<?php echo "/". $list[1]['file_path']; ?>" style = "width:100%; height:100%;"></a>
                        </div>
                        <div class = "my-3">
                            <a href = "myrecipe.php?id=<?php echo $list[1]["id"] ?>" class = "mx-auto" style = "font-size:1.4rem; color:black; text-decoration:none;"><?php echo $list[1]["name"]?></a>
                        </div>
                    </div>
                <?php endif;?>
                <?php if (isset($list[2])) :?>
                    <div class = "recipe_list" style = "width:30%; height:230px; text-align: center;">
                        <div class = "recipe_image h-75 w-75 mx-auto mt-3">
                            <a href = "myrecipe.php?id=<?php echo $list[2]["id"] ?>"><img src="<?php echo "/". $list[2]['file_path']; ?>" style = "width:100%; height:100%;"></a>
                        </div>
                        <div class = "my-3">
                            <a href = "myrecipe.php?id=<?php echo $list[2]["id"] ?>" class = "mx-auto" style = "font-size:1.4rem; color:black; text-decoration:none;"><?php echo $list[2]["name"]?></a>
                        </div>
                    </div>
                <?php endif;?>
                <?php if (!isset($list)) :?>
                    <div class = "recipe_list" style = "text-align:center;height:100%;">
                        <p style = "height:100%; font-size:1.8rem;" class = "d-flex justify-content-center align-items-center" >まだレシピが投稿されていません</p><br>
                        <a href = "new_recipe_form.php" style = "font-size:1.8rem; color:#DC143C; font-weight:bold;" >レシピを投稿する</a>
                    </div>
                <?php endif;?>
            </div>
            <?php if ($count > 3) : ?>
                <div style = "text-align:center" class = "py-2">
                    <a href = "myrecipe_list.php" style = "color:black; font-size:1.4rem; font-weight:bold;" class = "mx-auto">もっと見る</a>
                </div>
            <?php endif;?>
        </div>
    </div>
    <?php include("footer.html")?>
</body>
</html>