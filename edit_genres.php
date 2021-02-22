<?php
ob_start();
include('includes/db.php');
session_start();

if (empty($_COOKIE['remember_me'])) {

    if (empty($_SESSION['user_id'])) {

        header('location:login.php');
    }
}
if(!in_array(4,$_SESSION["user_access_arr"])){
	header('location:index.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once("includes/head.php"); ?>

    <title>Edit genere</title>
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

                    <a href="#">Generes</a>
                </li>
                <li class="active">

                    <strong>Edit Genere</strong>
                </li>
            </ol>

            <h2>Edit Genere</h2>
            <br />


            <div class="row">
                <div class="col-md-12">

                    <div class="panel panel-primary" data-collapsed="0">

                        <div class="panel-heading">
                            <div class="panel-title">
                                Edit Genere Info
                            </div>

                            <div class="panel-options">
                                <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a>

                            </div>
                        </div>

                        <div class="panel-body">



                            <?php

                            $genere_id = $_GET["genere_id"];

                            $query = $conn->prepare(

                                "SELECT generes.* , users.name as user_name
                                    FROM users JOIN generes 
                                    ON generes.created_by=users.id
                                    Where generes.id='$genere_id'"

                            );

                            $query->execute();

                            $result = $query->fetch(PDO::FETCH_ASSOC);

                            ?>




                            <form role="form" method="post" class="form-horizontal form-groups-bordered">


                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label">genere Display Name</label>

                                    <div class="col-sm-5">
                                        <input required="" type="text" name="name" value=<?php echo $result["name"]; ?> class="form-control" id="field-1" placeholder="Display Name">
                                    </div>
                                </div>



                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-5">
                                        <button type="submit" name="submit" class="btn btn-default">Edit genere</button>
                                    </div>
                                </div>
                            </form>

                            <?php

                            if (isset($_POST['submit'])) {


                                $genere = $_POST["name"];

                                $created_by = $_SESSION["user_id"];



                                $stmt = $conn->prepare("UPDATE `Generes` SET name=:name, created_by=:created_by ,updated=CURRENT_TIMESTAMP WHERE id=:id");


                                $stmt->bindParam(':name', $genere);
                                $stmt->bindParam(':created_by', $created_by);

                                $stmt->bindParam(':id', $genere_id);

                                if ($stmt->execute()) {

                                    header("location: all_generes.php?status=edit_succ");
                                }
                            }
                            ?>


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