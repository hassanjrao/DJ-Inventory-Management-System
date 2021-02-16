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

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once("includes/head.php"); ?>

    <title>Add Show Names</title>
</head>

<body class="page-body">

    <div class="page-container">
        <!-- add class "sidebar-collapsed" to close sidebar by default, "chat-visible" to make chat appear always -->

        <!-- leftbar starts -->

        <?php include_once("includes/left-bar.php"); ?>

        <!-- leftbar ends -->

        <div class="main-content">

            <div class="row">

                <!-- header starts-->
                <?php include_once("includes/header.php"); ?>
                <!-- header ends -->

            </div>

            <hr />

            <ol class="breadcrumb bc-3">
                <li>
                    <a href="index.php"><i class="fa-home"></i>Home</a>
                </li>
                <li>

                    <a href="#">Show Names</a>
                </li>
                <li class="active">

                    <strong>Add Show Name</strong>
                </li>
            </ol>

            <h2>Add Show Name</h2>
            <br />


            <div class="row">
                <div class="col-md-12">

                    <div class="panel panel-primary" data-collapsed="0">

                        <div class="panel-heading">
                            <div class="panel-title">
                                Add Show Info
                            </div>

                            <div class="panel-options">
                                <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a>

                            </div>
                        </div>

                        <div class="panel-body">

                            <?php

                            if (isset($_POST['submit'])) {



                                $show_name = $_POST["show_name"];
                                $description = $_POST["description"];
                                $plateform = $_POST["plateform"];

                                $created_by = $_SESSION["user_id"];

                                $stmt = $conn->prepare("INSERT INTO `show_names`( `show_name`,`description`,`plateform`,`created_by`,`created`) VALUES (:show_name,:description,:plateform,:created_by ,CURRENT_TIMESTAMP)");


                                $stmt->bindParam(':show_name', $show_name);
                                $stmt->bindParam(':description', $description);
                                $stmt->bindParam(':plateform', $plateform);
                                $stmt->bindParam(':created_by', $created_by);

                                if ($stmt->execute()) {


                            ?>

                                    <br>
                                    <div class="alert alert-success alert-dismissible" role="alert">
                                        <strong>Congrats!</strong> Successfully Submit
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <br>

                                <?php

                                } else {
                                ?>
                                    <br>
                                    <div class="alert alert-danger alert-dismissible" role="alert">
                                        <strong>Oops!</strong> Some Error Occured
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <br>

                            <?php
                                }
                            }

                            ?>


                            <form role="form" method="post" class="form-horizontal form-groups-bordered">


                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label">Show Name</label>

                                    <div class="col-sm-5">
                                        <input required="" type="text" name="show_name" class="form-control" id="field-1" placeholder="Show Name">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label">Show Description</label>

                                    <div class="col-sm-5">
                                        <input required="" type="text" name="description" class="form-control" id="field-1" placeholder="Show Description">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label">Show Plateform</label>

                                    <div class="col-sm-5">
                                        <input required="" type="text" name="plateform" class="form-control" id="field-1" placeholder="Show Plateform">
                                    </div>
                                </div>

                               

                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-5">
                                        <button type="submit" name="submit" class="btn btn-default">Add Show</button>
                                    </div>
                                </div>
                            </form>

                        </div>

                    </div>

                </div>
            </div>





            <!-- Footer starts -->
            <?php include_once("includes/footer.php"); ?>
            <!-- Footer end -->

        </div>




    </div>




    <!-- Bottom scripts (common) -->
    <script src="assets/js/gsap/TweenMax.min.js"></script>
    <script src="assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/joinable.js"></script>
    <script src="assets/js/resizeable.js"></script>
    <script src="assets/js/neon-api.js"></script>


    <!-- Imported scripts on this page -->
    <script src="assets/js/bootstrap-switch.min.js"></script>
    <script src="assets/js/neon-chat.js"></script>


    <!-- JavaScripts initializations and stuff -->
    <script src="assets/js/neon-custom.js"></script>


    <!-- Demo Settings -->
    <script src="assets/js/neon-demo.js"></script>

</body>

</html>