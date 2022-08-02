<?php
include("/Applications/MAMP/Models/Good.php");
header("Content-type: application/json; charset=UTF-8");
session_start();

$favolite = new Good();
if (isset($_POST)) {
    $user_id = $_POST['user_id'];
    $recipe_id = $_POST['recipe_id'];
    $check = $favolite -> reloadfavolite($user_id, $recipe_id);
    var_dump($check);
    if ($check == true) {
         $result = $favolite -> favoriteCansel($user_id, $recipe_id);//削除機能
    } elseif ($check == false) {
         $result = $favolite -> favoriteDone($user_id, $recipe_id);//登録機能
    }
    return $result;
}
