<?php
ob_start();
include('includes/db.php');
session_start();

if (empty($_COOKIE['remember_me'])) {

    if (empty($_SESSION['user_id'])) {

        header('location:login.php');
    }
}

if (isset($_POST["mixtape_edit_btn"])) {

    $dj_set_id = $_POST["dj_set_id"];

    $mixtape = $_POST["mixtape"];
    $mixtape_name = $_POST["mixtape_name"];

    $url_yt = $_POST["url_yt"];
    $url_sc = $_POST["url_sc"];


    $updated_by = $_SESSION["user_id"];



    $stmt = $conn->prepare("UPDATE `dj_sets` SET mixtape=:mixtape,mixtape_name=:mixtape_name,url_yt=:url_yt,url_sc=:url_sc ,updated_by=:updated_by ,updated=CURRENT_TIMESTAMP WHERE id=:id");

    $stmt->bindParam(':mixtape', $mixtape);
    $stmt->bindParam(':mixtape_name', $mixtape_name);
    $stmt->bindParam(':url_yt', $url_yt);
    $stmt->bindParam(':url_sc', $url_sc);

    $stmt->bindParam(':updated_by', $updated_by);

    $stmt->bindParam(':id', $dj_set_id);


    if($stmt->execute()){
        header("location: add_mixtapes.php?status=edit_succ");

    }
    else{
        header("location: add_mixtapes.php?status=edit_fail");

    }
}
