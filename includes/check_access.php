<?php

$dj_access = false;
$mixtape_access = false;
$episodes_access = false;
$admin_access = false;

$user_id = $_SESSION["user_id"];

$query = $conn->prepare(
	"SELECT access.id as Access_id,access.access 
	 FROM access
	 JOIN user_access
	 ON user_access.access_id=access.id
	 Where user_access.user_id='$user_id'"
);
$query->execute();

while ($result = $query->fetch(PDO::FETCH_ASSOC)) {
	if ($result["Access_id"] == 1) {
		$dj_access = true;
	} 
	else if ($result["Access_id"] == 2) {
		$mixtape_access = true;
	}
	else if ($result["Access_id"] == 3) {
		$episodes_access = true;
	}
	else if ($result["Access_id"] == 4) {
		$admin_access = true;
	}
}
