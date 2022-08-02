<?php
session_start();
if (!isset($_SESSION)) {
    header('Location: login_form.php');
    return;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/css/bootstrap.css" type="text/css"/>
    <link rel="stylesheet" href="/css/index.css" type="text/css"/>
    <link rel="stylesheet" href="/css/form.css" type="text/css"/>
    <title>プロフィール編集</title>
</head>
<body style = "background-color :#FAEBD7;">
<?php include("header.php")?> 
<div class = "box d-flex justify-content-center">
    <form action = "edit_profile.php" method = "POST">
    <h2 class = "d-flex justify-content-center">プロフィール編集</h2>
        <input type="hidden" name = 'id' value = <?php echo $_SESSION["login_user"]["id"]?>>
        <div class = "update_form"> 
            <label for="name">ユーザー名</label>
            <span style="color:red;"><?php
            if (isset($_SESSION["err"]["err_name"])) {
                echo $_SESSION["err"]["err_name"];
            }
            ?></span><br>
            <input type="text" name = 'name' value = <?php echo $_SESSION["login_user"]["name"]?> class = "form-control input-lg my-2">
        </div>
        <div class = "update_form"> 
            <label for="name">働いている店名</label>
            <span style="color:red;"><?php
            if (isset($_SESSION["err"]["err_restaurant"])) {
                echo $_SESSION["err"]["err_restaurant"];
            }
            ?></span><br>
            <input type="text" name = 'restaurant' value = <?php echo $_SESSION["login_user"]["restaurant"]?> class = "form-control input-lg my-2">
        </div>
        <div class = "update_form"> 
            <label for="name">ひとこと</label>
            <span style="color:red;"><?php
            if (isset($_SESSION["err"]["err_comment"])) {
                echo $_SESSION["err"]["err_comment"];
            }
            ?></span><br>
            <input type="text" name = 'comment' value = <?php echo $_SESSION["login_user"]["comment"]?> class = "form-control input-lg my-2">
        </div>
        <div class = "d-flex justify-content-center my-5">
            <input type="submit" name = 'send' value = "編集する" class = "align-middle btn btn-default-v3 btn-outline-warning" style = "font-size:1.5rem; color:black;">
        </div>
    </form>
</div>

<?php include("footer.html")?>
<?php unset($_SESSION["err"]);?>
</body>
</html>