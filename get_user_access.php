<?php

if(isset($_SESSION["user_id"])){

$user_id=$_SESSION["user_id"];

$query = $conn->prepare("SELECT access FROM users where id='$user_id'");
$query->execute();

$result = $query->fetch(PDO::FETCH_ASSOC);
$user_access_id=$result["access"];

$query = $conn->prepare("SELECT * FROM user_access where id='$user_access_id'");
$query->execute();

$result = $query->fetch(PDO::FETCH_ASSOC);

$dj_sets_access=$result["dj_sets_access"];
$mix_tapes_access=$result["mix_tapes_access"];
$episodes_access=$result["episodes_access"];
$admin_access=$result["admin_access"];

}

?>