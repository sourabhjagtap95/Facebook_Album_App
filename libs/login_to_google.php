<?php
/**
 * Created by PhpStorm.
 * User: sourabh
 * Date: 30/8/16
 * Time: 12:26 AM
 */
?>

<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <title>Facebook Albums</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../libs/resources/css/bootstrap.min.css" />
    <script src="../libs/resources/js/bootstrap.min.js"></script>
    <script src="../libs/resources/js/jquery-2.1.1.min.js"></script>
    <link rel="stylesheet" href="https://blueimp.github.io/Gallery/css/blueimp-gallery.min.css">
    <link rel="stylesheet" href="../libs/resources/gallery_css/bootstrap-image-gallery.min.css">
    <style type="text/css">
        body{
            background-image: url(../libs/resources/images/background.jpg) ;
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

            <a class="navbar-brand" href="index.php">Facebook Album</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs">
            <ul class="nav navbar-nav">
                <li class="active"><a href="../index.php">Home <span class="sr-only">(current)</span></a></li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>

<div class="container">
    <div class="jumbotron">
        <div class="alert alert-danger">
        <h2>
            Sorry !! Cannot provide authentication from Google
        </h2>
            </div>
        <hr>
        </br>
        <div class="alert alert-info">
        <h4>
            As OAuth 1.0 has been replaced by OAuth 2.0 as of April 20,2015 and there are no APIs provided from OAuth 2.0 for Google+(Picasa) Photos.
            Earlier, there used to be Picasa Web Albums Data API Version 1.0 which uses Zend Framework.
            For more information refer <a href="https://developers.google.com/picasa-web/docs/1.0/developers_guide_php">Google Picasa Developer's site</a>
            and <a href="https://support.google.com/a/answer/162106?p=authsub&rd=3">Google OAuth Support</a>
        </h4>
            </div>
        <div class="well text-center">
            <a href="../index.php" class="btn btn-warning btn-lg">Go Back to your Album Page</a>
        </div>
    </div>
</div>
</body>
</html>

