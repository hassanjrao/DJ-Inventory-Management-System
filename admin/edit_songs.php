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

    <title>Edit Song</title>
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

                    <strong>Edit Song</strong>
                </li>
            </ol>

            <h2>Edit Song</h2>
            <br />


            <div class="row">
                <div class="col-md-12">

                    <div class="panel panel-primary" data-collapsed="0">

                        <div class="panel-heading">
                            <div class="panel-title">
                                Edit Song Info
                            </div>

                            <div class="panel-options">
                                <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a>

                            </div>
                        </div>

                        <div class="panel-body">



                            <?php

                            $song_id = $_GET["song_id"];


                            $query = $conn->prepare(
                                "SELECT songs.*, genres.name as genre_name,genres.id as genre_id, users.name Creator, a.name Modifier
                        FROM songs
                        JOIN genres
                        On songs.genre=genres.id
                        JOIN users
                        ON songs.created_by=users.id
                        JOIN users a
                        ON songs.updated_by=a.id

                        WHERE songs.id='$song_id'
                    "
                            );

                            $query->execute();

                            $result = $query->fetch(PDO::FETCH_ASSOC);

                            ?>




                            <form role="form" method="post" class="form-horizontal form-groups-bordered">


                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label">Song Name</label>

                                    <div class="col-sm-5">
                                        <input required="" type="text" name="song_name" value="<?php echo $result["song_name"]; ?>" class="form-control" id="field-1" placeholder="Song Name">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Artists</label>

                                    <div class="col-sm-5">
                                        <select class="form-control " multiple name="artists[]" required="">

                                            <?php

                                            $query_artist_name = $conn->prepare(
                                                "SELECT artists.id,artists.artist_name 
                                                FROM artists
                                                JOIN song_artists
                                                ON song_artists.artist_id=artists.id
                                                Where song_artists.song_id='$song_id'"
                                            );

                                            $query_artist_name->execute();

                                            $ind = 0;


                                            while ($result_artist_name = $query_artist_name->fetch(PDO::FETCH_ASSOC)) {

                                                $artists_selected_arr[$ind++] = $result_artist_name["id"];
                                            ?>
                                                <option selected value="<?php echo $result_artist_name["id"] ?>"><?php echo ucwords($result_artist_name["artist_name"]) ?></option>
                                                <?php
                                            }

                                            $query_artists = $conn->prepare("SELECT id,artist_name FROM artists");

                                            $query_artists->execute();



                                            while ($result_artists = $query_artists->fetch(PDO::FETCH_ASSOC)) {


                                                if (!in_array($result_artists["id"], $artists_selected_arr)) {

                                                ?>

                                                    <option value="<?php echo $result_artists["id"] ?>"><?php echo ucwords($result_artists["artist_name"]) ?></option>
                                            <?php
                                                }
                                            }

                                            ?>



                                        </select>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label">Album/Movie/Poject</label>

                                    <div class="col-sm-5">
                                        <input required="" type="text" name="project" value="<?php echo $result["project"]; ?>" class="form-control" id="field-1" placeholder="Album/Movie/Poject">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Genre</label>

                                    <div class="col-sm-5">
                                        <select class="form-control" name="genre" required="">
                                            <option selected value="<?php echo $result["genre_id"] ?>"><?php echo ucwords($result["genre_name"]) ?></option>
                                            <?php

                                            $query_genre = $conn->prepare("SELECT id,name FROM genres");

                                            $query_genre->execute();

                                            while ($result_genre = $query_genre->fetch(PDO::FETCH_ASSOC)) {

                                                if ($result["genre_id"] != $result_genre["id"]) {

                                            ?>
                                                    <option value="<?php echo $result_genre["id"] ?>"><?php echo ucwords($result_genre["name"]) ?></option>
                                            <?php
                                                }
                                            }


                                            ?>

                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label">Tags</label>

                                    <div class="col-sm-5">
                                        <input required="" type="text" name="tags" value="<?php echo $result["tags"]; ?>" class="form-control tagsinput" id="field-1" placeholder="Tags">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="field-1" class="col-sm-3 control-label">Original BPM</label>

                                    <div class="col-sm-5">
                                        <input required="" type="number" name="original_bpm" value="<?php echo $result["original_bpm"]; ?>" class="form-control" id="field-1" placeholder="Orignal BPM">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Original Key</label>



                                    <div class="col-sm-5">
                                        <select class="form-control" name="original_key" required="">
                                            <option selected><?php echo $result["original_key"] ?></option>
                                            <?php

                                            $keys_arr = [
                                                "1A",
                                                "1B",
                                                "2A",
                                                "2B",
                                                "3A",
                                                "3B",
                                                "4A",
                                                "4B",
                                                "5A",
                                                "5B",
                                                "6A",
                                                "6B",
                                                "7A",
                                                "7B",
                                                "8A",
                                                "8B",
                                                "9A",
                                                "9B",
                                                "10A",
                                                "10B",
                                                "11A",
                                                "11B",
                                                "12A",
                                                "12B",
                                            ];

                                            foreach ($keys_arr as $key => $value) {
                                                # code...

                                                if ($value != $result["original_key"]) {
                                            ?>
                                                    <option><?php echo $value ?></option>
                                            <?php
                                                }
                                            }


                                            ?>



                                        </select>
                                    </div>
                                </div>



                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-5">
                                        <div class="checkbox">
                                            <label>
                                                <input <?php echo $result["viloence_drugs_guns"] == "yes" ? "checked" : "" ?> name="viloence_drugs_guns" value="yes" type="checkbox">Viloence, Drugs, Guns
                                            </label>
                                        </div>


                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-5">
                                        <div class="checkbox">
                                            <label>
                                                <input <?php echo $result["explicit_lyrical_content"] == "yes" ? "checked" : "" ?> name="explicit_lyrical_content" value="yes" type="checkbox">Explicit Lyrical Content
                                            </label>
                                        </div>


                                    </div>
                                </div>





                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-5">
                                        <button type="submit" name="submit" class="btn btn-default">Edit Song</button>
                                    </div>
                                </div>
                            </form>

                            <?php

                            if (isset($_POST['submit'])) {


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

                                $stmt->execute();



                                $del = $conn->prepare("DELETE FROM song_artists WHERE song_id='$song_id'");
                                $del->execute();

                                foreach ($artists_arr as $key => $artist) {

                                    $stmt = $conn->prepare("INSERT INTO `song_artists`( `song_id`,`artist_id`) VALUES (:song_id,:artist_id)");
                                    $stmt->bindParam(':song_id', $song_id);
                                    $stmt->bindParam(':artist_id', $artist);
                                    $stmt->execute();
                                }


                                header("location: all_songs.php?status=edit_succ");
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

</body>

</html>