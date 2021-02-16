<?php
session_start();
session_destroy();

setcookie('remember_me', null, time() - (86400 * 30), "/");

header("location: index.php");
