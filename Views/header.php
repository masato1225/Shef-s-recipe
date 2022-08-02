<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
</head>
<body>

<link rel="stylesheet" href="/css/bootstrap.css" type="text/css"/>

<div style = "height: 150px; background-color: #FFE4B5;" class = "header d-flex justify-content-center">

    <div class = "d-flex align-items-center">
        <?php if (empty($_SESSION["login_user"])) : ?>
            <h3 style = "font-size: 3.0vw;">Shef's recipe</h3>
        <?php else :?>
            <h3 style = "font-size: 3.0vw;"><a href="top.php" style = "color:black; text-decoration: none;">Shef's recipe</a></h3>
        <?php endif; ?>
    </div>
<?php if (!empty($_SESSION["login_user"])) : ?>
    <div style = "width: 70%;" class = "d-flex align-items-center">
        <ul id = "hedder_list" style = "width:100%;" class = "list-unstyled d-flex justify-content-around">

            <li style = "width:70%;" class = "d-flex align-items-end">
                <form action="search.php" method = "POST" style = "height :80%; width:80%;" class = "mx-auto">
                    <input type = "text" name = "search" placeholder="レシピを検索" class="form-control input-lg" value = <?php
                    if (isset($_POST["search"])) {
                        echo $_POST["search"];
                    }
                    ?>>
                </form>
            </li>
            
            <li class = "d-flex align-items-end"><a href="new_recipe_form.php" style = "color:black; text-decoration:none; font-weight:bold; font-size:1.3rem;">レシピ投稿</a></li>
            <li class ="d-flex align-items-end"><a href="logout.php" style = "color:black; text-decoration:none; font-weight:bold; font-size:1.3rem;">ログアウト</a></li>
        </ul>
    </div>
<?php endif; ?>
</div>

</body>
</html>