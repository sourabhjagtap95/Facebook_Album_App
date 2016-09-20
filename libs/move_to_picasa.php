<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <title>Facebook Albums</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="resources/css/bootstrap.min.css" />
    <script src="resources/js/jquery-3.1.0.min.js"></script>
    <script src="resources/js/bootstrap.min.js"></script>
    <style type="text/css">
        body{
            background: url(resources/images/facebook.png) no-repeat center center fixed;
            background-size: cover;

        }
        .logo{
            float: left;
            margin-top: -12px;
        }
        .container-fluid{
            border-bottom-style: solid;
            border-bottom: 1px solid green;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <a class="navbar-brand" href="../index.php">Facebook Album</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs">
            <ul class="nav navbar-nav">
                <li class="active"><a href="../index.php">Home <span class="sr-only">(current)</span></a></li>
            </ul>
            <!-- code for the right side of the navbar -->
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
<?php
/**
 * Created by PhpStorm.
 * User: sourabh
 * Date: 20/9/16
 * Time: 12:58 PM
 */
 // session_start();
require_once 'google-api/vendor/autoload.php';
require_once 'Zend/Loader.php';
require_once ('../fbconfig.php');
require_once ('../vendor/autoload.php');

\Facebook\FacebookSession::setDefaultApplication($app_id,$app_secret);

Zend_Loader::loadClass('Zend_Gdata_Photos');
Zend_Loader::loadClass('Zend_Gdata_ClientLogin');
Zend_Loader::loadClass('Zend_Gdata_AuthSub');

$client1 = new Google_Client();
$client1->setAuthConfigFile('user_credentials.json');
$client1->setAccessType("offline");

if(!isset($_SESSION['access_token'])){
    echo 'if';
    ?>
    <div class="container">
        <div class="jumbotron">
            <div class="row text-center">
                <a class="btn btn-warning btn-lg" href="login_to_google.php">Google</a>
            </div>
        </div>
    </div>
    <?php
}
else{
    echo 'else';
    $client1->setAccessToken($_SESSION['access_token']);

    $client = Zend_Gdata_AuthSub::getHttpClient( $_SESSION['access_token'] );
    $service = new Zend_Gdata_Photos($client);
    $entry = new Zend_Gdata_Photos_AlbumEntry();

    $new_album_name = str_replace( " ", "_", $_SESSION['album_name'] );

    $entry->setTitle($service->newTitle($new_album_name));
    
    $result = $service->insertAlbumEntry($entry);
    $album_id = $result->getGphotoId();

    $fbApp = new \Facebook\FacebookApp($app_id,$app_secret);
    $request_albums_photos = new \Facebook\FacebookRequest($fbApp, $_SESSION['facebook_access_token'], 'GET', '/' . $_SESSION['album_id'] . '/photos?fields=source');
    try {
        $response_albums_photos = $fb->getClient()->sendRequest($request_albums_photos);
    } catch (\Facebook\Exceptions\FacebookResponseException $e) {
        echo "Graph Returned error : " . $e->getMessage();
    } catch (\Facebook\Exceptions\FacebookSDKException $e) {
        // SDK Error
        echo "Facebook SDK error : " . $e->getMessage();
    }

    $albums_photos = $response_albums_photos->getGraphEdge()->asArray();

    function add_new_photos($album_photo,$service,$album_id){
        try {
            $path = dirname(__FILE__) . '/resources/downloaded_photos/' . uniqid();
            copy($album_photo, $path);

            $fd = $service->newMediaFileSource($path);
            $fd->setContentType('image/jpeg');

            $photo_entry = $service->newPhotoEntry();
            $photo_entry->setMediaSource($fd);
            $photo_entry->setTitle($service->newTitle('New Photo'));

            $album_query = $service->newAlbumQuery();
            $album_query->setUser('default');
            $album_query->setAlbumId($album_id);

            $service->insertPhotoEntry($photo_entry, $album_query->getQueryUrl());

            unlink($path);
        } catch (Zend_Gdata_App_Exception $e) {
            echo "Error: " . $e->getResponse();
        }

        

    }

    if (!empty($albums_photos)) {
        $i=0;
        foreach ($albums_photos as $album_photo) {
            $album_photo = (array)$album_photo;
            $i++;
            add_new_photos($album_photo['source'],$service,$album_id);
        }
    }

    ?>
    <div class="container">
        <div class="jumbotron">
            <div class="row text-center">
                <h1>Added Successfully</h1></br>
                <a class="btn btn-primary btn-lg" href="../index.php" >Go Back</a>
            </div>
        </div>
    </div>
<?php
}
echo "no where";
?>
