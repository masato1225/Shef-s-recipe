<?php
session_start();
require_once(ROOT_PATH .'/Controllers/UserController.php');
if (empty($_SESSION["login_user"])) {
    header('Location: login_form.php');
}
$words = preg_replace("/( |　)/", "", $_POST["search"]);
$word = "%".$words."%";
$recipe = new UserController();
$search = $recipe -> search($word);

$count  = count($search['search']);
echo $_POST["search"]."<br>";
echo $words."<br>";
echo $word;

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
    <title>レシピ検索</title>
</head>
<body style = "background-color :#FAEBD7;">
<?php include("header.php")?>
<div class = "box">
    <div id = "guide">
        <?php if (!empty($_POST["search"])) :?>
            <h3><?php echo $_POST["search"]?>の検索結果：<?php echo $count ?> 件</h3>
        <?php else :?>
            <h3 class = "d-flex align-items-center justify-content-center" style = "height: 80vh;">レシピ検索には何も入力されていません。<br>キーワードを入力し直してください</h3>
        <?php endif;?>
    </div>
    <?php foreach ($search['search'] as $key => $vals) : ?>
        <div class = "d-flex justify-content-center my-5 mx-auto" style = "width:80%; background-color:#FFE4B5; border-radius:10px;">
            <div id = "list_form" class = "d-flex align-items-center mx-3 py-3" style = "width:30%;">
                <a href = "myrecipe.php?id=<?php echo $vals["id"]?>"><img src="<?php echo "/". $vals["file_path"] ?>" style = "width:110%;"></a>
            </div>
            <div id = "list_form" style = "width:40%;" class = "mx-3 py-3">
                <div>
                    <label for="name">タイトル</label><br>
                    <a href = "myrecipe.php?id=<?php echo $vals["id"]?>"><?php echo $vals["name"]?><br></a>
                    <label for="intro">ひとこと紹介</label><br>
                    <a href = "myrecipe.php?id=<?php echo $vals["id"]?>"><?php echo $vals["introduce"]?></a>
                </div>
            </div>
        </div>
    <?php endforeach;?>
    <div class='paging my-3'>
        <?php
        for ($i = 0; $i <= $search['pages']; $i++) {
            if (isset($_GET['page']) && $_GET['page'] == $i) {
                echo $i + 1;
            } else {
                echo "<a href='?page=".$i."'>".($i + 1)."</a>";
            }
        }
        ?>
    </div>
</div>
<?php include("footer.html")?>
</body>
</html>