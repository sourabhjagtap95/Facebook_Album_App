<?php
/**
 * Created by PhpStorm.
 * User: sourabh
 * Date: 28/8/16
 * Time: 9:39 PM
 */
ob_start();
require_once ('fbconfig.php');
require_once __DIR__ . '/vendor/autoload.php';
?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <title>Facebook Albums</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="google-site-verification" content="2uAX5gLSPgsR0L1iM37-eZGUdiH0-rZQtz2-HHlQuoo" />
    <link rel="stylesheet" type="text/css" href="libs/resources/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="https://blueimp.github.io/Gallery/css/blueimp-gallery.min.css"/>
    <link rel="stylesheet" href="libs/resources/gallery_css/bootstrap-image-gallery.min.css"/>
    <script src="//fast.eager.io/cVEwvLt7my.js"></script>
    <style type="text/css">
        @import url(https://fonts.googleapis.com/css?family=Nunito:300);

        body { font-family: "Nunito", sans-serif; font-size: 15px; }
        a    { text-decoration: none; }
        p    { text-align: center; }
        sup  { font-size: 36px; font-weight: 100; line-height: 55px; }

        .button
        {
            text-transform: uppercase;
            letter-spacing: 2px;
            text-align: center;
            color: #0C5;

            font-size: 15px;
            font-family: "Nunito", sans-serif;
            font-weight: 500;

            margin: 5em auto;

            position: inherit;
            top: 50%; right:0; bottom:0; left:0;

            padding: 20px 10px;
            width: 300px;
            height:60px;

            background: #0C5;
            border: 2px solid #0D6;
            border-radius: 10px;
            color: #FFF;
            overflow: hidden;

            transition: all 0.5s;
        }

        .button:hover, .button:active
        {
            text-decoration: none;
            color: black;
            border-color: #0C5;
            background: #FFFFFF;
        }

        .button span
        {
            display: inline-block;
            position: relative;
            padding-right: 0;

            transition: padding-right 0.5s;
        }

        .button span:after
        {
            content: ' ';
            position: absolute;
            top: 0;
            right: -18px;
            opacity: 0;
            width: 10px;
            height: 10px;
            margin-top: -6px;

            background: rgba(0, 0, 0, 0);
            border: 3px solid #FFF;
            border-top: none;
            border-right: none;

            transition: opacity 0.5s, top 0.5s, right 0.5s;
            transform: rotate(-135deg);
        }

        .button:hover span, .button:active span
        {
            padding-right: 30px;
        }

        .button:hover span:after, .button:active span:after
        {
            transition: opacity 0.5s, top 0.5s, right 0.5s;
            opacity: 1;
            border-color: #0C5;
            right: 0;
            top: 50%;
        }
        body{
            background: url('https://themechangers.files.wordpress.com/2014/11/website-design-background1.png') no-repeat center center fixed;
            background-size: cover;
            background-repeat: no-repeat;
        }
        .logo{
            float: left;
            margin-top: -12px;
        }
        .container-fluid{
            border-bottom-style: solid;
            border-bottom: 1px solid green;
        }
        .footer{
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 60px;
            background-color: #f5f5f5;
            display: block;
        }

    </style>
</head>
<body>
<?php

\Facebook\FacebookSession::setDefaultApplication($app_id,$app_secret);

$helper = $fb->getRedirectLoginHelper(); /*The FacebookRedirectLoginHelper
                                           makes use of sessions to store a CSRF value.*/


$permissions = ['email','user_photos'];
$login_url = $helper->getLoginUrl('https://'.$_SERVER['SERVER_NAME'].'/login-callback.php',$permissions);



if(!empty($_SESSION['facebook_access_token']) && isset($_SESSION['facebook_access_token'])) {

    $accessToken = $_SESSION['facebook_access_token'];

    $fbApp = new \Facebook\FacebookApp($app_id,$app_secret);
    $request = new \Facebook\FacebookRequest( $fbApp,$accessToken, 'GET', '/me?fields=id,name' );

    try{
        $response = $fb->getClient()->sendRequest($request);
    } catch (\Facebook\Exceptions\FacebookResponseException $e){
        // When Graph returns an error
        echo "Graph returned an error : " .$e->getMessage();
        exit;
    } catch (\Facebook\Exceptions\FacebookSDKException $e){
        // When  Validation fails or some other issues
        echo "Facebook SDK returned an error : " .$e->getMessage();
        exit;
    }

    $user = $response->getGraphUser();

    $user_id = $user['id'];
    $user_name = $user['name'];
    //echo $user_id;
    //echo $user_name;
    ?>
    <nav class="navbar navbar-default" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <a class="navbar-brand" href="index.php">Facebook Album</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs">
                <ul class="nav navbar-nav">
                    <li><a href="index.php">Home <span class="sr-only">(current)</span></a></li>
                </ul>
                <!-- code for the right side of the navbar -->
                <div class="nav navbar-nav navbar-right">
                    <div class="dropdown">
                        <button class="btn btn-success dropdown-toggle" id="menu1" type="button" data-toggle="dropdown">
                            <?php $user_photo = 'https://graph.facebook.com/'.$user_id.'/picture';?>
                            <img src="<?php echo $user_photo;?>" id="user_photo" class="img-circle" />
                            <strong><?php echo $user_name;?></strong>
                            <span class="caret"></span>
                        </button>
                        <!--                   <a href="logout.php"  class="btn btn-lg btn-danger">Logout</a>-->
                        <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                            <li><a href="logout.php" style="padding: 20px; color: red; ">Log out</a></li>
                        </ul>
                    </div>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
    </nav>

    <!--    Main Body-->

    <div class="container">
    <div class="panel-group">
    <div class="panel panel-primary">
    <div class="panel-heading">Facebook Photo Album</div>
    <div class="panel-body" style="margin: 10px;">

    <div class="row">

    <!-- The Bootstrap Image Gallery lightbox, should be a child element of the document body -->
    <div id="blueimp-gallery" class="blueimp-gallery">
        <!-- The container for the modal slides -->
        <div class="slides"></div>
        <!-- Controls for the borderless lightbox -->
        <h3 class="title"></h3>
        <a class="prev">‹</a>
        <a class="next">›</a>
        <a class="close">×</a>
        <a class="play-pause"></a>
        <ol class="indicator"></ol>
        <!-- The modal dialog, which will be used to wrap the lightbox content -->
        <div class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" aria-hidden="true">&times;</button>
                        <h4 class="modal-title"></h4>
                    </div>
                    <div class="modal-body next"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left prev">
                            <span class="glyphicon glyphicon-chevron-left"></span>
                            Previous
                        </button>
                        <button type="button" class="btn btn-primary next">
                            Next
                            <i class="glyphicon glyphicon-chevron-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    // Graph API Request

    $request_albums = new \Facebook\FacebookRequest( $fbApp,$accessToken, 'GET', '/'.$user['id'].'/albums?fields=id,cover_photo,from,name');//'/me/albums?fields=id,cover_photo,from,name');

    try{
        $response_albums = $fb->getClient()->sendRequest($request_albums);
    } catch (\Facebook\Exceptions\FacebookResponseException $e){
        // Graph error as usual !!
        echo "Graph Returned error : " .$e->getMessage();
    } catch (\Facebook\Exceptions\FacebookSDKException $e){
        // SDK Error
        echo "Facebook SDK error : " .$e->getMessage();
    }
    $user_albums = $response_albums->getGraphEdge();
    $user_albums = json_decode($user_albums,true);

    $_GET['user_albums_download'] = $user_albums;
    if(!empty($user_albums)) {
        ?>
        <h2>Facebook Photo Album</h2>
        <ul class="nav nav-tabs">
            <?php
            foreach ($user_albums as $album) {
                ?>
                <li>
                    <a href='?album_name=<?php echo $album['name']; ?>&album_id=<?php echo $album['id']; ?>'><?php echo $album['name']; ?></a>
                </li>
                <?php
            }
            ?>
        </ul>
        <div class="tab-content">
        <?php
    if (isset($_GET['album_name'])){
        $album_name = $_GET['album_name'];
        ?>
        <div id="<?php echo $album_name ?>" class="tab-pane fade in active">
        <h3><?php echo $_GET['album_name']; ?></h3>
        <p>
            <?php
            foreach ($user_albums as $album){
            $album = (array)$album;

            $request_albums_photos = new \Facebook\FacebookRequest($fbApp, $accessToken, 'GET', '/' . $album['id'] . '/photos?fields=source');
            try {
                $response_albums_photos = $fb->getClient()->sendRequest($request_albums_photos);
            } catch (\Facebook\Exceptions\FacebookResponseException $e) {
                echo "Graph Returned error : " . $e->getMessage();
            } catch (\Facebook\Exceptions\FacebookSDKException $e) {
                // SDK Error
                echo "Facebook SDK error : " . $e->getMessage();
            }

            $albums_photos = $response_albums_photos->getGraphEdge()->asArray();
            //                                        echo die($albums_photos_download);

            if (!empty($albums_photos)) {
            foreach ($albums_photos as $album_photo) {

            $album_photo = (array)$album_photo;
            $album_cover_photo = $album_photo['source'];
            //                                        echo $album_photo['source'];
            if ($album_name == $album['name']){
            ?>
        <div class="col-md-4">
            <ul id="<?php echo $album['id']; ?>"
                class="list-unstyled row albm-thmb thmb-light">
                <li data-src="<?php echo $album_cover_photo; ?>">
                    <div class="thumbnail no-border center" style="box-shadow: 0px 0px 30px -2px rgba(0,0,0,0.75); margin:10px; border-radius:10px;">
                        <div id="links">

                            <a href="<?php echo $album_photo['source']; ?>"
                               rel="<?php echo $album['id']; ?>"
                               title="<?php echo $album['name']; ?>"
                               data-gallery>
                                <img
                                    src="<?php echo $album_cover_photo; ?>"
                                    class="thm img-responsive img-rounded"
                                    alt="<?php echo $album['name']; ?>"
                                    style="height: 200px; width: 200px;"/>
                            </a>
                            <div class="caption">
                                <div class="well">
                                    <div class="text-center">
                                        <form method="post" action="#">
                                            <input type="checkbox" class="photo_selected"
                                                   name="checkbox[]"
                                                   value="<?php echo $album_photo['source']; ?>"/>&nbsp;Select

                                            <!--<a href="#" title="Move to Picasa"
                                               class="btn btn-md btn-primary"><span
                                                    class="glyphicon glyphicon-new-window"></span></a>-->
                                            <a href="<?php echo $album_photo['source']; ?>" download
                                               title="Download" class="btn btn-md btn-success pull-right"><span
                                                    class="glyphicon glyphicon-download"></span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>

        </div>
        <?php
    }
    }
    }

    }
    }
        if (isset($_GET['album_name'])) {
            ?>
            </p>
            </div>
            </div>

            </div>
            <div class="well text-center">
                <button class="btn btn-lg btn-success" name="download_button"><span
                        class="glyphicon glyphicon-download"></span>&nbsp;Download Selected
                </button>
                <button class="btn btn-lg btn-info" name="download_button_all"><span
                        class="glyphicon glyphicon-download-alt"></span>&nbsp;Download All
                </button>
                <button class="btn btn-lg btn-warning" name="move_album_picasa"><span
                        class="glyphicon glyphicon-new-window"></span>&nbsp;Move Album to Picasa
                </button>
            </div>
            </form>
            </div>
            </div>

            </div>
            </div>


            <?php
        }
    }
    if(!isset($_GET['album_name'])){
        echo "<div class='text-center jumbotron'><h2>Select an Album</h2></div>";
    }
}
else
{
    ?>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <a class="navbar-brand" href="index.php">Facebook Album</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="index.php">Home <span class="sr-only">(current)</span></a></li>
                    <li><a href="#about" role="button" data-toggle="modal">About</a></li>
                </ul>
                <!-- code for the right side of the navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#contact" role="button" data-toggle="modal">Contact Me</a>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>

    <!-- Modal Contact-->
    <div class="modal fade" id="contact" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Social Links</h4>
                </div>
                <div class="modal-body">
                    <p><a href="https://www.facebook.com/sourabhjagtap08" target="_blank"><img src="http://marketingland.com/wp-content/ml-loads/2013/04/Facebook-Home-Logo-300x300.png" class="img-circle" style="height: 60px; width: 60px;"></a>
                        <a href="https://in.linkedin.com/in/sourabh-jagtap-b4a394b3" target="_blank"><img src="https://cdn3.iconfinder.com/data/icons/free-social-icons/67/linkedin_circle_color-512.png" class="img-circle" style="height: 65px; width: 65px;"></a>
                        <a href="https://github.com/sourabhjagtap95" target="_blank"><img src="https://assets-cdn.github.com/images/modules/logos_page/GitHub-Mark.png" class="img-circle" style="height: 75px; width: 75px;"></a>
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
    <!-- Modal About-->
    <div class="modal fade" id="about" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">About this Challenge</h4>
                </div>
                <div class="modal-body">
                    <p>
                    <h4>This is an assignment given by <a href="https://careers.rtcamp.com/web-developers/assignments/#facebook-challenge">RTCamp</a>
                        which displays all of your facebook photos from facebook album and allows you to download each photo of a particular album.</h4>
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>

    <div class="container">
        <div class="text-center">
            <h2 style="font-size: 75px; color: #0DF; margin-bottom: 50px;">Facebook Album App</h2>
            <div style="padding-top: 100px;">
                <a class="button"  href="<?php echo $login_url;?>"><span>Connect with Facebook</span></a>
            </div>
        </div>

    </div>

    <?php
}
?>
<?php
if(isset($_POST['download_button'])) {
    if (isset($_POST['checkbox'])) {
        $photos = $_POST['checkbox'];
        $photos_directory = "libs/resources/downloaded_photos/album_photos/";
        $zip = new ZipArchive();
        $zip_folder = "libs/resources/downloaded_photos/album_photos/".uniqid();
        $zip_status = $zip->open($zip_folder,ZipArchive::CREATE);
        foreach ($photos as $photo_selected) {
            $photos_directory = "libs/resources/downloaded_photos/album_photos";
            if (!file_exists($photos_directory))
                mkdir($photos_directory, 0777);
            else {
                if($zip_status) {
                    $zip->addFromString(uniqid(),file_get_contents($photo_selected));
                }
            }
        }
        $zip->close();
        header('Content-Disposition: attachment; filename="save_as.zip"');
        header('Content-type: application/zip');
        readfile($zip_folder);
    }
    else
        echo "<script>alert('Please select a photo');</script>";
}

else if(isset($_POST['download_button_all'])) {

    $zip = new ZipArchive();
    $zip_folder = "libs/resources/downloaded_photos/album_photos/".uniqid();
    $zip_status = $zip->open($zip_folder,ZipArchive::CREATE);
    $user_albums_download = $_GET['user_albums_download'];
    foreach ($user_albums_download as $album) {
        if ($album['name'] == $album_name) {
            $album = (array)$album;
            $request_albums_photos = new \Facebook\FacebookRequest($fbApp, $accessToken, 'GET', '/' . $album['id'] . '/photos?fields=source');
            try {
                $response_albums_photos = $fb->getClient()->sendRequest($request_albums_photos);
            } catch (\Facebook\Exceptions\FacebookResponseException $e) {
                echo "Graph Returned error : " . $e->getMessage();
            } catch (\Facebook\Exceptions\FacebookSDKException $e) {
                // SDK Error
                echo "Facebook SDK error : " . $e->getMessage();
            }

            $albums_photos = $response_albums_photos->getGraphEdge()->asArray();

            if (!empty($albums_photos)) {

                foreach ($albums_photos as $albums_photo_all) {
                    $photos_directory = "libs/resources/downloaded_photos/album_photos";
                    if (!file_exists($photos_directory))
                        mkdir($photos_directory, 0777);
                    else {
                        if($zip_status) {
                            $zip->addFromString(uniqid(),file_get_contents($albums_photo_all['source']));
//                                            file_put_contents($photos_directory . "/" . uniqid() . ".jpg", fopen($albums_photo_all['source'], 'r'));
                        }


                    }
                }
                $zip->close();
                header('Content-type: application/octet-stream');
                header('Content-Disposition: attachment; filename="All_Photos.ZIP"');
                readfile($zip_folder);
            }
        }
    }

}
else if(isset($_POST['move_album_picasa'])){
    if(!isset($_GET['google_session'])){
        echo "<script>window.location.href='libs/move_to_picasa.php';</script>";
    }
}




?>
<script src="libs/resources/js/jquery-3.1.0.min.js"></script>
<script src="libs/resources/js/bootstrap.min.js"></script>
<script src="//blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>
<!--<script src="libs/resources/gallery_js/bootstrap-image-gallery.min.js"></script>-->
</body>
</html>
