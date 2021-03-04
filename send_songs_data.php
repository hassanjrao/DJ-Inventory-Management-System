<?php


ob_start();
include('includes/db.php');
session_start();

if (empty($_COOKIE['remember_me'])) {

    if (empty($_SESSION['user_id'])) {

        header('location:login.php');
    }
}

if (isset($_POST["submit"])) {


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

    $response_arr[] = null;

    if ($query->rowCount() > 0) {
        $response_arr[0] = '<div class="alert alert-danger alert-dismissible" role="alert">
        <strong>Oops! *This Song Name = ' . $song_name . ', Already Exists! </strong>
        <br><br>
    
       <strong> <a href="all_songs.php">Back to all Songs</a></strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>';

        echo json_encode($response_arr);
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


            $response_arr[0] = ' <div class="alert alert-success alert-dismissible" role="alert">
            <strong>Congrats! Successfully Added</strong> <br><br>
         
            <a href="all_songs.php">Back to All Songs</a>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>';


            $songs = "";



            $query = $conn->prepare("SELECT id,song_name FROM songs ORDER BY id desc");

            $query->execute();

            while ($result = $query->fetch(PDO::FETCH_ASSOC)) {


                $songs .= '<option value="' . $result["id"] . '">' . ucwords($result["song_name"]) . '</option>';
            }





            $response_arr[1] = $songs;



            echo json_encode($response_arr);
        }
    }
}




if (isset($_POST['upd-submit'])) {

    $song_id=$_POST["song_id"];

    $artists_arr = $_POST["artists"];

    $song_name = $_POST["song_name"];
    $project = $_POST["project"];
    $genre = $_POST["genre"];
    $tags = $_POST["tags"];
    $original_bpm = $_POST["original_bpm"];
    $original_key = $_POST["original_key"];
    $viloence_drugs_guns = isset($_POST["viloence_drugs_guns"]) == true ? $_POST["viloence_drugs_guns"] : "no";
    $explicit_lyrical_content = isset($_POST["explicit_lyrical_content"]) == true ? $_POST["explicit_lyrical_content"] : "no";

    $updated_by = $_SESSION["user_id"];





    $query = $conn->prepare("SELECT song_name FROM songs WHERE `song_name` LIKE '$song_name' and id!='$song_id'");
    $query->execute();


    $response_arr[] = null;

    if ($query->rowCount() > 0) {
        $response_arr[0] = '<div class="alert alert-danger alert-dismissible" role="alert">
        <strong>Oops! *This Song Name= ' . $song_name . ', Already Exists! </strong>
        <br><br>
    
       <strong> <a href="all_songs.php">Back to all song Names</a></strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>';

        echo json_encode($response_arr);
    } else {





        $stmt = $conn->prepare("UPDATE `songs` SET song_name=:song_name,project=:project,genre=:genre,tags=:tags,original_bpm=:original_bpm,original_key=:original_key,viloence_drugs_guns=:viloence_drugs_guns,explicit_lyrical_content=:explicit_lyrical_content, updated_by=:updated_by ,updated=CURRENT_TIMESTAMP WHERE id=:id");

        $stmt->bindParam(':song_name', $song_name);
        $stmt->bindParam(':project', $project);
        $stmt->bindParam(':genre', $genre);
        $stmt->bindParam(':tags', $tags);
        $stmt->bindParam(':original_bpm', $original_bpm);
        $stmt->bindParam(':original_key', $original_key);
        $stmt->bindParam(':viloence_drugs_guns', $viloence_drugs_guns);
        $stmt->bindParam(':explicit_lyrical_content', $explicit_lyrical_content);
        $stmt->bindParam(':updated_by', $updated_by);

        $stmt->bindParam(':id', $song_id);

        if ($stmt->execute()) {



            $del = $conn->prepare("DELETE FROM song_artists WHERE song_id='$song_id'");
            $del->execute();

            foreach ($artists_arr as $key => $artist) {

                $stmt = $conn->prepare("INSERT INTO `song_artists`( `song_id`,`artist_id`) VALUES (:song_id,:artist_id)");
                $stmt->bindParam(':song_id', $song_id);
                $stmt->bindParam(':artist_id', $artist);
                $stmt->execute();
            }







            $response_arr[0] = ' <div class="alert alert-success alert-dismissible" role="alert">
    <strong>Congrats! Successfully Updated</strong> <br><br>
   

    <a href="all_songs.php">Back to All Songs</a>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>';

            echo json_encode($response_arr);
        }
    }
}
