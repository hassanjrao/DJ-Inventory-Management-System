<?php

ob_start();
include('includes/db.php');
session_start();

if (empty($_COOKIE['remember_me'])) {

    if (empty($_SESSION['user_id'])) {

        header('location:login.php');
    }
}


$delete = $_GET['id'];

$del = $conn->prepare("DELETE FROM show_names WHERE id='$delete'");

if ($del->execute()) {
    header("location:all_show_names.php?status=del_succ");
} else {
    header("location:all_show_names.php?status=del_fai;");
}
