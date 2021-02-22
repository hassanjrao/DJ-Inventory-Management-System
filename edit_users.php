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

    <title>Edit User</title>
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

                    <a href="#">Users</a>
                </li>
                <li class="active">

                    <strong>Edit User</strong>
                </li>
            </ol>

            <h2>Edit User</h2>
            <br />


            <div class="row">
                <div class="col-md-12">

                    <div class="panel panel-primary" data-collapsed="0">

                        <div class="panel-heading">
                            <div class="panel-title">
                                Edit User Info
                            </div>

                            <div class="panel-options">
                                <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a>

                            </div>
                        </div>

                        <div class="panel-body">



                            <?php

                            $user_id = $_GET['user_id'];

                            if (isset($_GET["access"])) {
                                $access_id = $_GET["access"];

                                $query = $conn->prepare(
                                    "SELECT
                                   users.*,
                                   access.access,
                                   user_access.user_id,
                                   user_access.access_id
        
                                 FROM users
                                 JOIN user_access
                                   ON users.id = user_access.user_id
                                 JOIN access
                                   ON access.id = user_access.access_id
        
                                WHERE access.id='$access_id' and users.id='$user_id'
                                       "
                                );
                            } else {


                                $query = $conn->prepare(
                                    "SELECT
                                   users.*,
                                   access.access,
                                   user_access.user_id,
                                   user_access.access_id
        
                                 FROM users
                                 JOIN user_access
                                   ON users.id = user_access.user_id
                                 JOIN access
                                   ON access.id = user_access.access_id
        
                                WHERE  users.id='$user_id'
                                       "
                                );
                            }
                            $query->execute();

                            $result = $query->fetch(PDO::FETCH_ASSOC);

                            ?>




                            <form role="form" method="post" class="form-horizontal form-groups-bordered">

                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label">User Email</label>

                                    <div class="col-sm-5">
                                        <input required="" type="email" name="email" value=<?php echo $result["email"]; ?> class="form-control" id="field-1" placeholder="Email">
                                    </div>
                                </div>


                                <!-- <div class="form-group">
                                    <label for="field-3" class="col-sm-3 control-label">User Password</label>

                                    <div class="col-sm-5">
                                        <input required="" type="password" name="password"  class="form-control" id="field-3" placeholder="Password">
                                    </div>
                                </div> -->

                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label">User Display Name</label>

                                    <div class="col-sm-5">
                                        <input required="" type="text" name="name" value=<?php echo $result["name"]; ?> class="form-control" id="field-1" placeholder="Display Name">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label">User Prefix</label>

                                    <div class="col-sm-5">
                                        <input required="" type="text" name="prefix" value=<?php echo $result["prefix"]; ?> class="form-control" id="field-1" placeholder="Prefix">
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Status ID</label>

                                    <div class="col-sm-5">
                                        <select class="form-control" name="status">

                                            <?php
                                            if ($result["status"] == "active") {

                                            ?>
                                                <option selected value="active">Active</option>
                                                <option value="inactive">Inactive</option>
                                            <?php
                                            } else  if ($result["status"] == "inactive") {

                                            ?>
                                                <option selected value="inactive">Inactive</option>
                                                <option value="active">Active</option>

                                            <?php
                                            }
                                            ?>



                                        </select>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-5">

                                        <?php
                                        $query = $conn->prepare("SELECT * FROM user_access where user_id='$user_id'");
                                        $query->execute();

                                        $access_arr = ["dj" => "Manage DJ Sets", "mix_tapes" => "Manage Mix Tapes", "episodes" => "Manage Episodes", "admin" => "Admin"];

                                        while ($result = $query->fetch(PDO::FETCH_ASSOC)) {

                                            if ($result["access_id"] == "1") {

                                                unset($access_arr["dj"]);
                                        ?>

                                                <div class="checkbox">
                                                    <label>

                                                        <input name="dj" value=<?php echo $result["access_id"] ?> checked type="checkbox">Manage DJ Sets
                                                    </label>
                                                </div>
                                            <?php

                                            } else  if ($result["access_id"] == "2") {
                                                unset($access_arr["mix_tapes"]);
                                            ?>

                                                <div class="checkbox">
                                                    <label>

                                                        <input name="mix_tapes" value=<?php echo $result["access_id"] ?> checked type="checkbox">Manage Mix Tapes
                                                    </label>
                                                </div>
                                            <?php

                                            } else  if ($result["access_id"] == "3") {
                                                unset($access_arr["episodes"]);
                                            ?>

                                                <div class="checkbox">
                                                    <label>

                                                        <input name="episodes" value=<?php echo $result["access_id"] ?> checked type="checkbox">Manage Episodes
                                                    </label>
                                                </div>
                                            <?php

                                            } else  if ($result["access_id"] == "4") {
                                                unset($access_arr["admin"]);
                                            ?>

                                                <div class="checkbox">
                                                    <label>

                                                        <input name="admin" value=<?php echo $result["access_id"] ?> checked type="checkbox">Admin
                                                    </label>
                                                </div>
                                            <?php


                                            }


                                            ?>


                                        <?php

                                        }

                                        foreach ($access_arr as $key => $value) {
                                            # code...

                                            if ($key == "dj") {
                                                $val = "1";
                                            } else   if ($key == "mix_tapes") {
                                                $val = "2";
                                            } else if ($key == "episodes") {
                                                $val = "3";
                                            } else if ($key == "admin") {
                                                $val = "4";
                                            }

                                        ?>
                                            <div class="checkbox">
                                                <label>

                                                    <input name="<?php echo $key ?>" value="<?php echo $val ?>" type="checkbox"><?php echo $value ?>
                                                </label>
                                            </div>
                                        <?php
                                        }

                                        ?>

                                    </div>
                                </div>



                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-5">
                                        <button type="submit" name="submit" class="btn btn-default">Edit User</button>
                                    </div>
                                </div>
                            </form>

                            <?php

                            if (isset($_POST['submit'])) {


                                $email = $_POST["email"];

                                $name = $_POST["name"];
                                $prefix = $_POST["prefix"];
                                $status = $_POST["status"];



                                $stmt = $conn->prepare("UPDATE `users` SET email=:email, name=:name, prefix=:prefix,status=:status,updated=CURRENT_TIMESTAMP WHERE id=:id");


                                $stmt->bindParam(':email', $email);
                                $stmt->bindParam(':name', $name);
                                $stmt->bindParam(':prefix', $prefix);
                                $stmt->bindParam(':status', $status);
                                $stmt->bindParam(':id', $user_id);

                                $stmt->execute();

                                $del = $conn->prepare("DELETE FROM user_access WHERE user_id='$user_id'");
                                $del->execute();

                                if (isset($_POST["dj"])) {
                                    $stmt = $conn->prepare("INSERT INTO `user_access`( `user_id`,`access_id`) VALUES (:user_id,:access_id)");

                                    $stmt->bindParam(':user_id', $user_id);
                                    $stmt->bindParam(':access_id', $_POST["dj"]);
                                    $stmt->execute();
                                }


                                if (isset($_POST["mix_tapes"])) {
                                    $stmt = $conn->prepare("INSERT INTO `user_access`( `user_id`,`access_id`) VALUES (:user_id,:access_id)");

                                    $stmt->bindParam(':user_id', $user_id);
                                    $stmt->bindParam(':access_id', $_POST["mix_tapes"]);
                                    $stmt->execute();
                                }


                                if (isset($_POST["episodes"])) {
                                    $stmt = $conn->prepare("INSERT INTO `user_access`( `user_id`,`access_id`) VALUES (:user_id,:access_id)");

                                    $stmt->bindParam(':user_id', $user_id);
                                    $stmt->bindParam(':access_id', $_POST["episodes"]);
                                    $stmt->execute();
                                }


                                if (isset($_POST["admin"])) {
                                    $stmt = $conn->prepare("INSERT INTO `user_access`( `user_id`,`access_id`) VALUES (:user_id,:access_id)");

                                    $stmt->bindParam(':user_id', $user_id);
                                    $stmt->bindParam(':access_id', $_POST["admin"]);
                                    $stmt->execute();
                                }

                                if(isset($_GET["access"])){

                                    header("location: all_users.php?status=edit_succ&access=$access_id");
                                }
                                else{

                                    header("location: all_users.php?status=edit_succ");
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