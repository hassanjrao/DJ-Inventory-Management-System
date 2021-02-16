<?php

ob_start();
include('includes/db.php');
session_start();

if (empty($_COOKIE['remember_me'])) {

	if (empty($_SESSION['user_id'])) {

		header('location:login.php');
	}
}

?>