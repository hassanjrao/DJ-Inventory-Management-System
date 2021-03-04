<?php
ob_start();
include('includes/db.php');
session_start();

if (empty($_COOKIE['remember_me'])) {

    if (empty($_SESSION['user_id'])) {

        header('location:login.php');
    }
}


if (!in_array(1, $_SESSION["user_access_arr"])  && !in_array(4, $_SESSION["user_access_arr"])) {
    header("location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once("includes/head.php"); ?>

    <title>Edit Artist</title>
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

                    <a href="#">Artists</a>
                </li>
                <li class="active">

                    <strong>Edit Artist</strong>
                </li>
            </ol>

            <h2>Edit Artist</h2>
            <br />


            <div class="row">
                <div class="col-md-12">

                    <div id="notification-div">
                    </div>

                    <div class="panel panel-primary" data-collapsed="0">

                        <div class="panel-heading">
                            <div class="panel-title">
                                Edit Artist Info
                            </div>

                            <div class="panel-options">
                                <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a>

                            </div>
                        </div>

                        <div class="panel-body">



                            <?php

                            $artist_id = $_GET["artist_id"];

                            $query = $conn->prepare(

                                "SELECT artists.* , users.name as user_name
                                    FROM users JOIN artists 
                                    ON artists.created_by=users.id
                                    Where artists.id='$artist_id'"

                            );

                            $query->execute();

                            $result = $query->fetch(PDO::FETCH_ASSOC);

                            ?>




                            <form id="form" class="form-horizontal form-groups-bordered">


                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label">Artist </label>

                                    <div class="col-sm-5">
                                        <input required="" type="text" name="artist_name" value='<?php echo $result["artist_name"]; ?>' class="form-control" id="field-1" placeholder="Artist Name">
                                    </div>
                                </div>

                                <input type="hidden" name="artist_id" value="<?php echo $artist_id ?>">



                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-5">
                                        <button onclick="sendFormData()" type="submit" name="upd-submit" class="btn btn-default">Edit artist</button>
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

    <script src="assets/js/jquery.validate.min.js"></script>

    <script>
        function sendFormData() {


            $('#form').validate({ // initialize the plugin
                ignore: [],

                rules: {

                    artist_name: {
                        required: true,

                    },

                },
                submitHandler: function(form) { // for demo
                    var form_data = $("#form").serialize();

                    $.ajax({
                        type: "POST",
                        url: "send_artist_data.php",
                        data: form_data,
                        cache: false,
                        success: function(data) {
                            var res = $.parseJSON(data);
                            console.log(res);
                            $("#notification-div").html(res[0]);


                            $('html, body').animate({
                                scrollTop: $("#notification-div").offset().top
                            }, 100);
                        }
                    });



                }
            });

            // console.log($("#song-form").validate());


        }
    </script>

</body>

</html>