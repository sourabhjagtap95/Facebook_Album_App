<?php
/**
 * Created by PhpStorm.
 * User: sourabh
 * Date: 30/8/16
 * Time: 12:26 AM
 */
session_start();
require_once 'google-api/vendor/autoload.php';

$client = new Google_Client();
$client->setAuthConfig('user_credentials.json');
$client->setRedirectUri('https://facebookgalleryapp.herokuapp.com/libs/login_to_google.php/');
$client->addScope('https://picasaweb.google.com/data');
$client->setAccessType("offline");
$client->setPrompt('consent');
$client->setIncludeGrantedScopes(true);


if (! isset($_GET['code'])) {
    $auth_url = $client->createAuthUrl();
    header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
} else {
    $client->authenticate($_GET['code']);
    $access_token = $client->getAccessToken();
    $redirect_uri = 'https://facebookgalleryapp.herokuapp.com/libs/move_to_picasa.php';
      $_SESSION['access_token'] = array_values($access_token)[0];   //access_token
    $_SESSION['refresh_token'] = array_values($access_token)[3];    //refresh_token
    header('Location: ' . $redirect_uri);
}
?>

