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



    $genre = $_POST["name"];

    $created_by = $_SESSION["user_id"];
    $updated_by = $created_by;


    $query = $conn->prepare("SELECT name FROM genres WHERE `name` LIKE '$genre'");
    $query->execute();


    $response_arr[] = null;

    if ($query->rowCount() > 0) {
        $response_arr[0] = '<div class="alert alert-danger alert-dismissible" role="alert">
        <strong>Oops! *This Genre= ' . $genre . ', Already Exists! </strong>
        <br><br>
    
       <strong> <a href="all_genres.php">Back to All Genres</a></strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>';

        echo json_encode($response_arr);
    } else {


        $stmt = $conn->prepare("INSERT INTO `genres`( `name`,`created_by`,`created`,`updated_by`,`updated`) VALUES (:name,:created_by ,CURRENT_TIMESTAMP,:updated_by,CURRENT_TIMESTAMP)");


        $stmt->bindParam(':name', $genre);

        $stmt->bindParam(':created_by', $created_by);
        $stmt->bindParam(':updated_by', $updated_by);


        if ($stmt->execute()) {

            $response_arr[0] = ' <div class="alert alert-success alert-dismissible" role="alert">
    <strong>Congrats! Successfully Added </strong>

    <br><br>
    <strong> Genre = ' . $genre . '</strong> <br><br>
   
    <strong> <a href="all_genres.php">Back to All Genres</a></strong>

    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>';

            echo json_encode($response_arr);
        }
    }
}






if (isset($_POST['upd-submit'])) {

    $genre = $_POST["name"];

    $updated_by = $_SESSION["user_id"];

    $genre_id = $_POST["genre_id"];



    $query = $conn->prepare("SELECT name FROM genres WHERE `name` LIKE '$genre' and id!='$genre_id'");
    $query->execute();


    $response_arr[] = null;

    if ($query->rowCount() > 0) {
        $response_arr[0] = '<div class="alert alert-danger alert-dismissible" role="alert">
        <strong>Oops! *This Genre= ' . $genre . ', Already Exists! </strong>
        <br><br>
    
       <strong> <a href="all_genres.php">Back to All Genres</a></strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>';
        echo json_encode($response_arr);
    } else {






        $stmt = $conn->prepare("UPDATE `genres` SET name=:name, updated_by=:updated_by ,updated=CURRENT_TIMESTAMP WHERE id=:id");


        $stmt->bindParam(':name', $genre);
        $stmt->bindParam(':updated_by', $updated_by);

        $stmt->bindParam(':id', $genre_id);




        if ($stmt->execute()) {

            $response_arr[0] = ' <div class="alert alert-success alert-dismissible" role="alert">
            <strong>Congrats! Successfully Updated</strong> <br><br>
            
            <strong> Genre = ' . $genre . '</strong> <br>
           <br>
            <a href="all_show_names.php">Back to all show_names</a>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>';


            echo json_encode($response_arr);
        }
    }
}
