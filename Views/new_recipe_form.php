<?php
session_start();
if (empty($_SESSION["login_user"])) {
    header('Location: login_form.php');
}
$err = [];
if (isset($_SESSION["err"])) {
    $err = $_SESSION["err"];
}

if (isset($_SESSION["ingredment"])) {
    $count = count($_SESSION["ingredment"]);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/css/bootstrap.css" type="text/css"/>
    <link rel="stylesheet" href="/css/index.css" type="text/css"/>
    <link rel="stylesheet" href="/css/form.css" type="text/css"/>
    <title>新規レシピ作成</title>
</head>
<body style = "background-color :#FAEBD7;">
<?php include("header.php")?>
<div class = "box">
    <h1 class = "d-flex justify-content-center">レシピを作る</h1>
    <h3>はじめに</h3>
    <p>レシピのタイトル、紹介、調理した時間、食材の費用を書いてみましょう。</p>
    <form enctype="multipart/form-data" action="new_recipe_form_conf.php" method = "POST" id = "recipe">
        <div id = "recipe_box">
            <div style = "width:60%;" class = "mx-auto">
                <div id = "image_form">
                    <label for = "image">レシピ写真</label><br>
                    <input type = "hidden" name = "MAX_FILE_SIZE" value = "1048576">
                    <span style = "color:red;"><?php echo isset($err["imgsize"]) ? $err["imgsize"] : ''?></span>
                    <span style = "color:red;"><?php echo isset($err["imgtype"]) ? $err["imgtype"] : ''?></span>
                    <span style = "color:red;"><?php echo isset($err["imgpath"]) ? $err["imgpath"] : ''?></span>
                    <input type="file" name = "img" id="image" accept = "image/*" class = "my-1">
                </div>
                <div id = "recipe_form">
                    <label for="name">タイトル</label><br>
                    <span style = "color:red;"><?php echo isset($err["name"]) ? $err["name"] : ''?></span><br>
                    <input type="text" name = "name" pattern=".*\S+.*" style = "width:50vw; height:6vh; font-size:1.7rem;" placeholder = "揚げない簡単唐揚げ～オレンジ風味～" value = <?php echo isset($_SESSION["recipe"]["name"]) ? $_SESSION["recipe"]["name"] : ''?>>
                </div>

                <div id = "recipe_form">
                    <label for="intro">ひとこと紹介</label><br>
                    <span style = "color:red;"><?php echo isset($err["intro"]) ? $err["intro"] : ''?></span><br>
                    <textarea name="intro"  rows="3" pattern=".*\S+.*" style = "width:50vw;font-size:1.3rem;" placeholder = "定番料理の唐揚げをさっぱり、ヘルシーにしてみました。" value = <?php echo isset($_SESSION["recipe"]["intro"]) ? $_SESSION["recipe"]["intro"] : ''?>></textarea>
                </div>
                <div class = "d-flex" style = "width:100%;">
                        <div id = "recipe_form_figure">
                            <label for="time">調理時間</label><br>
                            <span style = "color:red; font-size:1rem;"><?php echo isset($err["time"]) ? $err["time"] : ''?></span>
                            <input type="text" name = "time" style = "width:5vw; height:5vh; font-size:1.4rem;" placeholder = "30" value = <?php echo isset($_SESSION["recipe"]["time"]) ? $_SESSION["recipe"]["time"] : ''?>><span>分</span>
                         </div>

                        <div id = "recipe_form_figure" class = "mx-5">
                            <label for="cost">費用</label><br>
                            <span style = "color:red; font-size:1rem;"><?php echo isset($err["cost"]) ? $err["cost"] : ''?></span>
                            <input type="text" name = "cost" style = "width:5vw; height:5vh; font-size:1.4rem;" placeholder = "300" value = <?php echo isset($_SESSION["recipe"]["cost"]) ? $_SESSION["recipe"]["cost"] : ''?>><span>円</span>
                        </div>
                        
                        <div id = "recipe_form_figure">
                            <label for="cost">目安</label><br>
                            <span style = "color:red; font-size:1rem;"><?php echo isset($err["serving"]) ? $err["serving"] : ''?></span>
                            <input type="text" name = "serving" style = "width:5vw; height:5vh; font-size:1.4rem;" placeholder = "1" value = <?php echo isset($_SESSION["recipe"]["serving"]) ? $_SESSION["recipe"]["serving"] : ''?>><span>人前</span>
                        </div>
                </div>
            </div>
        </div>
        <h3>レシピの材料&手順</h3>
        <p>レシピの材料と手順を書いてみましょう。<br>もし次の工程が必要な場合は＋ボタンを押しましょう。</p>
        <div id = "method">
            <div id = "method_form" style = "font-size:1.2rem;" class = "my-3">
                <span style = "color:red;"><?php echo isset($err["ingredment"]) ? $err["ingredment"] : ''?></span><br>
                <span style = "color:red;"><?php echo isset($err["method"]) ? $err["method"] : ''?></span>
            </div>
            <ol>
                <div id = "method_form">
                        <li>作り方</li>
                        <label for="ingredment">調理材料</label><br>
                        <input type="text" name = "ingredment[]" pattern=".*\S+.*"  placeholder = "鶏モモ肉2枚、醤油大さじ1と1/2、マーマレード大さじ2" class = "px-auto" value = <?php echo isset($_SESSION["ingredment"][0]) ? $_SESSION["ingredment"][0] : ''?>><br>

                        <label for="method">調理手順</label><br>
                        <textarea name="method[]" id="" cols="30" rows="5" pattern=".*\S+.*" placeholder = "鶏モモ肉はひと口大に切り、醤油、マーマレードをもみ込んでしばらくおきます。" value = <?php echo isset($_SESSION["method"][0]) ? $_SESSION["method"][0] : ''?>></textarea>
                </div>

                <div id = "method_form">
                        <li>作り方</li>
                        <label for="ingredment">調理材料</label><br>
                        <input type="text" name = "ingredment[]" placeholder = "片栗粉適量" pattern=".*\S+.*"  value = <?php echo isset($_SESSION["ingredment"][1]) ? $_SESSION["ingredment"][1] : ''?>><br>

                        <label for="method">調理手順</label><br>
                        <textarea name="method[]" id="" cols="30" rows="5" pattern=".*\S+.*" placeholder = "鶏モモ肉に片栗粉をまぶして余分な粉をおとします" value = <?php echo isset($_SESSION["method"][1]) ? $_SESSION["method"][1] : ''?>></textarea>
                </div>

                <div id = "method_form">
                        <li>作り方</li>
                        <label for="ingredment">調理材料</label><br>
                        <input type="text" name = "ingredment[]" placeholder = "サラダ油大さじ2" pattern=".*\S+.*"  value = <?php echo isset($_SESSION["ingredment"][2]) ? $_SESSION["ingredment"][2] : ''?>><br>

                        <label for="method">調理手順</label><br>
                        <textarea name="method[]" id="" cols="30" rows="5" pattern=".*\S+.*"  placeholder = "サラダ油を鶏モモ肉に絡め、グリルで焼きます。両面焼き水なしグリル上・下強火8分で完成です。" value = <?php echo isset($_SESSION["method"][2]) ? $_SESSION["method"][2] : ''?>></textarea>
                </div>
<!--手順が４つ以上の場合はphpで出す-->
                <?php if (isset($_SESSION["send"]) && isset($count)) : ?>
                    <?php for ($i = 3; $i < $count; $i++) { ?>
                    <div id = "method_form">
                            <li>作り方</li>
                            <label for="ingredment">調理材料</label><br>
                            <input type="text" name = "ingredment[]" pattern=".*\S+.*"  placeholder = "サラダ油大さじ2" value = <?php echo isset($_SESSION["ingredment"][$i]) ? $_SESSION["ingredment"][$i] : ''?>><br>

                            <label for="method">調理手順</label><br>
                            <textarea name="method[]" id="" cols="30" rows="5" pattern=".*\S+.*" placeholder = "サラダ油を鶏モモ肉に絡め、グリルで焼きます。両面焼き水なしグリル上・下強火8分で完成です。" value = <?php echo isset($_SESSION["method"][$i]) ? $_SESSION["method"][$i] : ''?>></textarea>
                    </div>
                    <?php } ?>
                <?php endif;?>
<!--手順が４つ以上の場合はphpで出す-->
            </ol>
                <div id = "method_form" class = "d-flex justfy-content-around">
                        <button id="remove" type="button" style = "font-size:40px;">-</button>
                        <button id="add" type="button" style = "font-size:40px;">+</button>
                </div>
        </div>
        <div id = "send" class = "d-flex justify-content-center">
            <input type="submit" name = "send" value = "投稿する">
        </div>
    </form>
</div><!--class = box--->
<?php include("footer.html")?>
<script src="../js/jquery-3.6.0.min.js" type="text/javascript"></script>
<script src="../js/script.js" type="text/javascript"></script>
</body>
<?php unset($_SESSION["err"]);?>
<?php unset($_SESSION["recipe"]);?>
<?php unset($_SESSION["ingredment"]);?>
<?php unset($_SESSION["method"]);?>
<?php unset($_SESSION["img"]);?>
<html>