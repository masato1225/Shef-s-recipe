<?php
session_start();
$_SESSION["login_user"] = array();
session_destroy();

header('Location: login_form.php');
