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

    <title>Add Songs</title>
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

                    <a href="#">Songs</a>
                </li>
                <li class="active">

                    <strong>Add Songs</strong>
                </li>
            </ol>

            <h2>Add Song</h2>
            <br />


            <div class="row">
                <div class="col-md-12">

                <div id="notification-div">
                            </div>
                    <div class="panel panel-primary" data-collapsed="0">

                        <div class="panel-heading">
                            <div class="panel-title">
                                Add song Info
                            </div>

                            <div class="panel-options">
                                <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a>

                            </div>
                        </div>

                        <div class="panel-body">

                           

                            <form role="form" id="song-form" class="form-horizontal form-groups-bordered">


                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label">Song Name</label>

                                    <div class="col-sm-5">
                                        <input type="text" name="song_name" class="form-control" placeholder="Song Name">
                                    </div>
                                </div>



                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Artists</label>

                                    <div class="col-sm-7">
                                        <select multiple="multiple" name="artists[]" class="form-control multi-select" required="">
                                            <?php

                                            $query = $conn->prepare("SELECT id,artist_name FROM artists order by id desc");

                                            $query->execute();

                                            while ($result = $query->fetch(PDO::FETCH_ASSOC)) {

                                            ?>
                                                <option value="<?php echo $result["id"] ?>"><?php echo ucwords($result["artist_name"]) ?></option>
                                            <?php
                                            }


                                            ?>
                                        </select>
                                    </div>
                                </div>






                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Genre</label>

                                    <div class="col-sm-5">
                                        <select class="form-control" name="genre" required="">

                                            <?php

                                            $query = $conn->prepare("SELECT id,name FROM genres");

                                            $query->execute();

                                            while ($result = $query->fetch(PDO::FETCH_ASSOC)) {

                                            ?>
                                                <option value="<?php echo $result["id"] ?>"><?php echo ucwords($result["name"]) ?></option>
                                            <?php
                                            }


                                            ?>

                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Tags</label>

                                    <div class="col-sm-5">

                                        <input type="text" required="" name="tags" placeholder="Add Tags" class="form-control tagsinput" />

                                    </div>
                                </div>



                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-5">
                                        <div class="checkbox">
                                            <label>
                                                <input name="viloence_drugs_guns" value="yes" type="checkbox">References to Violence, Drugs, Guns
                                            </label>
                                        </div>


                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-5">
                                        <div class="checkbox">
                                            <label>
                                                <input name="explicit_lyrical_content" value="yes" type="checkbox">Contains Explicit Lyrical Content

                                            </label>
                                        </div>


                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label">Album/Movie/Poject</label>

                                    <div class="col-sm-5">
                                        <input required="" type="text" name="project" class="form-control" id="field-1" placeholder="Album/Movie/Poject">
                                    </div>
                                </div>





                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label">Original BPM</label>

                                    <div class="col-sm-5">
                                        <input required="" type="number" name="original_bpm" class="form-control" id="field-1" placeholder="Original BPM">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Original Key</label>

                                    <div class="col-sm-5">
                                        <select class="form-control" name="original_key" required="">

                                            <option>1A</option>
                                            <option>1B</option>
                                            <option>2A</option>
                                            <option>2B</option>
                                            <option>3A</option>
                                            <option>3B</option>
                                            <option>4A</option>
                                            <option>4B</option>
                                            <option>5A</option>
                                            <option>5B</option>
                                            <option>6A</option>
                                            <option>6B</option>
                                            <option>7A</option>
                                            <option>7B</option>
                                            <option>8A</option>
                                            <option>8B</option>
                                            <option>9A</option>
                                            <option>9B</option>
                                            <option>10A</option>
                                            <option>10B</option>
                                            <option>11A</option>
                                            <option>11B</option>
                                            <option>12A</option>
                                            <option>12B</option>

                                        </select>
                                    </div>
                                </div>








                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-5">
                                        <button type="submit" onclick="sendFormData()" name="submit" class="btn btn-default">Add song</button>
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


    <!-- Imported styles on this page -->
    <link rel="stylesheet" href="assets/js/select2/select2-bootstrap.css">
    <link rel="stylesheet" href="assets/js/select2/select2.css">
    <link rel="stylesheet" href="assets/js/selectboxit/jquery.selectBoxIt.css">
    <link rel="stylesheet" href="assets/js/daterangepicker/daterangepicker-bs3.css">
    <link rel="stylesheet" href="assets/js/icheck/skins/minimal/_all.css">
    <link rel="stylesheet" href="assets/js/icheck/skins/square/_all.css">
    <link rel="stylesheet" href="assets/js/icheck/skins/flat/_all.css">
    <link rel="stylesheet" href="assets/js/icheck/skins/futurico/futurico.css">
    <link rel="stylesheet" href="assets/js/icheck/skins/polaris/polaris.css">

    <!-- Imported scripts on this page -->
    <script src="assets/js/select2/select2.min.js"></script>
    <script src="assets/js/bootstrap-tagsinput.min.js"></script>
    <script src="assets/js/typeahead.min.js"></script>
    <script src="assets/js/selectboxit/jquery.selectBoxIt.min.js"></script>
    <script src="assets/js/bootstrap-datepicker.js"></script>
    <script src="assets/js/bootstrap-timepicker.min.js"></script>
    <script src="assets/js/bootstrap-colorpicker.min.js"></script>
    <script src="assets/js/moment.min.js"></script>
    <script src="assets/js/daterangepicker/daterangepicker.js"></script>
    <script src="assets/js/jquery.multi-select.js"></script>
    <script src="assets/js/icheck/icheck.min.js"></script>
    <script src="assets/js/neon-chat.js"></script>

    <!-- JavaScripts initializations and stuff -->
    <script src="assets/js/neon-custom.js"></script>


    <!-- Demo Settings -->
    <script src="assets/js/neon-demo.js"></script>


    <script src="assets/js/jquery.validate.min.js"></script>

    <script>
        function sendFormData() {


            $('#song-form').validate({ // initialize the plugin
                ignore: [],

                rules: {

                    song_name: {
                        required: true,

                    },
                    artists: {
                        required: true,

                    },
                    project: {
                        required: true,

                    },

                    tags: {
                        required: true,

                    },
                    original_bpm: {
                        required: true,

                    },



                },
                submitHandler: function(form) { // for demo
                    var form_data = $("#song-form").serialize();





                    $.ajax({
                        type: "POST",
                        url: "send_songs_data.php",
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