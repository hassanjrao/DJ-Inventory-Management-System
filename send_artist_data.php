<?php

ob_start();
include('includes/db.php');
session_start();

if (empty($_COOKIE['remember_me'])) {

    if (empty($_SESSION['user_id'])) {

        header('location:login.php');
    }
}


if (isset($_POST['submit'])) {



    $artist_name = $_POST["artist_name"];
    $created_by = $_SESSION["user_id"];
    $updated_by = $created_by;


    $query = $conn->prepare("SELECT artist_name FROM artists WHERE `artist_name` LIKE '$artist_name'");
    $query->execute();


    $response_arr[] = null;

    if ($query->rowCount() > 0) {
        $response_arr[0] = '<div class="alert alert-danger alert-dismissible" role="alert">
        <strong>Oops! *This Artist= ' . $artist_name . ' Already Exists! </strong>
        <br><br>
        <a href="all_artists.php">Back to all Artists</a>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>';

        echo json_encode($response_arr);
    } else {

        $stmt = $conn->prepare("INSERT INTO `artists`( `artist_name`,`created_by`,`updated_by`,`created`,`updated`) VALUES (:artist_name,:created_by,:updated_by ,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP)");


        $stmt->bindParam(':artist_name', $artist_name);
        $stmt->bindParam(':created_by', $created_by);
        $stmt->bindParam(':updated_by', $updated_by);


        if ($stmt->execute()) {

            $response_arr[0] = ' <div class="alert alert-success alert-dismissible" role="alert">
            <strong>Congrats! Successfully Added</strong> <br><br>
            
            <strong> Artist Name= ' . $artist_name . '</strong> <br><br>

            <a href="all_artists.php">Back to all Artists</a>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>';


            $artists = "";



            $query = $conn->prepare("SELECT id,artist_name FROM artists order by id desc");

            $query->execute();


            while ($result = $query->fetch(PDO::FETCH_ASSOC)) {


                $artists .= '<option value="' . $result["id"] . '">' . ucwords($result["artist_name"]) . '</option>';
            }

            $response_arr[1] = $artists;

            echo json_encode($response_arr);
        }
    }
}






if (isset($_POST['upd-submit'])) {


    $artist_name = $_POST["artist_name"];

    $updated_by = $_SESSION["user_id"];

    $artist_id = $_POST["artist_id"];



    $query = $conn->prepare("SELECT artist_name FROM artists WHERE `artist_name` LIKE '$artist_name' and id!='$artist_id'");
    $query->execute();


    $response_arr[] = null;

    if ($query->rowCount() > 0) {
        $response_arr[0] = '<div class="alert alert-danger alert-dismissible" role="alert">
    <strong>Oops!*This Artist= ' . $artist_name . ' Already Exists! </strong> 
    <br><br>
    <a href="all_artists.php">Back to all Artists</a>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>';

        echo json_encode($response_arr);
    } else {




        $stmt = $conn->prepare("UPDATE `artists` SET artist_name=:artist_name, updated_by=:updated_by ,updated=CURRENT_TIMESTAMP WHERE id=:id");


        $stmt->bindParam(':artist_name', $artist_name);
        $stmt->bindParam(':updated_by', $updated_by);

        $stmt->bindParam(':id', $artist_id);


        if ($stmt->execute()) {

            $response_arr[0] = ' <div class="alert alert-success alert-dismissible" role="alert">
            <strong>Congrats! Successfully Updated</strong> <br><br>
            
            <strong> Artist Name= ' . $artist_name . '</strong> <br><br>

            <a href="all_artists.php">Back to all Artists</a>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>';

            echo json_encode($response_arr);
        }
    }
}
