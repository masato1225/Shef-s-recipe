<?php
session_start();
require_once(ROOT_PATH .'/Controllers/UserController.php');
if (empty($_SESSION["login_user"])) {
    header('Location: login_form.php');
}

$recipe = new UserController();
$myrecipe = $recipe -> findAll($_SESSION["login_user"]["id"]);

$count  = count($myrecipe['recipes']);
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
    <title>レシピ一覧</title>
</head>
<body style = "background-color :#FAEBD7;">
<?php include("header.php")?>
<h2 class = "my-3 text-center" >今まで投稿したレシピ</h2>

    <?php foreach ($myrecipe['recipes'] as $key => $vals) : ?> 
        <div class = "d-flex my-5 justify-content-center">
            <div style = "width:70%; background-color:#FFCC99; border-radius:10px;" class = "d-flex justify-content-around my-3 py-2">
                <div id = "list_form" class = "d-flex align-items-center">
                    <a href = "myrecipe.php?id=<?php echo $vals["id"]?>"><img src = "<?php echo $vals["file_path"]?>" style = "height:200px; width:300px;"><br></a>
                </div>
                <div id = "list_form" style = "width:40%;">
                    <label for="name">タイトル</label><br>
                    <a href = "myrecipe.php?id=<?php echo $vals["id"]?>"><?php echo $vals["name"]?><br></a>
                    <label for="intro">ひとこと紹介</label><br>
                    <a href = "myrecipe.php?id=<?php echo $vals["id"]?>"><?php echo $vals["introduce"]?></a>
                </div>
            </div> 
        </div>
    <?php endforeach;?>
  
<div class='paging'>
    <?php
    for ($i = 0; $i <= $myrecipe['pages']; $i++) {
        if (isset($_GET['page']) && $_GET['page'] == $i) {
            echo $i + 1;
        } else {
            echo "<a href='?page=".$i."'>".($i + 1)."</a>";
        }
    }
    ?>
</div>
<?php include("footer.html")?>
</body>
</html>