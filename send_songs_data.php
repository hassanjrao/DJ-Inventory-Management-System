<?php


ob_start();
include('includes/db.php');
session_start();

if (empty($_COOKIE['remember_me'])) {

    if (empty($_SESSION['user_id'])) {

        header('location:login.php');
    }
}


$artists_arr = $_POST["artists"];

$song_name = $_POST["song_name"];
$project = $_POST["project"];
$genre = $_POST["genre"];
$tags = $_POST["tags"];
$original_bpm = $_POST["original_bpm"];
$original_key = $_POST["original_key"];
$viloence_drugs_guns = isset($_POST["viloence_drugs_guns"]) == true ? $_POST["viloence_drugs_guns"] : "no";
$explicit_lyrical_content = isset($_POST["explicit_lyrical_content"]) == true ? $_POST["explicit_lyrical_content"] : "no";

$created_by = $_SESSION["user_id"];
$updated_by = $created_by;




$query = $conn->prepare("SELECT song_name FROM songs WHERE `song_name` LIKE '$song_name'");
$query->execute();

if ($query->rowCount() > 0) {
    echo '<div class="alert alert-danger alert-dismissible" role="alert">
    <strong>Oops!</strong> *This Artist Already Exists!
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>';
} else {




    $stmt = $conn->prepare("INSERT INTO `songs`( `song_name`,`project`,`genre`,`tags`,`original_bpm`,`original_key`,`viloence_drugs_guns`,`explicit_lyrical_content`,`created_by`,`updated_by`,`created`,`updated`) 
VALUES (:song_name,:project,:genre,:tags,:original_bpm,:original_key,:viloence_drugs_guns,:explicit_lyrical_content,:created_by,:updated_by ,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP)");


    $stmt->bindParam(':song_name', $song_name);
    $stmt->bindParam(':project', $project);
    $stmt->bindParam(':genre', $genre);
    $stmt->bindParam(':tags', $tags);
    $stmt->bindParam(':original_bpm', $original_bpm);
    $stmt->bindParam(':original_key', $original_key);
    $stmt->bindParam(':viloence_drugs_guns', $viloence_drugs_guns);
    $stmt->bindParam(':explicit_lyrical_content', $explicit_lyrical_content);

    $stmt->bindParam(':created_by', $created_by);
    $stmt->bindParam(':updated_by', $updated_by);

    if ($stmt->execute()) {

        $song_id = $conn->lastInsertId();

        foreach ($artists_arr as $key => $artist) {

            $stmt = $conn->prepare("INSERT INTO `song_artists`( `song_id`,`artist_id`) VALUES (:song_id,:artist_id)");
            $stmt->bindParam(':song_id', $song_id);
            $stmt->bindParam(':artist_id', $artist);
            $stmt->execute();
        }


        echo ' <div class="alert alert-success alert-dismissible" role="alert">
    <strong>Congrats!</strong> Successfully Submit
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>';
    }
}
