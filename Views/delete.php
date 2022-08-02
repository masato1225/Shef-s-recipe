<?php
session_start();
require_once(ROOT_PATH .'/Controllers/UserController.php');
if (empty($_SESSION["login_user"])) {
    header('Location: login_form.php');
}

$recipe = new UserController();
$delete_recipe = $recipe -> deleteRecipe();
$delete_process = $recipe -> deleteProcess();
$delete_image = $recipe -> deleteImage();

header('Location: top.php');
