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


    $show_name = $_POST["show_name"];
    $description = $_POST["description"];
    $plateform = $_POST["plateform"];

    $created_by = $_SESSION["user_id"];

    $updated_by = $created_by;


    $query = $conn->prepare("SELECT show_name FROM show_names WHERE `show_name` LIKE '$show_name'");
    $query->execute();


    $response_arr[] = null;

    if ($query->rowCount() > 0) {
        $response_arr[0] = '<div class="alert alert-danger alert-dismissible" role="alert">
    <strong>Oops! *This Show Name= ' . $show_name . ', Already Exists! </strong>
    <br><br>

   <strong> <a href="all_show_names.php">Back to all Show Names</a></strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>';

        echo json_encode($response_arr);
    } else {




        $stmt = $conn->prepare("INSERT INTO `show_names`( `show_name`,`description`,`plateform`,`created_by`,`created`,`updated_by`,`updated`) VALUES (:show_name,:description,:plateform,:created_by ,CURRENT_TIMESTAMP,:updated_by,CURRENT_TIMESTAMP)");


        $stmt->bindParam(':show_name', $show_name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':plateform', $plateform);
        $stmt->bindParam(':created_by', $created_by);
        $stmt->bindParam(':updated_by', $updated_by);

        if ($stmt->execute()) {

            $response_arr[0] = ' <div class="alert alert-success alert-dismissible" role="alert">
    <strong>Congrats!</strong> Successfully Added <br><br>
    <strong> Show Name= ' . $show_name . '</strong> <br>
    <strong> Description = ' . $description . '</strong><br>
    <strong> Plateform = ' . $plateform . '</strong> <br><br>

   <strong> <a href="all_show_names.php">Back to all Show Names</a></strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>';

            echo json_encode($response_arr);
        }
    }
}






if (isset($_POST['upd-submit'])) {


    $show_name = $_POST["show_name"];
    $description = $_POST["description"];
    $plateform = $_POST["plateform"];

    $updated_by = $_SESSION["user_id"];

    $show_name_id = $_POST["show_name_id"];


    $query = $conn->prepare("SELECT show_name FROM show_names WHERE `show_name` LIKE '$show_name' and id!='$show_name_id'");
    $query->execute();


    $response_arr[] = null;

    if ($query->rowCount() > 0) {
        $response_arr[0] = '<div class="alert alert-danger alert-dismissible" role="alert">
        <strong>Oops! *This Show Name= ' . $show_name . ', Already Exists! </strong>
        <br><br>
    
       <strong> <a href="all_show_names.php">Back to all Show Names</a></strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>';

        echo json_encode($response_arr);
    } else {









        $stmt = $conn->prepare("UPDATE `show_names` SET show_name=:show_name, description=:description, plateform=:plateform ,updated_by=:updated_by ,updated=CURRENT_TIMESTAMP WHERE id=:id");


        $stmt->bindParam(':show_name', $show_name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':plateform', $plateform);
        $stmt->bindParam(':updated_by', $updated_by);

        $stmt->bindParam(':id', $show_name_id);





        if ($stmt->execute()) {

            $response_arr[0] = ' <div class="alert alert-success alert-dismissible" role="alert">
    <strong>Congrats! Successfully Updated</strong> <br><br>
    
    <strong> Show Name = ' . $show_name . '</strong> <br>
    <strong> Description = ' . $description . '</strong><br>
    <strong> Plateform = ' . $plateform . '</strong> <br><br>

    <a href="all_show_names.php">Back to all show_names</a>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>';

            echo json_encode($response_arr);
        }
    }
}
