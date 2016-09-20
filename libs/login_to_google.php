<?php
/**
 * Created by PhpStorm.
 * User: sourabh
 * Date: 30/8/16
 * Time: 12:26 AM
 */
session_start();
require_once 'google-api/vendor/autoload.php';

/*$params = array(
    "scope" => "https://picasaweb.google.com/data",
    "response_type" => "code",
    "redirect_uri" => "http://localhost/Facebook_app/libs/login_to_google.php/",
    "client_id" => "792922810897-ft5ntas7278k1fadbtvh2t17g3592u79.apps.googleusercontent.com"
);*/


$client = new Google_Client();
$client->setAuthConfig('user_credentials.json');
$client->setRedirectUri('http://localhost/Facebook_app/libs/login_to_google.php/');
$client->addScope('https://picasaweb.google.com/data');
$client->setAccessType("offline");
$client->setPrompt('consent');
$client->setIncludeGrantedScopes(true);


if (! isset($_GET['code'])) {
    $auth_url = $client->createAuthUrl();
//    echo $auth_url;
    header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
} else {
    $client->authenticate($_GET['code']);
    $access_token = $client->getAccessToken();
    $redirect_uri = 'http://localhost/Facebook_app/libs/move_to_picasa.php';
//    $_SESSION['access_token'] = $access_token->access_token;
//     print_r($access_token);
      $_SESSION['access_token'] = array_values($access_token)[0];   //access_token
    $_SESSION['refresh_token'] = array_values($access_token)[3];    //refresh_token
//    echo $_SESSION['access_token'] . "\n";
//    echo $_SESSION['refresh_token'];
    header('Location: ' . $redirect_uri);
}







//Client-id - 792922810897-ft5ntas7278k1fadbtvh2t17g3592u79.apps.googleusercontent.com
//Client-secret - NUltcfo5_CUYjl2TIVQEyjOn
/*require_once 'Zend/Loader.php';
Zend_Loader::loadClass('Zend_Gdata_Photos');
Zend_Loader::loadClass('Zend_Gdata_ClientLogin');
Zend_Loader::loadClass('Zend_Gdata_AuthSub');*/

/*if(!isset($_GET['code'])) {
    $url = "https://accounts.google.com/o/oauth2/auth";

    $params = array(
        "scope" => "https://picasaweb.google.com/data",
        "response_type" => "code",
        "redirect_uri" => "http://localhost/Facebook_app/libs/login_to_google.php/",
        "client_id" => "792922810897-ft5ntas7278k1fadbtvh2t17g3592u79.apps.googleusercontent.com"
    );
    $request_to = $url . "?" . http_build_query($params);
    header("Location: " . $request_to);
//echo $request_to;
}
if(isset($_GET['code'])){
    $code = $_GET['code'];
//    echo $code;
    $url = "https://accounts.google.com/o/oauth2/token";
    $params = array(
        "code" => $code,
        "redirect_uri" => "http://localhost/Facebook_app/libs/login_to_google.php/",
        "client_id" => "792922810897-ft5ntas7278k1fadbtvh2t17g3592u79.apps.googleusercontent.com",
        "client_secret" => "NUltcfo5_CUYjl2TIVQEyjOn",
        "grant_type" => "authorization_code"
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    $head = curl_exec($ch);
    curl_close($ch);
    echo $head;
    /*$request = new HttpRequest($url,HttpRequest::METH_POST);
    $request->setPostFields($params);
    $request->send();
    $response_obj = json_decode($head);
    echo "Access Token: " .$response_obj->access_token;*/
?>

