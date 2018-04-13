<?php
/**
 * Created by PhpStorm.
 * User: sourabh
 * Date: 29/8/16
 * Time: 11:31 PM
 */
 if (!session_id()) {
    session_start();
}
require_once ('fbconfig.php');
require_once __DIR__ . '/vendor/autoload.php';


$helper = $fb->getRedirectLoginHelper();
$_SESSION['FBRLH_state']=$_GET['state'];
try{
    $accessToken = $helper->getAccessToken("https://yourfacebookimages.herokuapp.com/login-callback.php");
 echo "AT: ".$accessToken;
} catch (\Facebook\Exceptions\FacebookResponseException $e){
    // When Graph returns an error
 echo session_id();
    echo 'Graph returned an error : ' .$e->getMessage();
    exit;
} catch (\Facebook\Exceptions\FacebookSDKException $e){
    // When validation fails or other local issues
    echo 'Facebook SDK returned an error : ' .$e->getMessage();
    exit;
}
if(isset($accessToken)){
    // User Logged In !!

     echo "Access Token ".$accessToken; 
    /**When a user first logs into your app, the access token your app receives
     * will be a short-lived access token that lasts about 2 hours.
     * It's generally a good idea to exchange the short-lived access
     * token for a long-lived access token that lasts about 60 days.*/

    // OAuth 2.0 Client Handler
    $oAuth2Client = $fb->getOAuth2Client();
    if( !$accessToken->isLongLived()) {
        // Exchange a short-lived access token for a long lived one !!!
        try {
            $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
            echo "Error for obtaining long-lived token : " .$e->getMessage();
        }
    }
        $_SESSION['facebook_access_token'] = (string) $accessToken;
    header('Location: https://yourfacebookimages.herokuapp.com/index.php');
}
else{
    if ($helper->getError()) {
        header('Location: https://yourfacebookimages.herokuapp.com/index.php');
    } else {
        header('HTTP/1.0 400 Bad Request');
//            echo 'Bad request';
    }
    exit;
}
if(isset($_REQUEST['error'])){
    if(isset($_REQUEST['error_reason']) && $_REQUEST['error_reason']=='user_denied'){
        header('Location: https://yourfacebookimages.herokuapp.com/index.php');
    }
}


